CREATE DATABASE IF NOT EXISTS `exemple_ajax_bd`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

USE `exemple_ajax_bd`;
SET default_storage_engine=InnoDB;

-- Table des utilisateurs
CREATE TABLE `utilisateurs` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nom` varchar(45) NOT NULL,
    `mot_de_passe` varchar(255) NOT NULL,
    `email` varchar(255) DEFAULT NULL,
    `image` varchar(2048) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`nom`)
);

INSERT INTO `utilisateurs` (`id`, `nom`, `mot_de_passe`) VALUES
    (1, 'admin', '$2y$12$uGwARXPnomr0u/OtCTBNzeKlhpURriaiDBQJZm.rY0TqN0Hk9x/VO'); -- Mot de passe haché pour '123456'

INSERT INTO `utilisateurs` (`id`, `nom`, `mot_de_passe`, `email`, `image`) VALUES
    (2, 'user1', '$2y$12$aCX4MDnlrfoHgS5BDmQ8Me/mfO37WpHdbMtgj1s8Ul5EtceePi/mi', 'user1@example.com', 'https://placehold.co/42'); -- Mot de passe haché pour 'password1'
