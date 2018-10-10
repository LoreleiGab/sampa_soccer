-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sampa
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sampa
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sampa` DEFAULT CHARACTER SET utf8 ;
USE `sampa` ;

-- -----------------------------------------------------
-- Table `sampa`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(160) NOT NULL,
  `email` VARCHAR(60) NOT NULL,
  `telefone` VARCHAR(15) NOT NULL,
  `senha` VARCHAR(120) NOT NULL,
  `data_ativação` DATE NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`clientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`clientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(180) NOT NULL,
  `apelido` VARCHAR(50) NULL,
  `posicao` VARCHAR(15) NULL,
  `pe_dominante` VARCHAR(45) NULL,
  `data_nascimento` DATE NOT NULL,
  `clube` VARCHAR(60) NULL,
  `categoria` VARCHAR(10) NULL,
  `telefone01` VARCHAR(15) NOT NULL,
  `telefone02` VARCHAR(15) NULL,
  `emal` VARCHAR(50) NOT NULL,
  `diagnostico` LONGTEXT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_clientes_usuarios1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_clientes_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `sampa`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`avaliacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`avaliacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente_id` INT NOT NULL,
  `data` DATE NOT NULL,
  `altura` DECIMAL(3,2) NULL,
  `peso` DECIMAL(3,2) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_avaliacoes_clientes_idx` (`cliente_id` ASC),
  CONSTRAINT `fk_avaliacoes_clientes`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `sampa`.`clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`antropometrias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`antropometrias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `avaliacao_id` INT NULL,
  `tricpital` DECIMAL(2,1) NULL,
  `perna` DECIMAL(2,1) NULL,
  `umero` DECIMAL(2,1) NULL,
  `femur` DECIMAL(2,1) NULL,
  `punho` DECIMAL(2,1) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_antropometrias_avaliacoes1_idx` (`avaliacao_id` ASC),
  CONSTRAINT `fk_antropometrias_avaliacoes`
    FOREIGN KEY (`avaliacao_id`)
    REFERENCES `sampa`.`avaliacoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`perimetrias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`perimetrias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `avaliacao_id` INT NOT NULL,
  `torax` DECIMAL(3,1) NULL,
  `cintura` DECIMAL(3,1) NULL,
  `abdome` DECIMAL(3,1) NULL,
  `quadril` DECIMAL(3,1) NULL,
  `coxa_direita` DECIMAL(3,1) NULL,
  `coxa_esquerda` DECIMAL(3,1) NULL,
  `perna_direita` DECIMAL(3,1) NULL,
  `perna_esquerda` DECIMAL(3,1) NULL,
  `biceps_direito` DECIMAL(3,1) NULL,
  `biceps_esquerdo` DECIMAL(3,1) NULL,
  `punho` DECIMAL(2,1) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_perimetrias_avaliacoes_idx` (`avaliacao_id` ASC),
  CONSTRAINT `fk_perimetrias_avaliacoes1`
    FOREIGN KEY (`avaliacao_id`)
    REFERENCES `sampa`.`avaliacoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`estaturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`estaturas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente_id` INT NOT NULL,
  `estatura_pai` DECIMAL(3,1) NOT NULL,
  `estatura_mae` DECIMAL(3,1) NOT NULL,
  `estatura_prevista` DECIMAL(3,1) NOT NULL,
  `estimativa` DECIMAL(3,1) NOT NULL,
  `margem_erro01` DECIMAL(3,1) NOT NULL,
  `margem_erro02` DECIMAL(3,1) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_estaturas_clientes1_idx` (`cliente_id` ASC),
  CONSTRAINT `fk_estaturas_clientes`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `sampa`.`clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`imcs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`imcs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `avaliacao_id` INT NOT NULL,
  `altura_dobro` DECIMAL(3,2) NOT NULL,
  `resultado` DECIMAL(2,2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_imcs_avaliacoes_idx` (`avaliacao_id` ASC),
  CONSTRAINT `fk_imcs_avaliacoes1`
    FOREIGN KEY (`avaliacao_id`)
    REFERENCES `sampa`.`avaliacoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`wells`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`wells` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `avaliacao_id` INT NOT NULL,
  `medida` SMALLINT(3) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_wells_avaliacoes1_idx` (`avaliacao_id` ASC),
  CONSTRAINT `fk_wells_avaliacoes`
    FOREIGN KEY (`avaliacao_id`)
    REFERENCES `sampa`.`avaliacoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`classificacao_imcs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`classificacao_imcs` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sampa`.`classificacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sampa`.`classificacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_classificacao` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;