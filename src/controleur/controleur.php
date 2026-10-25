<?php

function bloquerSiNonConnecte()
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }
}

function afficherPageAccueil()
{
    require 'vue/accueil.php';
}

function retournerMessageErreurAJAX(array $erreurs)
{
    http_response_code(400);
    $erreursHTML = implode("<br>", $erreurs);
    echo $erreursHTML;
    exit;
}
