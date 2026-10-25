<?php
function afficherPageFormulaire()
{
    require 'vue/formulaire.php';
}

function validerDonneesFormulaire()
{
    $erreurs = [];
    if (empty($_POST['donnees']) || strlen($_POST['donnees']) < 1) {
        $erreurs[] = 'Veuillez entrer des données à envoyer.';
    }
    if (!isset($_POST['delai']) || !filter_var($_POST['delai'], FILTER_VALIDATE_INT) || $_POST['delai'] < 0) {
        $erreurs[] = 'Veuillez entrer un délai de traitement valide (nombre entier positif).';
    }
    return $erreurs;
}

function gererSoumissionFormulaire()
{
    $erreurs = validerDonneesFormulaire();
    if (!empty($erreurs)) {
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php?action=afficherPageFormulaire');
        exit;
    }

    // Simuler une erreur si demandé
    if (isset($_POST['erreur'])) {
        $_SESSION['erreurs'] = ["Retour d'une erreur tel que demandé."];
        header('Location: index.php?action=afficherPageFormulaire');
        exit;
    }

    // Simuler un délai de traitement
    usleep($_POST['delai'] * 1000);

    // Si tout est correct, afficher la page de validation après le délai
    require 'vue/validationSoumissionFormulaire.php';
}

function afficherPageFormulaireAjax()
{
    require 'vue/formulaireAjax.php';
}

function gererSoumissionFormulaireAjax()
{
    $erreurs = validerDonneesFormulaire();
    if (!empty($erreurs)) {
        retournerMessageErreurAJAX($erreurs);
    }

    // Simuler une erreur si demandé
    if (isset($_POST['erreur'])) {
        retournerMessageErreurAJAX(["Retour d'une erreur tel que demandé."]);
    }

    // Simuler un délai de traitement
    usleep($_POST['delai'] * 1000);

    // Si tout est correct, afficher la page de validation après le délai
    require 'vue/validationSoumissionFormulaireAjax.php';
}
