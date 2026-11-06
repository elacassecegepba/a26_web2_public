<?php

function bloquerSiNonConnecte()
{
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['utilisateur'])) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header('Location: index.php?action=afficherPageConnexion');
        exit;
    }
}

function retournerMessageErreurSession(array $erreurs, string $actionDeRedirection, int $codeHTTP = 400)
{
    http_response_code($codeHTTP);
    $_SESSION['erreurs'] = $erreurs;
    header('Location: index.php?action=' . $actionDeRedirection);
    exit;
}

function retournerMessageErreurAJAX(array $erreurs, int $codeHTTP = 400)
{
    http_response_code($codeHTTP);
    $erreursHTML = implode("<br>", $erreurs);
    echo $erreursHTML;
    exit;
}

/**
 * @phpstan-type UploadedFile array{
 *     name: string,
 *     type: string,
 *     tmp_name: string,
 *     error: int,
 *     size: int
 * }
 */

/**
 * Transforme la structure de $_FILES en un tableau plus simple pour gérer les fichiers téléversés.
 * @param string $nomInput Nom du champ input (attribut name).
 * @return array<int, UploadedFile>
 */
function obtenirFichiersTeleverses(string $nomInput)
{
    if (!isset($_FILES[$nomInput])) {
        return [];
    }

    $file = $_FILES[$nomInput];
    $fichiersTeleverses = [];

    // Gestion des champs multiples
    if (is_array($file['name'])) {
        foreach ($_FILES as $file) {
            foreach ($file['name'] as $key => $name) {
                if ($file['error'][$key] === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                $fichiersTeleverses[] = [
                    'name'     => $name,
                    'type'     => $file['type'][$key],
                    'tmp_name' => $file['tmp_name'][$key],
                    'error'    => $file['error'][$key],
                    'size'     => $file['size'][$key],
                ];
            }
        }
    } else {
        // Gestion d'un fichier unique
        if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
            $fichiersTeleverses[] = $file;
        }
    }

    return $fichiersTeleverses;
}

/**
 * Valide un fichier téléversé.
 *
 * @param UploadedFile $fichier
 * @param array{
 *     tailleMax?: int,
 *     extensionsAutorisees?: string[],
 *     mimeTypesAutorisees?: string[]
 * } $options
 *
 * @return array{estValide: bool, erreurs: string[]}
 */
function validerFichierTeleverse(array $fichier, array $options = [])
{
    $options = [
        'tailleMax' => 5 * 1024 * 1024,
        'extensionsAutorisees' => [],
        'mimeTypesAutorisees' => [],
        ...$options // Écrase les options par défaut avec celles fournies
    ];

    $erreurs = [];

    // Vérification de l'erreur d'upload
    if ($fichier['error'] !== UPLOAD_ERR_OK) {
        $erreurs[] = match ($fichier['error']) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la taille autorisée.',
            UPLOAD_ERR_PARTIAL => 'Le fichier a été téléversé partiellement.',
            UPLOAD_ERR_NO_FILE => 'Aucun fichier fourni.',
            UPLOAD_ERR_NO_TMP_DIR => 'Le dossier temporaire est manquant.',
            UPLOAD_ERR_CANT_WRITE => 'Impossible d\'écrire le fichier sur le disque.',
            UPLOAD_ERR_EXTENSION => 'Une extension PHP a interrompu le téléversement.',
            default => 'Une erreur inconnue est survenue.',
        };

        return ['estValide' => false, 'erreurs' => $erreurs];
    }

    // Vérification de la taille
    if ($fichier['size'] > $options['tailleMax']) {
        $erreurs[] = 'Le fichier dépasse la taille maximale autorisée.';
    }

    // Vérification du fichier temporaire
    if (
        !is_uploaded_file($fichier['tmp_name']) ||
        !is_file($fichier['tmp_name'])
    ) {
        $erreurs[] = 'Le fichier téléversé est invalide.';

        return ['estValide' => false, 'erreurs' => $erreurs];
    }

    // Vérification de l'extension
    $extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

    if (
        !empty($options['extensionsAutorisees']) &&
        !in_array($extension, $options['extensionsAutorisees'], true)
    ) {
        $erreurs[] = 'L\'extension du fichier n\'est pas autorisée.';
    }

    // Vérification du véritable type MIME
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($fichier['tmp_name']);

    if (
        !empty($options['mimeTypesAutorisees']) &&
        !in_array($mimeType, $options['mimeTypesAutorisees'], true)
    ) {
        $erreurs[] = 'Le type MIME du fichier n\'est pas autorisé.';
    }

    return [
        'estValide' => empty($erreurs),
        'erreurs' => $erreurs,
    ];
}

