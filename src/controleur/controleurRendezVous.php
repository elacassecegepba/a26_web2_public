<?php
require_once 'modele/modeleRendezVous.php';
require_once 'modele/modeleImagesRendezVous.php';
require_once 'modele/modeleMarques.php';
require_once 'modele/modeleModeles.php';

function afficherPagePrendreRendezVous()
{
    bloquerSiNonConnecte();
    $requeteMarques = ModeleMarques::obtenirMarques();
    $requeteModeles = ModeleModeles::obtenirModeles();
    require 'vue/prendreRendezVous.php';
}

function afficherPageMesRendezVous()
{
    bloquerSiNonConnecte();
    $requeteRendezVous = ModeleRendezVous::obtenirRendezVousDUnUtilisateur($_SESSION['utilisateur']['id']);
    require 'vue/mesRendezVous.php';
}

function validerDonneesPrendreRendezVous()
{
    $erreurs = [];

    // Valider la marque
    if (empty($_POST['marque'])) {
        $erreurs[] = "La marque est obligatoire.";
    }

    // Valider le modèle
    if (empty($_POST['modele'])) {
        $erreurs[] = "Le modèle est obligatoire.";
    }

    // Valider la description
    if (empty($_POST['description']) || strlen($_POST['description']) > 65535) {
        $erreurs[] = "La description est obligatoire et doit contenir au maximum 65535 caractères.";
    }

    return $erreurs;
}

function prendreRendezVous()
{
    bloquerSiNonConnecte();

    $erreurs = validerDonneesPrendreRendezVous();
    if (!empty($erreurs)) {
        retournerMessageErreurSession($erreurs, 'afficherPagePrendreRendezVous');
    }
}
