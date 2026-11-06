<?php
require_once "modele/bd.php";

class ModeleModeles
{
    public static function obtenirModeles()
    {
        $req = BD::ObtenirConnexion()->prepare(
            "SELECT * FROM modeles"
        );

        $req->execute();

        return $req;
    }

    public static function obtenirModelesParMarque(int $marqueId)
    {
        $req = BD::ObtenirConnexion()->prepare(
            "SELECT * FROM modeles WHERE marques_id = :marques_id"
        );

        $req->bindParam(':marques_id', $marqueId);
        $req->execute();

        return $req;
    }
}
