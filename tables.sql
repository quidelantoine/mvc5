CREATE DATABASE emprunt;

USE emprunt;

CREATE TABLE IF NOT EXISTS abonnes (
    `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nom` varchar(255) NOT NULL,
    `prenom` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `age` int(11) NOT NULL,
    `created_at` datetime NOT NULL
) ENGINE=InnobDB DEFAULT CHARSET=utf8mb4 ;

CREATE TABLE IF NOT EXISTS products (
    `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `titre` varchar(255) NOT NULL,
    `reference` varchar(255) NOT NULL,
    `description` text NOT NULL
) ;

CREATE TABLE IF NOT EXISTS borrows (
    `id` INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_abonne` int(11) NOT NULL,
    `id_product` int(11) NOT NULL,
    `date_start` datetime NOT NULL,
    `date_end` datetime NULL
) 