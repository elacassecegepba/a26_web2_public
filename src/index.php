<?php
session_start();

require_once 'controleur/controleur.php';
require_once 'controleur/controleurRegex.php';
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
        case 'afficherPageRegex':
            afficherPageRegex();
            break;
        case 'soumettreFormulaireRegex':
            soumettreFormulaireRegex();
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
