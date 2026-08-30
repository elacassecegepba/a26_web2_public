<?php
// Le contrôleur est responsable de la gestion des requêtes et de la logique métier.
// Il interagit avec les modèles (BD) pour récupérer ou modifier des données,
// et prépare les données à afficher dans les vues.

function afficherPageAccueil()
{
    // Ici on se contente d'afficher la page d'accueil
    require 'vue/accueil.php';
}
