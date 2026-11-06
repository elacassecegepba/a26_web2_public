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

    // Valider les images
    $fichiersTeleverses = obtenirFichiersTeleverses('images');
    foreach ($fichiersTeleverses as $fichier) {
        $resultatValidation = validerFichierTeleverse($fichier, [
            'tailleMax' => 3 * 1024 * 1024, // 3MB
            'extensionsAutorisees' => ['jpg', 'jpeg', 'png', 'webp'],
            'mimeTypesAutorisees' => ['image/jpeg', 'image/png', 'image/webp'],
        ]);

        if (!$resultatValidation['estValide']) {
            $erreurs = [...$erreurs, ...$resultatValidation['erreurs']];
        }
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

    $connexion = BD::ObtenirConnexion();
    try {
        // Utilisation d'une transaction pour garantir l'intégrité des données
        $connexion->beginTransaction();
        // Tentative d'ajout du rendez-vous dans la base de données
        $rendezVousId = ModeleRendezVous::ajouterRendezVous($_POST['description'], $_SESSION['utilisateur']['id'], $_POST['modele']);
        // Tentative d'ajout des images du rendez-vous dans la base de données
        $fichiersTeleverses = obtenirFichiersTeleverses('images');
        $fichiersEnregistres = enregistrerFichiers($fichiersTeleverses, 'televersements/');

        foreach ($fichiersEnregistres as $fichier) {
            ModeleImagesRendezVous::ajouterImage($rendezVousId, $fichier['nomOriginal'], $fichier['chemin']);
        }
        // Validation finale de la transaction
        $connexion->commit();
        // Redirection vers la page des rendez-vous après la prise de rendez-vous
        header('Location: index.php?action=afficherPageMesRendezVous');
    } catch (Exception $e) {
        // En cas d'erreur, annulation des changements SQL
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }
        // Supprimer les fichiers déjà enregistrés
        foreach ($fichiersEnregistres ?? [] as $fichierEnregistre) {
            if (is_file($fichierEnregistre['chemin'])) {
                unlink($fichierEnregistre['chemin']);
            }
        }
        retournerMessageErreurSession(['Erreur lors de la prise de rendez-vous. Veuillez réessayer.'], 'afficherPagePrendreRendezVous');
    }
}

function telechargerImageRendezVous()
{
    bloquerSiNonConnecte();

    // Vérifier que l'ID du fichier est fourni dans l'URL et valide
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        http_response_code(400);
        exit;
    }

    $requeteFichiers = ModeleImagesRendezVous::obtenirImage($_GET['id']);
    $fichier = $requeteFichiers->fetch();

    // Vérifier si le fichier existe et appartient à l'utilisateur connecté
    if (!$fichier || $fichier['utilisateurs_id'] != $_SESSION['utilisateur']['id']) {
        http_response_code(404);
        exit;
    }

    telechargerFichier($fichier['chemin_fichier'], $fichier['nom_original']);
}

function obtenirModelesParMarque()
{
    bloquerSiNonConnecte();

    if (!isset($_GET['marque']) || !is_numeric($_GET['marque'])) {
        retournerMessageErreurAJAX(["Marque invalide."]);
    }

    $requeteModeles = ModeleModeles::obtenirModelesParMarque($_GET['marque']);

    require 'vue/listeModeles.php';
}
