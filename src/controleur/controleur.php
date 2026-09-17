<?php
// Le contrôleur est responsable de la gestion des requêtes et de la logique métier.
// Il interagit avec les modèles (BD) pour récupérer ou modifier des données,
// et prépare les données à afficher dans les vues.

function afficherPageAccueil()
{
    // Ici on se contente d'afficher la page d'accueil
    require 'vue/accueil.php';
}

function afficherPageFormulaire()
{
    require 'vue/formulaire.php';
}

function validerDonneesInscrireAUnCours()
{
    $choixDeCours = ['algo', 'web', 'reseau', 'bdd'];
    $erreurs = [];
    if (empty($_POST['nom']) || mb_strlen($_POST['nom']) < 3 || mb_strlen($_POST['nom']) > 50) {
        $erreurs[] = 'Le nom est requis et doit contenir entre 3 et 50 caractères.';
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($_POST['email']) > 255) {
        $erreurs[] = 'L\'email est requis, doit être valide et contenir au maximum 255 caractères.';
    }
    if (empty($_POST['cours']) || !in_array($_POST['cours'], $choixDeCours)) {
        $erreurs[] = 'Le choix du cours est requis et doit être valide.';
    }
    return $erreurs;
}

function inscrireAUnCours()
{
    // Vérifie que les données du formulaire sont valides
    $erreurs = validerDonneesInscrireAUnCours();
    if (!empty($erreurs)) {
        // Si les données ne sont pas valides, on redirige vers le formulaire
        header('Location: index.php?action=afficherPageFormulaire');
        exit;
    }

    // Données des cours disponibles (normalement, ces données viendraient d'une base de données)
    $listeDesCours = [
        'algo' => ['nom' => 'Algorithmique'],
        'web' => ['nom' => 'Développement Web'],
        'reseau' => ['nom' => 'Réseaux'],
        'bdd' => ['nom' => 'Bases de données']
    ];

    // Récupère les données du cours sélectionné par l'utilisateur
    $cours = $listeDesCours[$_POST['cours']];

    require 'vue/confirmation.php';
}
