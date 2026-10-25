<?php
session_start();

require_once 'utils/utils.php';

require_once 'controleur/controleur.php';
require_once 'controleur/controleurFilms.php';
require_once 'controleur/controleurFormulaire.php';
require_once 'controleur/controleurUtilisateurs.php';

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
        case 'afficherPageFormulaire':
            afficherPageFormulaire();
            break;
        case 'afficherPageFormulaireAjax':
            afficherPageFormulaireAjax();
            break;
        case 'gererSoumissionFormulaire':
            gererSoumissionFormulaire();
            break;
        case 'gererSoumissionFormulaireAjax':
            gererSoumissionFormulaireAjax();
            break;
        case 'afficherPageRechercheFilms':
            afficherPageRechercheFilms();
            break;
        case 'rechercherFilms':
            rechercherFilms();
            break;
        case 'afficherPageRechercheFilmsAjax':
            afficherPageRechercheFilmsAjax();
            break;
        case 'rechercherFilmsAjax':
            rechercherFilmsAjax();
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