/**
 * Enregistre les fichiers téléversés dans un répertoire spécifié.
 * En cas d'erreur,
 *  - Supprime les fichiers déjà enregistrés pour éviter les fichiers orphelins.
 *  - Lance une exception pour signaler l'erreur.
 *
 * @param UploadedFile[] $fichiers
 * @return array{nomOriginal: string, nomFichier: string, chemin: string, taille: int|false}[] Liste des fichiers téléversés avec leurs informations.
 */
function enregistrerFichiers($fichiers, string $repertoire)
{
    if (!is_dir($repertoire)) {
        if (!mkdir($repertoire, 0755, true) && !is_dir($repertoire)) {
            throw new RuntimeException("Impossible de créer le répertoire : $repertoire");
        }
    }

    $fichiersEnregistres = [];

    try {
        foreach ($fichiers as $fichier) {
            // Ignorer les fichiers non envoyés
            if ($fichier['error'] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            // Vérifier les erreurs d'upload
            if ($fichier['error'] !== UPLOAD_ERR_OK) {
                throw new RuntimeException(
                    "Erreur lors de l'upload : " . $fichier['name']
                );
            }

            // Vérifier que le fichier provient bien d'un upload HTTP
            if (!is_uploaded_file($fichier['tmp_name'])) {
                throw new RuntimeException(
                    "Fichier uploadé invalide : " . $fichier['name']
                );
            }

            // Récupérer uniquement l'extension
            $extension = strtolower(
                pathinfo($fichier['name'], PATHINFO_EXTENSION)
            );

            // Générer un nom unique pour éviter les conflits
            do {
                $nomFichier = bin2hex(random_bytes(16));

                if ($extension !== '') {
                    $nomFichier .= '.' . $extension;
                }

                $destination = rtrim($repertoire, DIRECTORY_SEPARATOR)
                    . DIRECTORY_SEPARATOR
                    . $nomFichier;
            } while (file_exists($destination));

            // Déplacer le fichier vers sa destination
            if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
                throw new RuntimeException(
                    "Impossible d'enregistrer le fichier : " . $fichier['name']
                );
            }

            // Récupérer la taille du fichier
            $taille = filesize($destination);

            $fichiersEnregistres[] = [
                'nomOriginal' => $fichier['name'],
                'nomFichier' => $nomFichier,
                'chemin' => $destination,
                'taille' => $taille,
            ];
        }

        return $fichiersEnregistres;
    } catch (Throwable $e) {
        // Supprimer les fichiers déjà enregistrés
        foreach ($fichiersEnregistres as $fichierEnregistre) {
            if (is_file($fichierEnregistre['chemin'])) {
                unlink($fichierEnregistre['chemin']);
            }
        }

        // Relancer l'exception initiale
        throw $e;
    }
}

function telechargerFichier(string $cheminFichier, ?string $nomFichierTelecharge = null)
{
    $typeMime = mime_content_type($cheminFichier);
    if ($typeMime === false) {
        $typeMime = 'application/octet-stream'; // Type MIME par défaut si non détecté
    }

    if ($nomFichierTelecharge === null) {
        $nomFichierTelecharge = basename($cheminFichier);
    } else {
        // Nettoyer le nom du fichier pour éviter les problèmes de sécurité
        $nomFichierTelecharge = basename($nomFichierTelecharge);
    }

    // Envoyer les en-têtes appropriés pour le téléchargement
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $typeMime);
    header('Content-Disposition: inline; filename="' . $nomFichierTelecharge . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($cheminFichier));

    // Lire le fichier et l'envoyer au navigateur
    readfile($cheminFichier);
    exit;
}
