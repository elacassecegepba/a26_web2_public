<?php
session_start();

require_once 'controleur/controleur.php';
require_once 'controleur/controleurFichiers.php';
require_once 'controleur/controleurUtilisateurs.php';
require_once 'controleur/controleurUtils.php';

try {
    if (!isset($_GET['action'])) {
        afficherPageAccueil();
        return;
    }

    switch ($_GET['action']) {
        case 'afficherPageAccueil':
            afficherPageAccueil();
            break;
        case 'afficherPageConnexion':
            afficherPageConnexion();
            break;
        case 'afficherPageInscription':
            afficherPageInscription();
            break;
        case 'afficherPageProfil':
            afficherPageProfil();
            break;
        case 'connecter':
            connecter();
            break;
        case 'inscrire':
            inscrire();
            break;
        case 'deconnecter':
            deconnecter();
            break;
        case 'modifierProfil':
            modifierProfil();
            break;
        case 'afficherPageTeleversement':
            afficherPageTeleversement();
            break;
        case 'afficherPageFichiers':
            afficherPageFichiers();
            break;
        case 'televerserFichier':
            televerserFichier();
            break;
        case 'telechargerFichier':
            telechargerFichier();
            break;
        default:
            throw new Exception('404 : Action non supportée');
    }
} catch (PDOException $e) {
    $msgErreur = $e->getMessage();
    require 'vue/erreur.php';
} catch (Exception $ex) {
    $msgErreur = $ex->getMessage();
    require 'vue/erreur.php';
}
