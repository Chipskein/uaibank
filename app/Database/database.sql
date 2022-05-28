CREATE DATABASE uaibank;
USE uaibank;
CREATE TABLE IF NOT EXISTS `Users`(
    `id` INTEGER AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(300) NOT NULL UNIQUE,
    `password` VARCHAR(300) NOT NULL,
    `name` VARCHAR(300) NOT NULL,
    `birthdate` DATETIME NOT NULL,
    PRIMARY KEY(`id`)
);
CREATE TABLE IF NOT EXISTS `Accounts`(
    `id` INTEGER AUTO_INCREMENT NOT NULL,
    `user` INTEGER NOT NULL,
    `balance` DECIMAL(15,2) NOT NULL,
    `type` VARCHAR(15) NOT NULL,
    FOREIGN KEY (user) REFERENCES Users(id),
    PRIMARY KEY(id,user,type)
);

CREATE TABLE IF NOT EXISTS `UsersSessions`(
    `username` VARCHAR(300) NOT NULL,
    `password` VARCHAR(300) NOT NULL,
    `login` DATETIME NOT NULL,
    `logout` DATETIME NOT NULL
);
CREATE TABLE IF NOT EXISTS `Transfers`(
    `id` INTEGER AUTO_INCREMENT NOT NULL,
    `type` VARCHAR(20) NOT NULL,
    `from` INTEGER NOT NULL,
    `to` INTEGER NOT NULL,
    `description` VARCHAR(150),
    `transfer_date` DATETIME NOT NULL, 
    `value` DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (`from`) REFERENCES `Accounts`(id),
    FOREIGN KEY (`to`) REFERENCES `Accounts`(id),
    PRIMARY KEY(`id`)
);

-- CREATE INTERNAL ACCOUNT
INSERT INTO `Users`(username, password, name, birthdate) VALUES('uaibank', '""', 'uaibank', '2002-09-05');
INSERT INTO `Accounts`(`user`, balance, `type`) VALUES(1, 1, 9999999999.00, 'special');
