CREATE DATABASE IF NOT EXISTS `exercice_fichier_bd` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;

USE `exercice_fichier_bd`;

SET default_storage_engine = InnoDB;

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

INSERT INTO
    `utilisateurs` (`id`, `nom`, `mot_de_passe`)
VALUES (
        1,
        'admin',
        '$2y$12$uGwARXPnomr0u/OtCTBNzeKlhpURriaiDBQJZm.rY0TqN0Hk9x/VO'
    );
-- Mot de passe haché pour '123456'

INSERT INTO
    `utilisateurs` (
        `id`,
        `nom`,
        `mot_de_passe`,
        `email`,
        `image`
    )
VALUES (
        2,
        'user1',
        '$2y$12$aCX4MDnlrfoHgS5BDmQ8Me/mfO37WpHdbMtgj1s8Ul5EtceePi/mi',
        'user1@example.com',
        'https://placehold.co/42'
    );
-- Mot de passe haché pour 'password1'

CREATE TABLE `fichiers` (
    `id` int NOT NULL AUTO_INCREMENT,
    `utilisateurs_id` int NOT NULL,
    `nom_original` varchar(255) NOT NULL,
    `chemin_fichier` varchar(255) NOT NULL,
    `date_televersement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`utilisateurs_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
);

CREATE TABLE `marques` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `modeles` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    `marques_id` INT NOT NULL,
    FOREIGN KEY (marques_id) REFERENCES marques (id),
    PRIMARY KEY (`id`)
);

CREATE TABLE `rendez_vous` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `description` TEXT NOT NULL,
    `utilisateurs_id` INT NOT NULL,
    `modeles_id` INT NOT NULL,
    FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id),
    FOREIGN KEY (modeles_id) REFERENCES modeles (id),
    PRIMARY KEY (`id`)
);

CREATE TABLE `images_rendez_vous` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nom_original` varchar(255) NOT NULL,
    `chemin_fichier` VARCHAR(255) NOT NULL,
    `rendez_vous_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id) ON DELETE CASCADE
);

INSERT INTO `marques` (`nom`) VALUES
('Toyota'),
('Honda'),
('Ford'),
('Chevrolet'),
('Nissan'),
('BMW'),
('Mercedes'),
('Audi'),
('Volkswagen'),
('Hyundai'),
('Kia'),
('Subaru'),
('Mazda'),
('Lexus'),
('Jaguar');

INSERT INTO `modeles` (`nom`, `marques_id`) VALUES
-- TOYOTA
('Corolla', 1),
('Camry', 1),
('RAV4', 1),
('Highlander', 1),
('Tacoma', 1),
('4Runner', 1),
('Avalon', 1),
-- HONDA
('Civic', 2),
('Accord', 2),
('CR-V', 2),
('Fit', 2),
('Pilot', 2),
('Odyssey', 2),
('Ridgeline', 2),
('HR-V', 2),
('Passport', 2),
-- FORD
('Mustang', 3),
('F-150', 3),
('Focus', 3),
('Explorer', 3),
('Fusion', 3),
('Escape', 3),
('Edge', 3),
('Expedition', 3),
('Ranger', 3),
-- CHEVROLET
('Malibu', 4),
('Impala', 4),
('Cruze', 4),
('Tahoe', 4),
('Equinox', 4),
('Suburban', 4),
('Silverado', 4),
('Blazer', 4),
('Traverse', 4),
-- NISSAN
('Altima', 5),
('Maxima', 5),
('Sentra', 5),
('Versa', 5),
('Rogue', 5),
('Murano', 5),
('Pathfinder', 5),
('Armada', 5),
('370Z', 5),
-- BMW
('3 Series', 6),
('5 Series', 6),
('X5', 6),
('X3', 6),
('i8', 6),
('7 Series', 6),
('Z4', 6),
('2 Series', 6),
('M3', 6),
-- MERCEDES
('A-Class', 7),
('C-Class', 7),
('E-Class', 7),
('S-Class', 7),
('GLA', 7),
('GLC', 7),
('GLE', 7),
('GLS', 7),
('B-Class', 7),
-- AUDI
('A3', 8),
('A4', 8),
('A5', 8),
('A6', 8),
('A7', 8),
('Q3', 8),
('Q5', 8),
('Q7', 8),
('Q8', 8),
-- VOLKSWAGEN
('Golf', 9),
('Jetta', 9),
('Passat', 9),
('Tiguan', 9),
('Touareg', 9),
('Beetle', 9),
('Arteon', 9),
('Polo', 9),
('ID.4', 9),
-- HYUNDAI
('Elantra', 10),
('Sonata', 10),
('Tucson', 10),
('Santa Fe', 10),
('Palisade', 10),
('Kona', 10),
('Venue', 10),
('Ioniq', 10),
('Veloster', 10),
-- KIA
('Rio', 11),
('Forte', 11),
('Optima', 11),
('Stinger', 11),
('Soul', 11),
('Seltos', 11),
('Sportage', 11),
('Sorento', 11),
('Telluride', 11),
-- SUBARU
('Impreza', 12),
('Legacy', 12),
('Outback', 12),
('Forester', 12),
('Crosstrek', 12),
('Ascent', 12),
('BRZ', 12),
('WRX', 12),
('Solterra', 12),
-- MAZDA
('Mazda3', 13),
('Mazda6', 13),
('CX-3', 13),
('CX-5', 13),
('CX-9', 13),
('MX-5 Miata', 13),
('CX-30', 13),
('CX-50', 13),
('Mazda2', 13),
-- LEXUS
('IS', 14),
('ES', 14),
('GS', 14),
('LS', 14),
('NX', 14),
('RX', 14),
('GX', 14),
('LX', 14),
('LC', 14),
-- JAGUAR
('XE', 15),
('XF', 15),
('XJ', 15),
('F-Type', 15),
('E-Pace', 15),
('F-Pace', 15),
('I-Pace', 15),
('XK', 15),
('XFR-S', 15);


SELECT
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
INNER JOIN marques ON marques.id = modeles.marques_id;

SELECT images_rendez_vous.*, rendez_vous.utilisateurs_id
FROM images_rendez_vous
INNER JOIN rendez_vous ON rendez_vous.id = images_rendez_vous.rendez_vous_id;
