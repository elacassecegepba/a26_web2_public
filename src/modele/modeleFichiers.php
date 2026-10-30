<?php
require_once "modele/bd.php";

class ModeleFichiers
{
    public static function ajouterFichier($utilisateurId, $nomOriginal, $cheminFichier)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL
        $req = $connexion->prepare(
            "INSERT INTO fichiers (utilisateurs_id, nom_original, chemin_fichier) 
             VALUES (:utilisateurs_id, :nom_original, :chemin_fichier)"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':utilisateurs_id', $utilisateurId);
        $req->bindParam(':nom_original', $nomOriginal);
        $req->bindParam(':chemin_fichier', $cheminFichier);

        // Exécution de la requête préparée
        $req->execute();

        // Retourne l'identifiant du fichier qui vient d'être inséré
        return $connexion->lastInsertId();
    }

    public static function obtenirFichier($id)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL avec un paramètre nommé
        $req = $connexion->prepare(
            "SELECT * FROM fichiers WHERE id = :id"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':id', $id);

        // Exécution de la requête
        $req->execute();

        // Retourne l'objet PDOStatement contenant le résultat
        return $req;
    }

    public static function obtenirFichiers($utilisateurId)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL avec un paramètre nommé
        $req = $connexion->prepare(
            "SELECT * FROM fichiers WHERE utilisateurs_id = :utilisateurs_id"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':utilisateurs_id', $utilisateurId);

        // Exécution de la requête
        $req->execute();

        // Retourne l'objet PDOStatement contenant le résultat
        return $req;
    }
}
