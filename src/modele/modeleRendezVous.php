<?php
require_once "modele/bd.php";

class ModeleRendezVous
{
    public static function ajouterRendezVous(string $description, int $utilisateursId, int $modelesId)
    {
        $connexion = BD::ObtenirConnexion();
        $req = $connexion->prepare(
            "INSERT INTO rendez_vous (description, utilisateurs_id, modeles_id) VALUES
            (:description, :utilisateurs_id, :modeles_id)"
        );

        $req->bindParam(':description', $description);
        $req->bindParam(':utilisateurs_id', $utilisateursId);
        $req->bindParam(':modeles_id', $modelesId);
        $req->execute();

        return $connexion->lastInsertId();
    }

    public static function obtenirRendezVousDUnUtilisateur(int $utilisateursId)
    {
        $req = BD::ObtenirConnexion()->prepare(
            "SELECT
                rendez_vous.*,
                modeles.nom AS modeles_nom,
                marques.nom AS marques_nom,
                COALESCE(
                    (
                        SELECT JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'id', images_rdv.id,
                                'chemin_fichier', images_rdv.chemin_fichier,
                                'nom_original', images_rdv.nom_original
                            )
                        )
                        FROM images_rendez_vous images_rdv
                        WHERE images_rdv.rendez_vous_id = rendez_vous.id
                    ),
                    JSON_ARRAY()
                ) AS images
            FROM rendez_vous
            INNER JOIN modeles ON modeles.id = rendez_vous.modeles_id
            INNER JOIN marques ON marques.id = modeles.marques_id
            WHERE rendez_vous.utilisateurs_id = :utilisateursId"
        );

        $req->bindParam(':utilisateursId', $utilisateursId);
        $req->execute();

        return $req;
    }
}
