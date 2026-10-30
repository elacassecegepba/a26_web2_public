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

    return $erreurs;
}

function televerserFichier()
{
    bloquerSiNonConnecte();

    $erreurs = validerDonneesTeleverserFichier();
    if (!empty($erreurs)) {
        retournerMessageErreurSession($erreurs, 'afficherPageTeleversement');
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
}
