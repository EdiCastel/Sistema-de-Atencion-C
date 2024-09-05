-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bd_ac
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `bd_ac` ;

-- -----------------------------------------------------
-- Schema bd_ac
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bd_ac` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `bd_ac` ;


-- -----------------------------------------------------
-- Table `bd_ac`.`ciudadanos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`ciudadanos` (
  `id_ciudadano` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido_paterno` VARCHAR(20) NOT NULL,
  `apellido_materno` VARCHAR(20) NOT NULL,
  `sexo` VARCHAR(50) NOT NULL,
  `curp` VARCHAR(18) NOT NULL,
  `seccion_electoral` INT NOT NULL,
  `id_localidad` INT NOT NULL,
  `direccion` VARCHAR(100) NOT NULL,
  `referencia` VARCHAR(100) NOT NULL,
  `telefono` BIGINT NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_ciudadano`),
  INDEX `id_localidad_idx` (`id_localidad` ASC) VISIBLE,
  CONSTRAINT `id_localidad`
    FOREIGN KEY (`id_localidad`)
    REFERENCES `bd_ac`.`localidades` (`id_localidad`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `ciudadanos`
--

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`comites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`comites` (
  `id_comites` INT NOT NULL AUTO_INCREMENT,
  `nombre_comite` VARCHAR(80) NOT NULL,
  `detalles_comite` VARCHAR(1000) NOT NULL,
  `id_localidad` INT NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_comites`),
  INDEX `id_localidad_idx` (`id_localidad` ASC) VISIBLE,
  CONSTRAINT `fk_localidad`
    FOREIGN KEY (`id_localidad`)
    REFERENCES `bd_ac`.`localidades` (`id_localidad`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `comites`
--

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`departamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`departamentos` (
  `id_departamento` INT NOT NULL AUTO_INCREMENT,
  `departamento` VARCHAR(50) NOT NULL,
  `titular` VARCHAR(50) NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_departamento`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `departamentos`
--

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`estados` (
  `id_estado` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_estado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- --------------------------------------------------------
--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` VALUES(NULL, 'RECIBIDA');
INSERT INTO `estados` VALUES(NULL, 'EN EVALUACIÓN');
INSERT INTO `estados` VALUES(NULL, 'EN PROCESO');
INSERT INTO `estados` VALUES(NULL, 'REPROGRAMADA');
INSERT INTO `estados` VALUES(NULL, 'RECHAZADA');
INSERT INTO `estados` VALUES(NULL, 'COMPLETADA');
INSERT INTO `estados` VALUES(NULL, 'PENDIENTE DE INFORMACIÓN');
INSERT INTO `estados` VALUES(NULL, 'EN ESPERA DE RECURSOS');
INSERT INTO `estados` VALUES(NULL, 'CANCELADA');

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`evidencias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`evidencias` (
  `id_evidencia` INT NOT NULL AUTO_INCREMENT,
  `ruta` VARCHAR(80) NOT NULL,
  `tipo_evidencia` INT NOT NULL,
  `comentarios` VARCHAR(200) NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_evidencia`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `evidencias`
--

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`evidencias_solicitudes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`evidencias_solicitudes` (
  `id_evidencias_solicitud` INT NOT NULL AUTO_INCREMENT,
  `id_solicitud` INT NOT NULL,
  `id_evidencia` INT NOT NULL,
  PRIMARY KEY (`id_evidencias_solicitud`),
  INDEX `id_solicitud` (`id_solicitud` ASC) VISIBLE,
  INDEX `id_evidencia` (`id_evidencia` ASC) VISIBLE,
  CONSTRAINT `evidencias_solicitudes_ibfk_1`
    FOREIGN KEY (`id_solicitud`)
    REFERENCES `bd_ac`.`solicitudes` (`id_solicitud`),
  CONSTRAINT `evidencias_solicitudes_ibfk_2`
    FOREIGN KEY (`id_evidencia`)
    REFERENCES `bd_ac`.`evidencias` (`id_evidencia`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8; 

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `evidencias_solicitudes`
--

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`historial_estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`historial_estados` (
  `id_historial_estado` INT NOT NULL AUTO_INCREMENT,
  `id_solicitud` INT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `id_estado_solicitud` INT NOT NULL,
  PRIMARY KEY (`id_historial_estado`),
  INDEX `id_solicitudes` (`id_solicitud` ASC) VISIBLE,
  INDEX `id_estado_solicitudes` (`id_estado_solicitud` ASC) VISIBLE,
  CONSTRAINT `historial_estados_ibfk_1`
    FOREIGN KEY (`id_solicitud`)
    REFERENCES `bd_ac`.`solicitudes` (`id_solicitud`),
  CONSTRAINT `historial_estados_ibfk_2`
    FOREIGN KEY (`id_estado_solicitud`)
    REFERENCES `bd_ac`.`estados` (`id_estado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------

--
-- Volcado de datos para la tabla `historial_estados`
--

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`integrantes_comites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`integrantes_comites` (
  `id_integrantes_comites` INT NOT NULL AUTO_INCREMENT,
  `id_ciudadano` INT NOT NULL,
  `id_comite` INT NOT NULL,
  PRIMARY KEY (`id_integrantes_comites`),
  INDEX `id_ciudadano` (`id_ciudadano` ASC) VISIBLE,
  INDEX `id_comite` (`id_comite` ASC) VISIBLE,
  CONSTRAINT `integrantes_comites_ibfk_1`
    FOREIGN KEY (`id_ciudadano`)
    REFERENCES `bd_ac`.`ciudadanos` (`id_ciudadano`),
  CONSTRAINT `integrantes_comites_ibfk_2`
    FOREIGN KEY (`id_comite`)
    REFERENCES `bd_ac`.`comites` (`id_comites`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

--
-- Volcado de datos para la tabla `integrantes_comites`
--


-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`localidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`localidades` (
  `id_localidad` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(30) NOT NULL,
  `nombre_referencia` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_localidad`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` VALUES(NULL, 'ACAPULCO', 'EL CRUCERO DE ZENTLA');
INSERT INTO `localidades` VALUES(NULL, 'AGUA ESCONDIDA', 'AGUA ESCONDIDA');
INSERT INTO `localidades` VALUES(NULL, 'ARROYO ZARCO', 'ARROYO ZARCO');
INSERT INTO `localidades` VALUES(NULL, 'BUENA VISTA', 'BUENA VISTA');
INSERT INTO `localidades` VALUES(NULL, 'COLONIA CHIQUITA', 'COLONIA CHIQUITA');
INSERT INTO `localidades` VALUES(NULL, 'COLONIA MANUEL GONZALEZ', 'COLONIA MANUEL GONZALEZ');
INSERT INTO `localidades` VALUES(NULL, 'COYOLITO', 'COYOLITO');
INSERT INTO `localidades` VALUES(NULL, 'CONTADERO', 'CONTADERO');
INSERT INTO `localidades` VALUES(NULL, 'CORAZON DE JESUS', 'PIÑA');
INSERT INTO `localidades` VALUES(NULL, 'COYOTEPEC', 'COYOTEPEC');
INSERT INTO `localidades` VALUES(NULL, 'DOS DE ABRIL', 'DOS DE ABRIL');
INSERT INTO `localidades` VALUES(NULL, 'DOS LUCEROS', 'DOS LUCEROS');
INSERT INTO `localidades` VALUES(NULL, 'EJIDO LA PIÑA', 'MAROMILLA');
INSERT INTO `localidades` VALUES(NULL, 'EL CASTILLO', 'EL CASTILLO');
INSERT INTO `localidades` VALUES(NULL, 'EL CAZON', 'EL CAZON');
INSERT INTO `localidades` VALUES(NULL, 'EL CONSUELO', 'EL CONSUELO');
INSERT INTO `localidades` VALUES(NULL, 'EL HUAJE', 'EL HUAJE');
INSERT INTO `localidades` VALUES(NULL, 'EL LEON', 'EL LEON');
INSERT INTO `localidades` VALUES(NULL, 'EL OLVIDO', 'EL OLVIDO');
INSERT INTO `localidades` VALUES(NULL, 'EL POCHOTE', 'EL POCHOTE');
INSERT INTO `localidades` VALUES(NULL, 'EL REFUGIO', 'EL REFUGIO');
INSERT INTO `localidades` VALUES(NULL, 'EL TIGRE', 'EL TIGRE');
INSERT INTO `localidades` VALUES(NULL, 'LA ESTRELLA', 'LA ESTRELLA');
INSERT INTO `localidades` VALUES(NULL, 'LA FLOR', 'LA FLOR');
INSERT INTO `localidades` VALUES(NULL, 'LA REFORMA ', 'LA REFORMA');
INSERT INTO `localidades` VALUES(NULL, 'LA REPRESA', 'LA REPRESA');
INSERT INTO `localidades` VALUES(NULL, 'LOMA SOLA', 'LOMA SOLA');
INSERT INTO `localidades` VALUES(NULL, 'LOS BARREALES', 'LOS BARREALES');
INSERT INTO `localidades` VALUES(NULL, 'MAFARA', 'MAFARA');
INSERT INTO `localidades` VALUES(NULL, 'MAROMILLA', 'MAROMILLA');
INSERT INTO `localidades` VALUES(NULL, 'MATA COYOTE', 'MATA COYOTE');
INSERT INTO `localidades` VALUES(NULL, 'MATA PASTOR', 'MATA PASTOR');
INSERT INTO `localidades` VALUES(NULL, 'MATLALUCA', 'MATLALUCA');
INSERT INTO `localidades` VALUES(NULL, 'PASO DEL CEDRO', 'PASO DEL CEDRO');
INSERT INTO `localidades` VALUES(NULL, 'PASO TIO TONCHE', 'LOS ALMENDROS');
INSERT INTO `localidades` VALUES(NULL, 'POTRERO', 'POTRERILLO');
INSERT INTO `localidades` VALUES(NULL, 'PUEBLITO DE MATLALUCA', 'PUEBLITO DE MATLALUCA');
INSERT INTO `localidades` VALUES(NULL, 'PUENTECILLA', 'PUENTECILLA');
INSERT INTO `localidades` VALUES(NULL, 'RINCON CAZUELA', 'RINCON CAZUELA');
INSERT INTO `localidades` VALUES(NULL, 'RINCON CORIA', 'RINCON TLACUACHE');
INSERT INTO `localidades` VALUES(NULL, 'RINCON MARIANO', 'RINCON MARIANO');
INSERT INTO `localidades` VALUES(NULL, 'RINCON PATIÑO', 'RINCON PATIÑO');
INSERT INTO `localidades` VALUES(NULL, 'RINCON TIO TAMAL', 'RINCON TIO TAMAL');
INSERT INTO `localidades` VALUES(NULL, 'SAN JORGE', 'SAN JORGE');
INSERT INTO `localidades` VALUES(NULL, 'SAN MIGUEL', 'SAN MIGUEL');
INSERT INTO `localidades` VALUES(NULL, 'SAN RAFAEL PIÑA', 'SAN RAFAEL PIÑA');
INSERT INTO `localidades` VALUES(NULL, 'SAN VICENTE', 'SAN VICENTE');
INSERT INTO `localidades` VALUES(NULL, 'TENANZINTLA', 'TENANZINTLA');
INSERT INTO `localidades` VALUES(NULL, 'ZAPOTAL', 'ZAPOTAL');
INSERT INTO `localidades` VALUES(NULL, 'ZENTLA', 'ZENTLA');
INSERT INTO `localidades` VALUES(NULL, 'ZOCAPA DEL ROSARIO', 'ZOCAPA DEL ROSARIO');

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`solicitudes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`solicitudes` (
  `id_solicitud` INT NOT NULL AUTO_INCREMENT,
  `folio_seguimiento` VARCHAR(50) NOT NULL,
  `tipo_solicitud` TINYINT(1) NOT NULL,
  `id_ciudadano` INT NOT NULL,
  `id_comite_solicitante` INT NOT NULL,
  `descripcion_solicitud` VARCHAR(1000) NOT NULL,
  `id_estado_solicitud` INT NOT NULL,
  `fecha_registro` DATETIME NOT NULL,
  `id_tipo_apoyo` INT NOT NULL,
  `id_departamento_asignado` INT NOT NULL,
  `beneficiarios` INT NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_solicitud`),
  INDEX `id_estado_solicitud` (`id_estado_solicitud` ASC) VISIBLE,
  INDEX `id_areas_asignada_idx` (`id_departamento_asignado` ASC) VISIBLE,
  INDEX `id_tipo_apoyo_idx` (`id_tipo_apoyo` ASC) VISIBLE,
  CONSTRAINT `id_areas_asignada`
    FOREIGN KEY (`id_departamento_asignado`)
    REFERENCES `bd_ac`.`departamentos` (`id_departamento`),
  CONSTRAINT `id_tipo_apoyo`
    FOREIGN KEY (`id_tipo_apoyo`)
    REFERENCES `bd_ac`.`tipos_apoyo` (`id_tipo_apoyo`),
  CONSTRAINT `solicitudes_ibfk_3`
    FOREIGN KEY (`id_estado_solicitud`)
    REFERENCES `bd_ac`.`estados` (`id_estado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

--
-- Volcado de datos para la tabla `solicitudes`
--


-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`tipos_apoyo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`tipos_apoyo` (
  `id_tipo_apoyo` INT NOT NULL AUTO_INCREMENT,
  `nombre_apoyo` VARCHAR(50) NOT NULL,
  `id_departamento` INT NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_tipo_apoyo`),
  INDEX `id_departamento_idx` (`id_departamento` ASC) VISIBLE,
  CONSTRAINT `id_departamento`
    FOREIGN KEY (`id_departamento`)
    REFERENCES `bd_ac`.`departamentos` (`id_departamento`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

--
-- Volcado de datos para la tabla `tipos_apoyo`
--

-- Apoyos de Presidencia:(id = 1)
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo economico', 1, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo a fiestas patronales', 1, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo a eventos escolares', 1, 0);
-- Apoyos de DIF:(id = 2)
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la compra de tinacos financiados', 2, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo de medicamentos', 2, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para traslados', 2, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo de entrega desayunos escolares', 2, 0);
-- Apoyos de Fomento Agropecuario:(id = 3)
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la compra de herramienta', 3, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la construccion de ollas para agua', 3, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la compra de fertilizante', 3, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la compra de semilla de maiz', 3, 0);
-- Apoyos de Obras Públicas:(id = 4)
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para construccion de viviendas', 4, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para construccion de baños', 4, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para construccion de aulas escolares', 4, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la red de alumbrado', 4, 0);


-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`tipos_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`tipos_usuario` (
  `id_tipo_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

--
-- Volcado de datos para la tabla `tipos_usuario`
--

INSERT INTO `tipos_usuario` VALUES(NULL, 'Administrador');
INSERT INTO `tipos_usuario` VALUES(NULL, 'Usuario departamento');

-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `bd_ac`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_ac`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(15) NOT NULL,
  `contraseña` VARCHAR(256) NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido_paterno` VARCHAR(20) NOT NULL,
  `apellido_materno` VARCHAR(20) NOT NULL,
  `id_departamento` INT NOT NULL,
  `tipo_usuario` INT NOT NULL,
  `enabled` TINYINT(1) NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  INDEX `id_area_idx` (`id_departamento` ASC) VISIBLE,
  INDEX `id_tipo_usuario_idx` (`tipo_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_departamento`
    FOREIGN KEY (`id_departamento`)
    REFERENCES `bd_ac`.`departamentos` (`id_departamento`),
  CONSTRAINT `fk_tipo_usuario`
    FOREIGN KEY (`tipo_usuario`)
    REFERENCES `bd_ac`.`tipos_usuario` (`id_tipo_usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` VALUES(NULL, 'admin', '63e24fa9907ca349f0557b5d10b2bb82b4c6a4e9bc957a667576baffd8651d8203843e4304a2fe570293e52712f429b7d8cdbf8a3357014ac33502899b42932e', 'Enrique', 'Fadanelli', 'Toss', 1, 1, 1, 0);
INSERT INTO `usuarios` VALUES(NULL, 'maria', '63e24fa9907ca349f0557b5d10b2bb82b4c6a4e9bc957a667576baffd8651d8203843e4304a2fe570293e52712f429b7d8cdbf8a3357014ac33502899b42932e', 'Maria', 'Sandoval', 'Roman', 2, 2, 1, 0);
INSERT INTO `usuarios` VALUES(NULL, 'berna', '63e24fa9907ca349f0557b5d10b2bb82b4c6a4e9bc957a667576baffd8651d8203843e4304a2fe570293e52712f429b7d8cdbf8a3357014ac33502899b42932e', 'Bernardino', 'Acosta', 'Quiroz', 3, 2, 1, 0);

-- --------------------------------------------------------

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
