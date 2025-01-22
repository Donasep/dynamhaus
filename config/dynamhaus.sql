-- MySQL Script generated by MySQL Workbench
-- Fri Dec 13 16:19:00 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dynamhaus
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dynamhaus
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dynamhaus` DEFAULT CHARACTER SET utf8mb4 ;
USE `dynamhaus` ;

-- -----------------------------------------------------
-- Table `dynamhaus`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`user` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(320) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `firstName` VARCHAR(45) NOT NULL,
  `role` ENUM('STUDENT', 'ADMIN', 'AGENCY', 'RESIDENCE', 'INDIVIDUAL') NOT NULL DEFAULT 'STUDENT',
  `verified` TINYINT NOT NULL,
  `avatarUrl` VARCHAR(320) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idUser_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dynamhaus`.`ad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`ad` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`ad` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `address` VARCHAR(320) NOT NULL,
  `price` INT NOT NULL,
  `surface` INT NOT NULL,
  `gear` VARCHAR(320) NULL DEFAULT '',
  `applicationFee` INT NULL,
  `charges` INT NULL,
  `warranty` INT NULL,
  `availabilityDate` DATE NULL,
  `description` VARCHAR(10000) NOT NULL,
  `title` VARCHAR(600) NOT NULL,
  `floor` INT NULL,
  `furnished` TINYINT NOT NULL,
  `active` TINYINT NOT NULL DEFAULT 0,
  `animals` TINYINT NOT NULL DEFAULT 0,
  `coordinates` VARCHAR(45) NOT NULL,
  `numberOfBedrooms` INT NOT NULL,
  `duration` DATETIME NULL,
  `verified` TINYINT NOT NULL DEFAULT 0,
  `apartmentType` INT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ad_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_ad_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dynamhaus`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dynamhaus`.`alert`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`alert` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`alert` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `address` VARCHAR(320) NULL,
  `minPrice` INT NOT NULL,
  `maxPrice` INT NOT NULL,
  `minSurface` INT NOT NULL,
  `maxSurface` INT NOT NULL,
  `radius` INT NOT NULL,
  `ProposedBy` VARCHAR(45) NOT NULL,
  `appartement type` INT NULL,
  `coordinates` VARCHAR(45) NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `fk_alert_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_alert_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dynamhaus`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dynamhaus`.`picture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`picture` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`picture` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(320) NOT NULL,
  `ad_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_picture_ad1_idx` (`ad_id` ASC) ,
  CONSTRAINT `fk_picture_ad1`
    FOREIGN KEY (`ad_id`)
    REFERENCES `dynamhaus`.`ad` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dynamhaus`.`conversation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`conversation` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`conversation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dynamhaus`.`message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`message` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` VARCHAR(6000) NOT NULL,
  `readState` TINYINT NOT NULL DEFAULT 0,
  `uploadTime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  `Conversation_id` INT NOT NULL,
  PRIMARY KEY (`id`, `user_id`, `Conversation_id`),
  INDEX `fk_message_user1_idx` (`user_id` ASC) ,
  INDEX `fk_message_Conversation1_idx` (`Conversation_id` ASC) ,
  CONSTRAINT `fk_message_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dynamhaus`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_message_Conversation1`
    FOREIGN KEY (`conversation_id`)
    REFERENCES `dynamhaus`.`conversation` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dynamhaus`.`favorite`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`favorite` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`favorite` (
  `User_id` INT NOT NULL,
  `ad_id` INT NOT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  INDEX `fk_User_has_ad_ad1_idx` (`ad_id` ASC) ,
  INDEX `fk_User_has_ad_User1_idx` (`User_id` ASC) ,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_User_has_ad_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dynamhaus`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_User_has_ad_ad1`
    FOREIGN KEY (`ad_id`)
    REFERENCES `dynamhaus`.`ad` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dynamhaus`.`user_has_conversation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dynamhaus`.`user_has_conversation` ;

CREATE TABLE IF NOT EXISTS `dynamhaus`.`user_has_conversation` (
  `user_id` INT NOT NULL,
  `conversation_id` INT NOT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  INDEX `fk_user_has_Conversation_Conversation1_idx` (`conversation_id` ASC) ,
  INDEX `fk_user_has_Conversation_user1_idx` (`user_id` ASC) ,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_has_Conversation_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `dynamhaus`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_has_Conversation_Conversation1`
    FOREIGN KEY (`conversation_id`)
    REFERENCES `dynamhaus`.`conversation` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
