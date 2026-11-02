<?php
require_once 'modele/modeleFichiers.php';

function afficherPageTeleversement()
{
    require 'vue/televersement.php';
}

function afficherPageFichiers()
{
    bloquerSiNonConnecte();

    $requeteFichiers = ModeleFichiers::obtenirFichiers($_SESSION['utilisateur']['id']);

    require 'vue/fichiers.php';
}

function validerDonneesTeleverser()
{
    $erreurs = [];

    $fichiersTeleverses = obtenirFichiersTeleverses('fichier');
    if (empty($fichiersTeleverses)) {
        $erreurs[] = "Aucun fichier n'a été téléversé.";
    } else {
        foreach ($fichiersTeleverses as $fichier) {
            $resultatValidation = validerFichierTeleverse($fichier, [
                'tailleMax' => 2 * 1024 * 1024, // 2MB
                'extensionsAutorisees' => ['jpg', 'jpeg', 'png', 'webp'],
                'mimeTypesAutorisees' => ['image/jpeg', 'image/png', 'image/webp'],
            ]);

            if (!$resultatValidation['estValide']) {
                $erreurs = [...$erreurs, ...$resultatValidation['erreurs']];
            }
        }
    }

    return $erreurs;
}

function televerser()
{
    bloquerSiNonConnecte();

    $erreurs = validerDonneesTeleverser();
    if (!empty($erreurs)) {
        retournerMessageErreurSession($erreurs, 'afficherPageTeleversement');
    }

    $connexion = BD::ObtenirConnexion();
    try {
        $connexion->beginTransaction();
        $fichiersTeleverses = obtenirFichiersTeleverses('fichier');
        $fichiersEnregistres = enregistrerFichiers($fichiersTeleverses, 'televersements/');
        foreach ($fichiersEnregistres as $fichier) {
            ModeleFichiers::ajouterFichier($_SESSION['utilisateur']['id'], $fichier['nomOriginal'], $fichier['chemin']);
        }
        $connexion->commit();
        header('Location: index.php?action=afficherPageFichiers');
    } catch (Exception $e) {
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }
        // Supprimer les fichiers déjà enregistrés
        foreach ($fichiersEnregistres ?? [] as $fichierEnregistre) {
            if (is_file($fichierEnregistre['chemin'])) {
                unlink($fichierEnregistre['chemin']);
            }
        }
        retournerMessageErreurSession(
            ['Une erreur est survenue lors de l\'ajout du fichier.'],
            'afficherPageTeleversement'
        );
    }
}

function telecharger()
{
    bloquerSiNonConnecte();

    // Vérifier que l'ID du fichier est fourni dans l'URL et valide
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        http_response_code(400);
        exit;
    }

    $requeteFichiers = ModeleFichiers::obtenirFichier($_GET['id']);
    $fichier = $requeteFichiers->fetch();

    // Vérifier si le fichier existe et appartient à l'utilisateur connecté
    if (!$fichier || $fichier['utilisateurs_id'] != $_SESSION['utilisateur']['id']) {
        http_response_code(404);
        exit;
    }

    telechargerFichier($fichier['chemin_fichier'], $fichier['nom_original']);
}
