<?php
require_once "modele/bd.php";

class ModeleMarques
{
    public static function obtenirMarques()
    {
        $req = BD::ObtenirConnexion()->prepare(
            "SELECT * FROM marques"
        );

        $req->execute();

        return $req;
    }
}
