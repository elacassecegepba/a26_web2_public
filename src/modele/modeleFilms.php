<?php
require_once "modele/bd.php";

class ModeleFilms
{
    // Permet de faire une recherche de films par titre
    public static function obtenirFilms($titre)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT * FROM films WHERE titre like :titre"
        );

        $titre = '%' . $titre . '%';
        $req->bindParam(':titre', $titre);
        $req->execute();

        return $req;
    }
}
