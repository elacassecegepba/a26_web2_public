<?php
require_once "modele/bd.php";

class ModeleUtilisateurs
{
    // Permet d'obtenir un utilisateur par son nom
    public static function obtenirUtilisateur(string $nom)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL avec un paramètre nommé
        $req = $connexion->prepare(
            "SELECT * FROM utilisateurs WHERE nom = :nom"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':nom', $nom);

        // Exécution de la requête
        $req->execute();

        // Retourne l'objet PDOStatement contenant le résultat
        return $req;
    }

    // Permet d'ajouter un utilisateur dans la base de données
    public static function ajouterUtilisateur(string $nom, string $mot_de_passe)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL
        $req = $connexion->prepare(
            "INSERT INTO utilisateurs (nom, mot_de_passe) VALUES (:nom, :mot_de_passe)"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':nom', $nom);
        $req->bindParam(':mot_de_passe', $mot_de_passe);

        // Exécution de la requête préparée
        $req->execute();

        // Retourne l'identifiant de l'utilisateur qui vient d'être inséré
        return $connexion->lastInsertId();
    }

    // Permet de mettre à jour les informations d'un utilisateur
    public static function mettreAJourUtilisateur(string $ancienNom, string $nouveauNom, string|null $email, string|null $image)
    {
        $connexion = BD::ObtenirConnexion();

        // Préparation de la requête SQL avec des paramètres nommés
        $req = $connexion->prepare(
            "UPDATE utilisateurs 
            SET nom = :nouveauNom, email = :email, image = :image
            WHERE nom = :ancienNom"
        );

        // Liaison des paramètres nommés avec les variables PHP
        $req->bindParam(':ancienNom', $ancienNom);
        $req->bindParam(':nouveauNom', $nouveauNom);
        $req->bindParam(':email', $email);
        $req->bindParam(':image', $image);

        // Exécution de la requête préparée
        return $req->execute();
    }
}
