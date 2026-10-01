<?php
require_once "modele/bd.php";

class ModeleArticles
{
    /**
     * Récupère un article spécifique par son ID avec les informations de l'auteur et ses images.
     * 
     * @param int $articleId
     * @return PDOStatement|false
     */
    public static function obtenirArticle(int $articleId)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "SELECT
                a.*,
                u.nom AS auteur_nom,
                COALESCE(
                    (
                        SELECT JSON_ARRAYAGG(ia.url)
                        FROM images_articles ia
                        WHERE ia.article_id = a.id
                    ),
                    JSON_ARRAY()
                ) AS images
            FROM articles a
            INNER JOIN utilisateurs u ON a.utilisateur_id = u.id
            WHERE a.id = :articleId"
        );

        $req->bindParam(':articleId', $articleId, PDO::PARAM_INT);
        $req->execute();

        return $req;
    }

    /**
     * Récupère la liste des articles avec leurs images au format JSON.
     * 
     * @param string $filtreTitre (optionnel) Filtre les articles par titre.
     * @return PDOStatement|false
     */
    public static function obtenirArticles(string $filtreTitre = "")
    {
        $connexion = BD::ObtenirConnexion();

        $sql = "SELECT
                a.*,
                COALESCE(
                    (
                        SELECT JSON_ARRAYAGG(ia.url)
                        FROM images_articles ia
                        WHERE ia.article_id = a.id
                    ),
                    JSON_ARRAY()
                ) AS images
            FROM articles a";

        if (!empty($filtreTitre)) {
            $sql .= " WHERE a.titre LIKE :filtre_titre";
        }

        $req = $connexion->prepare($sql);

        if (!empty($filtreTitre)) {
            $filtreTitre = '%'.$filtreTitre.'%';
            $req->bindParam(':filtre_titre', $filtreTitre);
        }

        $req->execute();

        return $req;
    }

    /**
     * Insère un nouvel article en base de données.
     * 
     * @return int L'identifiant (ID) de l'article inséré.
     */
    public static function ajouterArticle(string $titre, string $resume, string $contenu, int $utilisateurId)
    {
        $connexion = BD::ObtenirConnexion();

        $req = $connexion->prepare(
            "INSERT INTO `articles` (`titre`, `resume`, `contenu`, `utilisateur_id`)
            VALUES (:titre, :resume, :contenu, :utilisateurId)"
        );

        $req->bindParam(':titre', $titre);
        $req->bindParam(':resume', $resume);
        $req->bindParam(':contenu', $contenu);
        $req->bindParam(':utilisateurId', $utilisateurId);

        $req->execute();

        return $connexion->lastInsertId();
    }
}
