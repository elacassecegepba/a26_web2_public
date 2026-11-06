<?php
require_once "modele/bd.php";

class ModeleImagesRendezVous
{
    public static function ajouterImage(int $rendezVousId, string $nomOriginal, string $cheminFichier)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL
        $req = $connexion->prepare(
            "INSERT INTO images_rendez_vous (rendez_vous_id, nom_original, chemin_fichier) 
            VALUES (:rendez_vous_id, :nom_original, :chemin_fichier)"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':rendez_vous_id', $rendezVousId);
        $req->bindParam(':nom_original', $nomOriginal);
        $req->bindParam(':chemin_fichier', $cheminFichier);

        // Exécution de la requête préparée
        $req->execute();

        // Retourne l'identifiant de l'image qui vient d'être insérée
        return $connexion->lastInsertId();
    }

    public static function obtenirImage(int $id)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL avec un paramètre nommé
        $req = $connexion->prepare(
            "SELECT images_rendez_vous.*, rendez_vous.utilisateurs_id
            FROM images_rendez_vous
            INNER JOIN rendez_vous ON rendez_vous.id = images_rendez_vous.rendez_vous_id
            WHERE images_rendez_vous.id = :id"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':id', $id);

        // Exécution de la requête
        $req->execute();

        // Retourne l'objet PDOStatement contenant le résultat
        return $req;
    }
}
