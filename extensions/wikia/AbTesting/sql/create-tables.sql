SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `ab_experiments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ab_experiments` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `description` TINYBLOB NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ab_experiment_groups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ab_experiment_groups` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `description` TINYBLOB NULL ,
  `experiment_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `experiment_id` (`experiment_id` ASC) ,
  CONSTRAINT `fk_group_experiment`
    FOREIGN KEY (`experiment_id` )
    REFERENCES `ab_experiments` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ab_experiment_versions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ab_experiment_versions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `experiment_id` INT NOT NULL ,
  `start_time` DATETIME NOT NULL ,
  `end_time` DATETIME NOT NULL ,
  `ga_slot` VARCHAR(45) NOT NULL ,
  `control_group_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `experiment_id` (`experiment_id` ASC) ,
  INDEX `control_group_id` (`control_group_id` ASC) ,
  CONSTRAINT `fk_version_experiment`
    FOREIGN KEY (`experiment_id` )
    REFERENCES `ab_experiments` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_version_control_group`
    FOREIGN KEY (`control_group_id` )
    REFERENCES `ab_experiment_groups` (`id` )
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ab_experiment_group_ranges`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ab_experiment_group_ranges` (
  `group_id` INT NOT NULL ,
  `version_id` INT NOT NULL ,
  `ranges` VARCHAR(255) NULL ,
  INDEX `group_id` (`group_id` ASC) ,
  INDEX `version_id` (`version_id` ASC) ,
  PRIMARY KEY (`version_id`, `group_id`) ,
  CONSTRAINT `fk_range_group`
    FOREIGN KEY (`group_id` )
    REFERENCES `ab_experiment_groups` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_range_version`
    FOREIGN KEY (`version_id` )
    REFERENCES `ab_experiment_versions` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ab_config`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ab_config` (
  `id` INT NOT NULL ,
  `updated` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
