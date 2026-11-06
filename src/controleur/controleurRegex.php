<?php
function afficherPageRegex()
{
    require 'vue/regex.php';
}

function validerDonneesSoumettreFormulaireRegex()
{
    $erreurs = [];
    
    $regexExRegex = '/^abc123$/';
    if (empty($_POST['exRegex']) || !preg_match($regexExRegex, $_POST['exRegex'])) {
        $erreurs[] = 'Vide ou format invalide (ex: abc123).';
    }
    
    $regexTelephone = '/^\(\d{3}\)\s?\d{3}-\d{4}$/';
    if (empty($_POST['telephone']) || !preg_match($regexTelephone, $_POST['telephone'])) {
        $erreurs[] = 'Vide ou format invalide (ex: (111) 111-1111).';
    }

    $regexEmail = '/^[a-zA-Z0-9\-_\.]{2,}@[a-zA-Z0-9\-\.]{2,}\.[a-zA-Z]{2,6}$/';
    if (empty($_POST['email']) || !preg_match($regexEmail, $_POST['email'])) {
        $erreurs[] = 'Vide ou format invalide (ex: utilisateur@domaine.com).';
    }

    $regexMessage = '/^(Bonjour|Madame|Monsieur),.*web.*(Meilleures salutations|Respectueusement|Bonne journée), Bob$/';
    if (empty($_POST['message']) || !preg_match($regexMessage, $_POST['message'])) {
        $erreurs[] = 'Vide ou format invalide (ex: Bonjour, je voudrais parler de web, Meilleures salutations, Bob).';
    }

    $regexAdresse = '/^\d+ .+, .+, [A-Za-z]{2} [A-Za-z]\d[A-Za-z][ ]?\d[A-Za-z]\d$/';
    if (empty($_POST['adresse']) || !preg_match($regexAdresse, $_POST['adresse'])) {
        $erreurs[] = 'Vide ou format invalide (ex: 116 rue, Saint-Georges, QC G5Y 3G1).';
    }

    return $erreurs;
}

function soumettreFormulaireRegex()
{
    $erreurs = validerDonneesSoumettreFormulaireRegex();
    if (!empty($erreurs)) {
        retournerMessageErreurAJAX($erreurs);
    }

    require 'vue/regexSucces.php';
}
