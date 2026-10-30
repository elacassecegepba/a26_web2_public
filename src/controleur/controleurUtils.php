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

function retournerMessageErreurSession(array $erreurs, string $actionDeRedirection)
{
    $_SESSION['erreurs'] = $erreurs;
    header('Location: index.php?action=' . $actionDeRedirection);
    exit;
}

function retournerMessageErreurAJAX(array $erreurs)
{
    http_response_code(400);
    $erreursHTML = implode("<br>", $erreurs);
    echo $erreursHTML;
    exit;
}
