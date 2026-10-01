<?php
require_once "modele/modeleArticles.php";
require_once "modele/modeleImagesArticles.php";

function afficherPageArticles()
{
    if (!isset($_GET['articleId'])) {
        $filtreTitre = "";
        if (isset($_POST['filtreTitre'])) {
            if ($_POST['filtreTitre'] == "") {
                // Effacer le filtre si l'utilisateur soumet une recherche vide
                unset($_SESSION['filtreTitre']);
            } else {
                // Enregistrement du filtre dans la session
                $_SESSION['filtreTitre'] = $_POST['filtreTitre'];
            }
        }
        
        // Récupération du filtre conservé en session (s'il existe)
        if (isset($_SESSION['filtreTitre'])) {
            $filtreTitre = $_SESSION['filtreTitre'];
        }
        $requeteArticles = ModeleArticles::obtenirArticles($filtreTitre);
        require 'vue/articles.php';
        exit;
    }

    // Récupération de l'article spécifique
    $article = ModeleArticles::obtenirArticle($_GET['articleId'])->fetch();
    // Si l'article n'existe pas en base de données, redirection vers la liste
    if ($article === false) {
        header('Location: index.php?action=afficherPageArticles');
        exit;
    }
    // Décoder les images JSON en tableau PHP
    $article['images'] = json_decode($article['images'], true);
    require 'vue/articleDetails.php';
}

function afficherPageNouvelArticle()
{
    require 'vue/nouvelArticle.php';
}

function validerDonneesAjouterArticle()
{
    $erreurs = [];
    if (empty($_POST['titre']) || mb_strlen($_POST['titre']) > 255) {
        $erreurs[] = 'Le titre est obligatoire (maximum 255 caractères).';
    }
    if (empty($_POST['resume']) || mb_strlen($_POST['resume']) > 4096) {
        $erreurs[] = 'Le résumé est obligatoire (maximum 4096 caractères).';
    }
    if (empty($_POST['contenu']) || mb_strlen($_POST['contenu']) > 65535) {
        $erreurs[] = 'Le contenu est obligatoire (maximum 65535 caractères).';
    }
    if (isset($_POST['images'])) {
        if (!is_array($_POST['images'])) {
            $erreurs[] = 'Les images doivent être un tableau.';
        } else {
            foreach ($_POST['images'] as $urlImage) {
                if (empty($urlImage)) {
                    $erreurs[] = 'L\'URL de l\'image ne peut pas être vide.';
                } elseif (!filter_var($urlImage, FILTER_VALIDATE_URL)) {
                    $erreurs[] = 'L\'URL de l\'image n\'est pas valide : ' . htmlspecialchars($urlImage);
                }
            }
        }
    }
    return $erreurs;
}

function ajouterArticle()
{
    if (!isset($_SESSION['utilisateur'])) {
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    $erreurs = validerDonneesAjouterArticle();
    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageNouvelArticle');
        exit;
    }

    $connexion = BD::ObtenirConnexion();

    try {
        // Utilisation d'une transaction pour garantir l'intégrité des données
        $connexion->beginTransaction();

        // Insertion de l'article principal
        $articleId = ModeleArticles::ajouterArticle(
            $_POST['titre'],
            $_POST['resume'],
            $_POST['contenu'],
            $_SESSION['utilisateur']['id']
        );

        // Insertion des images associées (si présentes)
        if (isset($_POST['images']) && is_array($_POST['images'])) {
            foreach ($_POST['images'] as $urlImage) {
                ModeleImagesArticles::ajouterImageArticle($urlImage, $articleId);
            }
        }

        // Validation finale de la transaction
        $connexion->commit();

        // Redirection en cas de succès
        header('Location: index.php?action=afficherPageArticles');
        exit;
    } catch (Exception $e) {
        // En cas d'erreur, annulation des changements SQL
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }

        $_SESSION['erreurs'] = ["Une erreur est survenue lors de la création de l'article."];
        header('Location: index.php?action=afficherPageNouvelArticle');
        exit;
    }
}
