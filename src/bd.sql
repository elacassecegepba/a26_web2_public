CREATE DATABASE IF NOT EXISTS `exercice_bd`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

USE `exercice_bd`;
SET default_storage_engine=InnoDB;

-- Table des utilisateurs
CREATE TABLE `utilisateurs` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nom` varchar(45) NOT NULL,
    `mot_de_passe` varchar(45) NOT NULL,
    `email` varchar(255) DEFAULT NULL,
    `image` varchar(2048) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`nom`)
);

INSERT INTO `utilisateurs` (`id`, `nom`, `mot_de_passe`) VALUES
    (1, 'admin', '123456');

INSERT INTO `utilisateurs` (`id`, `nom`, `mot_de_passe`, `email`, `image`) VALUES
    (2, 'user1', 'password1', 'user1@example.com', 'https://placehold.co/42');