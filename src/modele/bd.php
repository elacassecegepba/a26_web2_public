<?php
class BD
{
    /** Hôte sur lequel le serveur de base de données se situe. */
    private const HOST = 'db';
    /** Nom de la base de données. */
    private const DB_NAME = 'exercice_bd';
    /**
     * Le jeu de caractères.
     * https://www.php.net/manual/fr/mysqlinfo.concepts.charset.php
     */
    private const CHARSET = 'utf8mb4';
    /**
     * Data Source Name, contient les informations nécessaire à la connexion à la base de données.
     * https://www.php.net/manual/fr/ref.pdo-mysql.connection.php
     */
    private const DSN = 'mysql:host=' . BD::HOST . ';dbname=' . BD::DB_NAME . ';charset=' . BD::CHARSET;
    /** Nom d'utilisateur pour accéder à la BD */
    private const USER = 'root';
    /** Mot de passe pour accéder à la BD */
    private const PASSWORD = 'root_password';
    /** Autres options de connection. */
    private const OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lorsque que PDO rencontre une erreur, il lance une exception
        PDO::ATTR_EMULATE_PREPARES => false, // Protection contre l'injection de 2ème niveau
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Fetch retourne un tableau associatif
    ];

    /** @return PDO Une connexion à la base de données */
    public static function ObtenirConnexion()
    {
        // https://www.php.net/manual/en/pdo.construct.php
        return new PDO(BD::DSN, BD::USER, BD::PASSWORD, BD::OPTIONS);
    }
}
