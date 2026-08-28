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

function inscrireAUnCours()
{
    // Vérifie que les données du formulaire sont présentes
    if (!isset($_POST['nom'], $_POST['email'], $_POST['cours'])) {
        // Si les données du formulaire ne sont pas présentes, on redirige vers le formulaire
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
