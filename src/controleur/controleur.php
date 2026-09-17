<?php
function afficherPageAccueil()
{
    require 'vue/accueil.php';
}

function afficherPageConnexion()
{
    require 'vue/connexion.php';
}

function afficherPageProfil()
{
    require 'vue/profil.php';
}

function validerDonneesConnexion()
{
    $erreurs = [];
    if (empty($_POST['nomUtilisateur']) || mb_strlen($_POST['nomUtilisateur']) < 3 || mb_strlen($_POST['nomUtilisateur']) > 45) {
        $erreurs[] = 'Le nom d\'utilisateur est requis et doit contenir entre 3 et 45 caractères.';
    }
    if (empty($_POST['motDePasse']) || mb_strlen($_POST['motDePasse']) < 6 || mb_strlen($_POST['motDePasse']) > 45) {
        $erreurs[] = 'Le mot de passe est requis et doit contenir entre 6 et 45 caractères.';
    }
    return $erreurs;
}

function connecter()
{
    $erreurs = validerDonneesConnexion();
    if (!empty($erreurs)) {
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }

    // Rediriger vers la page du profil après une connexion réussie
    header('Location: index.php?action=afficherPageProfil');
}

function deconnecter() {}
