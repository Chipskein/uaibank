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
    `balance` DECIMAL NOT NULL,
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
    `value` DECIMAl NOT NULL,
    FOREIGN KEY (`from`) REFERENCES `Accounts`(id),
    FOREIGN KEY (`to`) REFERENCES `Accounts`(id),
    PRIMARY KEY(`id`)
);

