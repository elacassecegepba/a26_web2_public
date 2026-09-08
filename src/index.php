<?php
// Le fichier index.php joue le rôle de point d'entrée (routeur) de l'application.
// Ainsi, toutes les requêtes HTTP doivent passer par ce fichier.
// Il analyse le paramètre "action" de l'URL et appelle la fonction appropriée dans le contrôleur.


// Chargement des contrôleurs
require_once 'controleur/controleur.php';

try {
    if (!isset($_GET['action'])) {
        // Si aucune action n'est spécifié, affiche la page d'accueil
        // Ex. d'URL : index.php
        afficherPageAccueil();
        return;
    }

    // Vérification de l'action demandée
    switch ($_GET['action']) {
        case 'afficherPageAccueil':
            // Ex. d'URL : index.php?action=afficherPageAccueil
            // Appel de la fonction du contrôleur pour afficher la page d'accueil
            afficherPageAccueil();
            break;
        case 'afficherPageFormulaire':
            // Ex. d'URL : index.php?action=afficherPageFormulaire
            // Appel de la fonction du contrôleur pour afficher la page de formulaire
            afficherPageFormulaire();
            break;
        case 'inscrireAUnCoursPartie1':
            inscrireAUnCoursPartie1();
            break;
        case 'inscrireAUnCoursPartie2':
            inscrireAUnCoursPartie2();
            break;
        default:
            // Si l'action demandée n'est pas reconnue, on lance une exception
            throw new Exception('404 : Action non supportée');
    }
} catch (PDOException $e) {
    // En cas d'erreur de base de données, on affiche le message d'erreur
    // dans la vue d'erreur
    $msgErreur = $e->getMessage();
    require 'vue/erreur.php';
} catch (Exception $ex) {
    // En cas d'erreur générale, on affiche le message d'erreur
    // dans la vue d'erreur
    $msgErreur = $ex->getMessage();
    require 'vue/erreur.php';
}
