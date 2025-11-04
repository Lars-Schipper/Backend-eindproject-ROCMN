DROP DATABASE IF EXISTS `trade_index`;

CREATE DATABASE `trade_index`;

USE `trade_index`;

CREATE TABLE `users`(
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    voornaam VARCHAR(100) NOT NULL,
    achternaam VARCHAR(100) NOT NULL,
    gebruiker VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    wachtwoord VARCHAR(100) NOT NULL,
    telefoonNummer INT(10) NOT NULL,
    postcode VARCHAR(100) NOT NULL,
    woonplaats VARCHAR(100) NOT NULL,
    straatnaam VARCHAR(100) NOT NULL,
    huisnummer VARCHAR(100) NOT NULL,
    vrijeruimte FLOAT NULL
);

INSERT INTO `users`(voornaam, achternaam, gebruiker, email, wachtwoord, telefoonNummer, postcode, woonplaats, straatnaam, huisnummer, vrijeruimte) VALUES ('admin','admin', 'admin', 'admin', '$2y$10$YcAaKYPLTxl8JIkO0WOfVemYdkx09eWakqMFupVLUOUBP2kvYFAtq', '0619487033', 'admin', 'admin', 'admin', 'admin', '1000');

CREATE TABLE `aandelen_beheer`(
    transactieID MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id INT(10) NOT NULL,
    aandeelId VARCHAR(10) NOT NULL,
    quantiteit INT(10) NOT NULL,
    aankoopPrijs FLOAT(10) NOT NULL
);

INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'AAPL', '10', '100.01');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'TSLA', '4', '100.99');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'AMZN', '8', '300.01');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'AMZN', '2', '213.06');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'ABCB', '11', '43.99');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'AMZN', '9', '32.01');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'ABNB', '3', '32.88');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'ABNB', '2', '123.99');
INSERT INTO `aandelen_beheer`(id, aandeelId, quantiteit, aankoopPrijs) VALUES ('1', 'AAON', '5', '123.47');