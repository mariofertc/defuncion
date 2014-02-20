SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `rutamobil` DEFAULT CHARACTER SET latin1 ;
USE `rutamobil` ;

-- -----------------------------------------------------
-- Table `rutamobil`.`provincia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rutamobil`.`provincia` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  `descripcion` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rutamobil`.`ciudad`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rutamobil`.`ciudad` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  `descripcion` VARCHAR(255) NULL ,
  `provincia_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ciudad_provincia1` (`provincia_id` ASC) ,
  CONSTRAINT `fk_ciudad_provincia1`
    FOREIGN KEY (`provincia_id` )
    REFERENCES `rutamobil`.`provincia` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rutamobil`.`categoria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rutamobil`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  `descripcion` VARCHAR(255) NULL ,
  `ciudad_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `ciudad_id`) ,
  INDEX `fk_categoria_ciudad1` (`ciudad_id` ASC) ,
  CONSTRAINT `fk_categoria_ciudad1`
    FOREIGN KEY (`ciudad_id` )
    REFERENCES `rutamobil`.`ciudad` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rutamobil`.`lugar`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rutamobil`.`lugar` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(256) NOT NULL ,
  `direccion` VARCHAR(255) NULL ,
  `coordenadas` VARCHAR(256) NOT NULL ,
  `imagen_path` VARCHAR(256) NULL DEFAULT NULL ,
  `descripcion` VARCHAR(512) NOT NULL ,
  `fecha_actualizacion` DATETIME NOT NULL ,
  `categoria_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_lugar_categoria` (`categoria_id` ASC) ,
  CONSTRAINT `fk_lugar_categoria`
    FOREIGN KEY (`categoria_id` )
    REFERENCES `rutamobil`.`categoria` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `rutamobil`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rutamobil`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `usuario` VARCHAR(45) NULL ,
  `clave` VARCHAR(45) NULL ,
  `nombre` VARCHAR(45) NULL ,
  `apellido` VARCHAR(45) NULL ,
  `direccion` VARCHAR(245) NULL ,
  `email` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rutamobil`.`log_evento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rutamobil`.`log_evento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NULL ,
  `modulo` VARCHAR(45) NULL ,
  `stack_trace` VARCHAR(45) NULL ,
  `fecha` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `rutamobil`.`calificacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rutamobil`.`calificacion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `calificacion` INT NULL DEFAULT 0 ,
  `fecha` VARCHAR(45) NULL ,
  `lugar_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`, `lugar_id`) ,
  INDEX `fk_calificacion_lugar1` (`lugar_id` ASC) ,
  CONSTRAINT `fk_calificacion_lugar1`
    FOREIGN KEY (`lugar_id` )
    REFERENCES `rutamobil`.`lugar` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `rutamobil`.`provincia`
-- -----------------------------------------------------
START TRANSACTION;
USE `rutamobil`;
INSERT INTO `rutamobil`.`provincia` (`id`, `nombre`, `descripcion`) VALUES (1, 'Tungurahua', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `rutamobil`.`ciudad`
-- -----------------------------------------------------
START TRANSACTION;
USE `rutamobil`;
INSERT INTO `rutamobil`.`ciudad` (`id`, `nombre`, `descripcion`, `provincia_id`) VALUES (1, 'Baños', NULL, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `rutamobil`.`categoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `rutamobil`;
INSERT INTO `rutamobil`.`categoria` (`id`, `nombre`, `descripcion`, `ciudad_id`) VALUES (1, 'Iglesias', NULL, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `rutamobil`.`lugar`
-- -----------------------------------------------------
START TRANSACTION;
USE `rutamobil`;
INSERT INTO `rutamobil`.`lugar` (`id`, `nombre`, `direccion`, `coordenadas`, `imagen_path`, `descripcion`, `fecha_actualizacion`, `categoria_id`) VALUES (2, 'Iglesia de la Virgen de Agua Santa', 'This place is located 7 kilometers north of Jepara city center. The way to get there is very easy. Just follow the traffic sign and you will find it. From the town square, follow the road to Bangsri then turn left when reached kuwasen village. You can take public transportation or by your own vehicle.', '{\'latitud\':200,\'longitud\':100}', '/img/iglesia_virgen_agua_santa.jpg', 'Construida con piedra volcánica.', 'now()', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `rutamobil`.`calificacion`
-- -----------------------------------------------------
START TRANSACTION;
USE `rutamobil`;
INSERT INTO `rutamobil`.`calificacion` (`id`, `calificacion`, `fecha`, `lugar_id`) VALUES (1, 4, NULL, 2);

COMMIT;
