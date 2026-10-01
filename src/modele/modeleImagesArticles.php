<?php
require_once "modele/bd.php";

class ModeleImagesArticles
{
    /**
     * Associe une URL d'image à un article.
     * 
     * @return int L'identifiant (ID) de l'enregistrement de l'image.
     */
    public static function ajouterImageArticle(string $url, int $articleId)
    {
        $connexion = BD::ObtenirConnexion();

        $req =$connexion->prepare(
            "INSERT INTO `images_articles` (`url`, `article_id`)
            VALUES (:url, :articleId)"
        );

        $req->bindParam(':url', $url);
        $req->bindParam(':articleId', $articleId);

        $req->execute();

        return $connexion->lastInsertId();
    }
}