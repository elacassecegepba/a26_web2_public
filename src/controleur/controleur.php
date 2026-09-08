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

function validerDonneesInscrireAUnCoursPartie1()
{
    $choixDeCours = ['algo', 'web', 'reseau', 'bdd'];
    $erreurs = [];
    if (empty($_POST['nom']) || mb_strlen($_POST['nom']) < 3 || mb_strlen($_POST['nom']) > 50) {
        $erreurs[] = 'Le nom est requis et doit contenir entre 3 et 50 caractères.';
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($_POST['email']) > 255) {
        $erreurs[] = 'L\'email est requis, doit être valide et contenir au maximum 255 caractères.';
    }
    if (empty($_POST['cours']) || !in_array($_POST['cours'], $choixDeCours)) {
        $erreurs[] = 'Le choix du cours est requis et doit être valide.';
    }
    return $erreurs;
}

function inscrireAUnCoursPartie1()
{
    // Vérifie que les données du formulaire sont valides
    $erreurs = validerDonneesInscrireAUnCoursPartie1();
    if (!empty($erreurs)) {
        // Si les données ne sont pas valides, on redirige vers le formulaire
        header('Location: index.php?action=afficherPageFormulaire');
        exit;
    }

    require 'vue/2eFormulaire.php';
}

function validerDonneesInscrireAUnCoursPartie2()
{
    $erreurs = [];
    if (empty($_POST['nomTitulaire']) || mb_strlen($_POST['nomTitulaire']) < 3 || mb_strlen($_POST['nomTitulaire']) > 100) {
        $erreurs[] = 'Le nom du titulaire est requis et doit contenir entre 3 et 100 caractères.';
    }
    // Normalement, on devrait utiliser une expression régulière pour valider le format du numéro de carte, mais pour simplifier, on vérifie juste la longueur ici.
    if (empty($_POST['numeroCarte']) || mb_strlen($_POST['numeroCarte']) < 13 || mb_strlen($_POST['numeroCarte']) > 19) {
        $erreurs[] = 'Le numéro de carte est requis et doit être valide.';
    }
    if (empty($_POST['moisExpiration']) || !in_array($_POST['moisExpiration'], ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'])) {
        $erreurs[] = 'Le mois d\'expiration est requis et doit être valide.';
    }
    if (empty($_POST['anneeExpiration']) || !in_array($_POST['anneeExpiration'], range(date('Y'), date('Y') + 10))) {
        $erreurs[] = 'L\'année d\'expiration est requise et doit être valide.';
    }
    if (empty($_POST['cvv']) || !filter_var($_POST['cvv'], FILTER_VALIDATE_INT) || strlen($_POST['cvv']) < 3 || strlen($_POST['cvv']) > 4) {
        $erreurs[] = 'Le CVV est requis et doit contenir 3 ou 4 chiffres.';
    }
    return $erreurs;
}

function inscrireAUnCoursPartie2()
{
    // Vérifie que les données du formulaire sont valides
    // On valide les données du premier formulaire et du second formulaire
    // On fait cela pour s'assurer que l'utilisateur n'a pas modifié les données du premier formulaire en manipulant le HTML ou les requêtes.
    // array_merge permet de combiner les deux tableaux d'erreurs en un seul.
    $erreurs = array_merge(validerDonneesInscrireAUnCoursPartie1(), validerDonneesInscrireAUnCoursPartie2());
    if (!empty($erreurs)) {
        // Si les données ne sont pas valides, on redirige vers le formulaire
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
