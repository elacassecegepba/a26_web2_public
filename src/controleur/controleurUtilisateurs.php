<?php
require_once "modele/modeleUtilisateurs.php";

function afficherPageConnexion()
{
    require 'vue/connexion.php';
}

function afficherPageInscription()
{
    require 'vue/inscription.php';
}

function afficherPageProfil()
{
    bloquerSiNonConnecte();

    // Afficher la page de profil
    require 'vue/profil.php';
}

function validerDonneesAuthentification()
{
    $erreurs = [];
    if (empty($_POST['nom']) || mb_strlen($_POST['nom']) < 3 || mb_strlen($_POST['nom']) > 45) {
        $erreurs[] = 'Le nom d\'utilisateur est requis et doit contenir entre 3 et 45 caractères.';
    }
    if (empty($_POST['motDePasse']) || mb_strlen($_POST['motDePasse']) < 6 || mb_strlen($_POST['motDePasse']) > 45) {
        $erreurs[] = 'Le mot de passe est requis et doit contenir entre 6 et 45 caractères.';
    }
    return $erreurs;
}

function connecter()
{
    $erreurs = validerDonneesAuthentification();
    if (!empty($erreurs)) {
        retournerMessageErreurAJAX($erreurs);
    }

    // Vérification des informations d'identification
    $requeteUtilisateurs = ModeleUtilisateurs::obtenirUtilisateur($_POST['nom']);
    $utilisateur = $requeteUtilisateurs->fetch();
    if (!$utilisateur || !password_verify($_POST['motDePasse'], $utilisateur['mot_de_passe'])) {
        retournerMessageErreurAJAX(['Nom d\'utilisateur ou mot de passe incorrect.']);
    }

    // Stocker les informations de l'utilisateur dans la session
    $_SESSION['utilisateur'] = $utilisateur;
}

function inscrire()
{
    $erreurs = validerDonneesAuthentification();
    if (!empty($erreurs)) {
        retournerMessageErreurAJAX($erreurs);
    }

    $connexion = BD::ObtenirConnexion();
    try {
        // Utilisation d'une transaction pour garantir l'intégrité des données
        $connexion->beginTransaction();
        // Tentative d'ajout de l'utilisateur dans la base de données
        ModeleUtilisateurs::ajouterUtilisateur($_POST['nom'], password_hash($_POST['motDePasse'], PASSWORD_DEFAULT));
        // Validation finale de la transaction
        $connexion->commit();
        // Après une inscription réussie, connecter automatiquement l'utilisateur
        connecter();
    } catch (PDOException $e) {
        // En cas d'erreur, annulation des changements SQL
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }
        // Gérer l'erreur, par exemple si le nom d'utilisateur est déjà pris
        retournerMessageErreurAJAX(['Le nom d\'utilisateur est déjà pris. Veuillez en choisir un autre.']);
    }
}

function deconnecter()
{
    // Vider les données de la session
    session_unset();
    // Détruire la session pour déconnecter l'utilisateur
    session_destroy();
    // Rediriger vers la page d'accueil après la déconnexion
    header('Location: index.php?action=afficherPageAccueil');
    exit;
}

// Fonction pour valider une URL. Fonctionne avec les URL contenant des caractères spéciaux comme les accents.
function validerUrl(string $url)
{
    $path = parse_url($url, PHP_URL_PATH);
    $encoded_path = array_map('urlencode', explode('/', $path));
    $url = str_replace($path, implode('/', $encoded_path), $url);

    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}

function validerDonneesProfil()
{
    $erreurs = [];
    if (empty($_POST['nomUtilisateur']) || mb_strlen($_POST['nomUtilisateur']) < 3 || mb_strlen($_POST['nomUtilisateur']) > 45) {
        $erreurs[] = 'Le nom d\'utilisateur est requis et doit contenir entre 3 et 45 caractères.';
    }
    if (
        // Valider seulement si le champ n'est pas vide. Le champ est optionnel.
        !empty($_POST['email']) && (
            !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
            || mb_strlen($_POST['email']) > 255
        )
    ) {
        $erreurs[] = 'Veuillez entrer une adresse email valide.';
    }
    if (
        // Valider seulement si le champ n'est pas vide. Le champ est optionnel.
        !empty($_POST['image']) && (
            !validerUrl($_POST['image'])
            || mb_strlen($_POST['image']) > 2048
        )
    ) {
        $erreurs[] = 'Veuillez entrer une URL d\'image valide.';
    }
    return $erreurs;
}

function modifierProfil()
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    $erreurs = validerDonneesProfil();
    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageProfil');
        exit;
    }

    $connexion = BD::ObtenirConnexion();
    try {
        // Utilisation d'une transaction pour garantir l'intégrité des données
        $connexion->beginTransaction();
        // Tentative de mise à jour des informations de l'utilisateur dans la base de données
        ModeleUtilisateurs::mettreAJourUtilisateur(
            $_SESSION['utilisateur']['id'],
            $_POST['nomUtilisateur'],
            empty($_POST['email']) ? null : $_POST['email'], // Utiliser null si le champ est vide
            empty($_POST['image']) ? null : $_POST['image']  // Utiliser null si le champ est vide
        );
        // Validation finale de la transaction
        $connexion->commit();
        $_SESSION['utilisateur']['nom'] = $_POST['nomUtilisateur'];
        $_SESSION['utilisateur']['email'] = $_POST['email'] ?? ''; // Si email n'est pas fourni, le définir à une chaîne vide
        $_SESSION['utilisateur']['image'] = $_POST['image'] ?? ''; // Si image n'est pas fourni, le définir à une chaîne vide

        // Rediriger vers la page du profil après la modification
        header('Location: index.php?action=afficherPageProfil');
    } catch (PDOException $e) {
        // En cas d'erreur, annulation des changements SQL
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }
        // Gérer l'erreur, par exemple si le nom d'utilisateur est déjà pris
        $_SESSION['erreurs'] = ['Le nom d\'utilisateur est déjà pris. Veuillez en choisir un autre.'];
        header('Location: index.php?action=afficherPageInscription');
    }
}
