<?php
require_once 'modele/modeleFichiers.php';

function afficherPageTeleversement()
{
    require 'vue/televersement.php';
}

function afficherPageFichiers()
{
    bloquerSiNonConnecte();

    $requeteFichiers = ModeleFichiers::obtenirFichiers($_SESSION['utilisateur']['id']);

    require 'vue/fichiers.php';
}

function validerDonneesTeleverserFichier()
{
    $erreurs = [];

    if (empty($_FILES['fichier']) || $_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
        $erreurs[] = "Erreur lors du téléversement du fichier.";
    } else {
        // Vérifier la taille du fichier (exemple : max 2MB)
        if ($_FILES['fichier']['size'] > 2 * 1024 * 1024) {
            $erreurs[] = "Le fichier est trop volumineux. Taille maximale : 2MB.";
        }

        // Vérifier le type de fichier (exemple : autoriser uniquement les images)
        $extensionsAutorisees = ['jpg', 'png', 'gif', 'webp'];
        $extension = pathinfo($_FILES["fichier"]["name"])['extension'];
        if (!in_array(strtolower($extension), $extensionsAutorisees)) {
            $erreurs[] = "Type de fichier non autorisé. Types autorisés : " . implode(", ", $extensionsAutorisees) . ".";
        }
    }

    return $erreurs;
}

function televerserFichier()
{
    bloquerSiNonConnecte();

    $erreurs = validerDonneesTeleverserFichier();
    if (!empty($erreurs)) {
        retournerMessageErreurSession($erreurs, 'afficherPageTeleversement');
    }

    $connexion = BD::ObtenirConnexion();
    try {
        $fichier = $_FILES['fichier'];
        // Récupérer le nom original du fichier
        // Utiliser basename pour éviter les attaques de type Path Traversal
        // https://owasp.org/www-community/attacks/Path_Traversal
        $nomOriginal = basename($fichier['name']);
        // Générer un nom unique pour éviter les conflits
        do {
            $nomGenere = uniqid('', true);
            $chemin = 'televersements/' . $nomGenere . '.' . pathinfo($nomOriginal)['extension'];
        } while (file_exists($chemin));

        // Déplacer le fichier vers le répertoire de destination
        if (!move_uploaded_file($fichier['tmp_name'], $chemin)) {
            $erreurs[] = "Échec du déplacement du fichier téléversé.";
            retournerMessageErreurSession($erreurs, 'afficherPageTeleversement');
        }
        // Utilisation d'une transaction pour garantir l'intégrité des données
        $connexion->beginTransaction();
        // Tentative d'ajout des informations du fichier dans la base de données
        modeleFichiers::ajouterFichier($_SESSION['utilisateur']['id'], $nomOriginal, $chemin);
        // Validation finale de la transaction
        $connexion->commit();
    } catch (PDOException $e) {
        // En cas d'erreur lors de l'insertion en base de données, supprimer le fichier téléversé
        if (isset($chemin) && file_exists($chemin)) {
            unlink($chemin);
        }
        // En cas d'erreur, annulation des changements SQL
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }
        retournerMessageErreurSession(['Une erreur est survenue lors de l\'ajout du fichier.'], 'afficherPageTeleversement');
    }

    // Rediriger vers la page des fichiers après le téléversement réussi
    header('Location: index.php?action=afficherPageFichiers');
}

function telechargerFichier()
{
    bloquerSiNonConnecte();

    // Vérifier que l'ID du fichier est fourni dans l'URL et valide
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        http_response_code(400);
        exit;
    }

    $requeteFichiers = ModeleFichiers::obtenirFichier($_GET['id']);
    $fichier = $requeteFichiers->fetch();

    // Vérifier si le fichier existe et appartient à l'utilisateur connecté
    if (!$fichier || $fichier['utilisateurs_id'] != $_SESSION['utilisateur']['id']) {
        http_response_code(404);
        exit;
    }

    // Envoyer les en-têtes appropriés pour le téléchargement
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fichier['nom_original']) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fichier['chemin_fichier']));

    // Lire le fichier et l'envoyer au navigateur
    readfile($fichier['chemin_fichier']);
}
