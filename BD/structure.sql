CREATE SCHEMA `central_esterilizacion` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `central_esterilizacion`;

CREATE TABLE `empresaesterilizadora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `metodo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `operadorce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE `material` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `operador` BIGINT(20) NULL,
  `fecha` VARCHAR(50) NULL,
  `hora` VARCHAR(50) NULL,
  `paciente` VARCHAR(100) NULL,
  `numeroHistoriaClinica` BIGINT(20) NULL,
  `descripcionMaterial` VARCHAR(100) NULL,
  `medicoSolicitante` VARCHAR(100) NULL,
  `pesoDeLaCaja` VARCHAR(100) NULL,
  `proveedor` BIGINT(20) NULL,
  `empresa` BIGINT(20) NULL,
  `metodo` BIGINT(20) NULL,
  `observaciones` VARCHAR(100) NULL,
  PRIMARY KEY (`id`)
  )ENGINE=InnoDB CHARSET=utf8;
