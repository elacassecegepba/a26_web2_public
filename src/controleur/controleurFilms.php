<?php
require_once "modele/modeleFilms.php";

function afficherPageRechercheFilms()
{
    require 'vue/rechercheFilms.php';
}

function afficherPageRechercheFilmsAjax()
{
    require 'vue/rechercheFilmsAjax.php';
}

function validerDonneesRechercherFilms()
{
    $erreurs = [];
    if (empty($_POST['titre']) || strlen($_POST['titre']) > 255) {
        $erreurs[] = 'Veuillez entrer un titre valide.';
    }
    return $erreurs;
}

function rechercherFilms()
{
    $erreurs = validerDonneesRechercherFilms();
    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageRechercheFilms');
        exit;
    }

    // Appelle le modèle pour obtenir les films correspondants
    $requeteFilms = ModeleFilms::obtenirFilms(trim($_POST['titre']));

    // Affiche les résultats
    require 'vue/resultatRechercheFilms.php';
}

function rechercherFilmsAjax()
{
    $erreurs = validerDonneesRechercherFilms();
    if (!empty($erreurs)) {
        retournerMessageErreurAJAX($erreurs);
    }

    // Appelle le modèle pour obtenir les films correspondants
    $requeteFilms = ModeleFilms::obtenirFilms(trim($_POST['titre']));

    // Affiche les résultats
    require 'vue/resultatRechercheFilmsAjax.php';
}
