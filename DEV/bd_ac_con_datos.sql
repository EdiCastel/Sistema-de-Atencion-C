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

INSERT INTO `ciudadanos` VALUES(NULL, 'WILLIAM EFRAIN', 'ABELLA', 'HERRERA', 'HOMBRE', '76307332AHEHRDTY', 4561, 50, 'DOMICILIO CONOCIDO POTRERO ZENTLA. VER.', 'JUNTO A AL ARBOL VERDE', 2731590188, 0);

INSERT INTO `ciudadanos` VALUES(NULL, 'MARIA', 'ACOSTA', 'ARAGON', 'MUJER', '98756431MADTYERT', 4569, 6, 'Av. Reforma s/n esquina Juan de la Luz Enríquez, Colonia Manuel González, Zentla, Ver.', 'A media cuadra del palacio municipal', 2731123456, 0);

INSERT INTO `ciudadanos` VALUES(NULL, 'LUCIA', 'AGREDO', 'TOVAR', 'MUJER', 'AGTL000001MVZABC', 4562, 10, 'CALLE BENITO JUREZ', 'JUNTO A LA TIENDA', 2731234567, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'JOSE', 'ACOSTA', 'FAUSTO', 'HOMBRE', 'ACFJ000002HVZBCD', 4563, 15, 'CALLE MANUEL I. ALTAMIRANO', 'POR EL PARQUE', 2731345678, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'GUILLERMO', 'AGREDO', 'TORRES', 'HOMBRE', 'AGTG000003HVZCDE', 4564, 22, 'CALLE CONSTITUCION', 'JUNTO A LA IGLESIA.', 2731456789, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'CARLOS', 'AGUIRRE', 'GARCIA', 'HOMBRE', 'AGGC000003HVZABF', 4565, 30, 'CALLE GUADALUPE VICTORIA', 'JUNTO AL CERRO.', 2731567890, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'NOE', 'ALVAN', 'LOPEZ', 'HOMBRE', 'ALLN000004HVZHJK', 4566, 50, ' CALLE VICENTE GUERRERO', 'JUNTO AL POSTE DE LUZ.', 2731678901, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ELENA', 'AGUDELO', 'LOPEZ', 'MUJER', 'AGLE000005MVZGHY', 4567, 50, 'CALLE ANASTASIO BUSTAMANTE', 'JUNTO A LA PANADERIA.', 2731789012, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'DIEGO', 'ALEGRIA', 'FERNANDEZ', 'HOMBRE', 'ALFD000006HVZLOV', 4568, 40, 'CALLE MANUEL GOMEZ PEDRAZA', 'A MEDIA CUADRA DEL PALACIO', 2731890123, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ALBERTO', 'ALEGRIA', 'VELAZQUEZ', 'HOMBRE', 'ALVA000007HVZXOP', 4561, 50, 'CALLE VALENTIN GOMEZ FARIAS', 'JUNTO A LA CASA VERDE', 2731901234, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'EVELIO', 'ALVAREZ', 'JARAMILLO', 'HOMBRE', 'ALJE000008HVZJAF', 4562, 20, 'CALLE ANTONIO LOPEZ DE SANTA ANNA', 'JUNTO A EL ARBOL DE MANGO', 2731012345, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'CECILIA', 'ALVAREZ', 'VEJARANO', 'MUJER', 'ALXC000009MVZWQL', 4563, 32, 'CALLE MIGUEL BARRAGAN', 'JUNTO A LA CASA AZUL', 2731123456, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'LUIS', 'ALDEAR', 'ORTEGA', 'HOMBRE', 'ALOL000010HVZXZO', 4564, 45, 'CALLE NICOLAS BRAVO', 'POR LA TIENDA DE ABARROTES', 2732123456, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'LUZ', 'ALZATE', 'CAMAYO', 'MUJER', 'ALCL000011MVZPKJ', 4565, 11, 'CALLE JOSE JUSTO CORRO', 'POR LA CARNICERIA', 2732234567, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ALFONSO', 'ANAYA', 'CABRERA', 'HOMBRE', 'ANCX000012HVZDFR', 4566, 45, 'CALLE FRANCISCO JAVIER ECHEVERRIA', 'JUNTO AL BILLAR.', 2732345678, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ALBERTO ', 'ANAYA', 'HIDALGO', 'HOMBRE', 'ANHA000013HVZERT', 4567, 33, 'CALLENICOLAS BRAVO RUEDA', 'JUNTO A LA CERCA', 2732456789, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'AMPARO', 'ANDRADE', 'VALENCIA', 'MUJER', 'ANVA000014MVZCRZ', 4568, 46, 'CALLE VALENTIN CANALIZO', 'JUNTO AL POTRERO.', 2732567890, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ESPERANZA', 'REYNOSO', 'ANDRADE', 'MUJER', 'REAE000015MVZJKL', 4569, 28, 'CALLE JOSE MARIANO SALAS', 'JUNTO AL POLLERIA.', 2732678901, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'CAMILO', 'ANDRADE', 'SOSA', 'HOMBRE', 'ANSC000016HVZYVX', 4561, 18, 'CALLE PEDRO MARIA ANAYA', 'JUNTO A LA FARMACIA.', 2732789012, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'PIEDAD', 'ARANGO', 'GAVIRIA', 'MUJER', 'ARGP000017MVZHVQ', 4562, 51, 'CALLE JUAN BAUTISTA CEBALLOS', 'JUNTO A LA CASA DE SALUD', 2732890123, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'MILTON', 'ARANGO', 'QUINTANA', 'HOMBRE', 'ARQM000018HVZHVQ', 4563, 11, 'CALLE MARIANO ARISTA', 'JUNTO A LA CASA DEL MAESTRO.', 2732901234, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ANDRES', 'ARCOS', 'ARCOS', 'HOMBRE', 'ARAA000019HVZHGF', 4564, 12, 'CALLE MANUEL MARIA LOMBARDINI', 'A UNA CUADRA DE LA ESCUELA.', 2730123456, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ELENA', 'ARCOS', 'DE CHILITO', 'MUJER', 'ARDX000020MVZUTY', 4565, 34, 'CALLE IGNACIO COMONFORT', 'POR LA TELESECUNDARIA.', 2733123456, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'YOLANDA', 'ARCOS', 'LEGARDO', 'MUJER', 'ARLY000021MVZTBF', 4566, 41, 'CALLE MIGUEL MIRAMON', 'JUNTO AL TEBA.', 2733234567, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'MARGOTH', 'ARISTIZABAL', 'MAGNOLIA', 'MUJER', 'ARMM000022MVZVGA', 4567, 28, 'CALLE MAXIMILIANO DE HABSBURGO', 'POR EL KINDER.', 27333234567, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'EDGAR', 'ASTUDILLO', 'MOSQUEDA', 'HOMBRE', 'ASMX000023HVZHBO', 4568, 39, 'CALLE SEBASTIAN LERDO DE TEJADA', 'POR LA CLINICA.', 2733456789, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ALDEMAR ', 'ASTUDILLO', 'PEREZ', 'HOMBRE', 'ASPA000024HVZQWE', 4569, 47, 'CALLE JOSE MARIA IGLESIAS', 'PASANDO EL CRUCERO.', 2733567890, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'INES', 'AVILA', 'GONZALEZ', 'MUJER', 'AVGI000025MVZXRTY', 4561, 8, 'CALLE JUAN NEPOMUCENO MENDEZ', 'CASA ROSADA.', 27336789012, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'HENRY', 'VASTIDAS', 'ESCOBAR', 'HOMBRE', 'VAEH000026HVZHBA', 4562, 2, 'CALLE PORFIRIO DIAZ', 'CASA MORADA.', 2733789012, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'TORIBIO', 'BELTRAN', 'VIDAL', 'HOMBRE', 'BEVT000027HVZGHJ', 4563, 16, 'CALLE MANUEL GONZALEZ FLORES', 'A DOS CUADRAS DE LA IGLESIA.', 2733890123, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ORLANDO', 'BENAVIDES', 'VELASCO', 'HOMBRE', 'BEVO000028HVZZXC', 4564, 5, 'CALLE FRANCISCO I. MADERO', 'JUNTO A LA LLAVE DE AGUA', 27339012345, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ELIZABEHT', 'BENITEZ', 'ALEGRIA', 'MUJER', 'BEAE000029MVZXCV', 4565, 7, 'CALLE PEDRO LASCURAIN PAREDES', 'A PIE DE LA CARRETERA.', 2733012345, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'OSCAR', 'BERMUDES', 'ANDRADE', 'HOMBRE', 'BEAO000030HVZCVB', 4566, 9, 'CALLE VICTORIANO HUERTA ORTEGA', 'CASA AZUL.', 2733345678, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'JOSEFINA', 'BONILLA', 'MUÑOZ', 'MUJER', 'BOMJ000031MVZVBN', 4567, 15, 'CALLE FRANCISCO S. CARBAJAL', 'CERCA DEL RIO.', 2731301115, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'JESUS', 'BRAVO', 'TERAN', 'HOMBRE', 'BRTJ000032HVZBNM', 4568, 14, 'CALLE VENUSTIANO CARRANZA', 'LLEGANDO A LA CARRETERA.', 2731266962, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'ALEXANDER', 'BUENDIA', 'ASTUDILLO', 'HOMBRE', 'BUAA000330HVZASD',4569, 13, 'CALLE ALVARO OBREGON', 'CASA DE BLOCK.', 2731255106, 0);
INSERT INTO `ciudadanos` VALUES(NULL, 'MARIA', 'ROBLES', 'ANDRADE', 'MUJER', 'ROAM000034HVZSDF', 4561, 7, 'CALLE LAZARO CARDENAS DEL RIO', 'CASA DE DOS PISOS.', 2731020818, 0);

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

--
-- Volcado de datos para la tabla `comites`
--

INSERT INTO `comites` VALUES(NULL, 'Comite de Zentla', 'Comité encargado de la iglesia de Zentla', 50, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de la primaria de Maromilla', 'Comité de padres de familia de la localidad de maromilla', 30, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de Paso del cedro', 'Comité de ciudadanos de Paso del cedro', 34, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de Dos luceros', 'Comité de ciudadanos de Dos luceros', 12, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité del kínder de Matlaluca', 'Comité de padres de familia del kínder de la localidad de Matlaluca', 33, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de primaria de Rincón mariano', 'Comité de padres de familia de la primaria de la localidad de Rincón mariano', 41, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de ciudadanos de El consuelo', 'Comité de ciudadanos de la localidad de El consuelo', 16, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de Mata coyote', 'Comité de ciudadanos de la localidad de Mata coyote', 31, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de iglesia de Ejido la piña', 'Comité organizador de la fiesta patronal de la iglesia de la localidad de Ejido la piña', 13, 0);
INSERT INTO `comites` VALUES(NULL, 'Comité de El cazon', 'Comité de ciudadanos de la localidad de El cazon', 15, 0);

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
INSERT INTO `departamentos` VALUES(NULL, 'Presidencia', 'Rafael Lopez Hernandez', 0);
INSERT INTO `departamentos` VALUES(NULL, 'DIF', 'Anahít López Hernández', 0);
INSERT INTO `departamentos` VALUES(NULL, 'Fomento Agropecuario', 'Armando Marini Garcia', 0);
INSERT INTO `departamentos` VALUES(NULL, 'Obras Públicas', 'Bernardino Acosta Quiroz', 0);
INSERT INTO `departamentos` VALUES(NULL, 'Informática', 'Enrique Fadanelli Toss', 0);

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

INSERT INTO `historial_estados` (`id_historial_estado`, `id_solicitud`, `fecha`, `id_estado_solicitud`) VALUES (NULL, '1', now(), '1');
INSERT INTO `historial_estados` (`id_historial_estado`, `id_solicitud`, `fecha`, `id_estado_solicitud`) VALUES (NULL, '2', now(), '1');
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

INSERT INTO `integrantes_comites` VALUES(NULL, 37, 1);
INSERT INTO `integrantes_comites` VALUES(NULL, 1, 1);
INSERT INTO `integrantes_comites` VALUES(NULL, 3, 2);
INSERT INTO `integrantes_comites` VALUES(NULL, 4, 2);
INSERT INTO `integrantes_comites` VALUES(NULL, 5, 2);
INSERT INTO `integrantes_comites` VALUES(NULL, 6, 3);
INSERT INTO `integrantes_comites` VALUES(NULL, 7, 3);
INSERT INTO `integrantes_comites` VALUES(NULL, 8, 3);
INSERT INTO `integrantes_comites` VALUES(NULL, 9, 4);
INSERT INTO `integrantes_comites` VALUES(NULL, 10, 4);
INSERT INTO `integrantes_comites` VALUES(NULL, 11, 4);
INSERT INTO `integrantes_comites` VALUES(NULL, 12, 5);
INSERT INTO `integrantes_comites` VALUES(NULL, 13, 5);
INSERT INTO `integrantes_comites` VALUES(NULL, 14, 5);
INSERT INTO `integrantes_comites` VALUES(NULL, 15, 6);
INSERT INTO `integrantes_comites` VALUES(NULL, 16, 6);
INSERT INTO `integrantes_comites` VALUES(NULL, 17, 6);
INSERT INTO `integrantes_comites` VALUES(NULL, 18, 7);
INSERT INTO `integrantes_comites` VALUES(NULL, 19, 7);
INSERT INTO `integrantes_comites` VALUES(NULL, 20, 7);
INSERT INTO `integrantes_comites` VALUES(NULL, 21, 8);
INSERT INTO `integrantes_comites` VALUES(NULL, 22, 8);
INSERT INTO `integrantes_comites` VALUES(NULL, 23, 8);
INSERT INTO `integrantes_comites` VALUES(NULL, 24, 9);
INSERT INTO `integrantes_comites` VALUES(NULL, 25, 9);
INSERT INTO `integrantes_comites` VALUES(NULL, 26, 9);
INSERT INTO `integrantes_comites` VALUES(NULL, 27, 10);
INSERT INTO `integrantes_comites` VALUES(NULL, 28, 10);
INSERT INTO `integrantes_comites` VALUES(NULL, 29, 10);

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

INSERT INTO `solicitudes` VALUES(NULL, '20240001', 0, 37, 0, 'Tinaco de 1100lts', 1, '2024-01-01 19:12:15', 1, 2, 4, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240002', 1, 0, 1, 'Apoyo para la realización de la fiesta patronal de Zentla', 1, '2024-01-15 19:12:15', 2, 1, 5, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240003', 0, 3, 0, 'compra de un kit de herramientas', 4, '2024-02-21 19:23:49', 9, 3, 1, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240004', 0, 4, 0, 'petición de una vivienda ', 5, '2024-02-28 19:25:23', 13, 4, 5, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240005', 0, 5, 0, 'Petición de apoyo económico para tratamientos médicos', 2, '2024-03-07 19:27:28', 1, 1, 1, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240006', 0, 7, 0, 'Apoyo para la compra de medicamentos', 8, '2024-03-12 19:28:38', 5, 2, 4, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240007', 0, 8, 0, 'Apoyo de horas maquina para la construcción de un jaguey', 9, '2024-04-05 19:32:49', 10, 3, 7, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240008', 0, 9, 0, 'Petición para la construcción de un baño', 4, '2024-04-24 19:35:14', 14, 4, 6, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240009', 0, 10, 0, 'Apoyo económico para la compra de una despensa', 3, '2024-05-11 19:40:21', 1, 1, 2, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240010', 0, 11, 0, 'Apoyo para el traslado de un paciente al hospital de Orizaba', 2, '2024-05-17 19:42:08', 6, 2, 2, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240011', 0, 12, 0, 'Apoyo para la compra de 6 bultos de fertilizante', 5, '2024-05-19 19:43:46', 11, 3, 1, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240012', 1, 0, 2, 'Apoyo para la entrega de desayunos para la escuela de Maromilla', 1, '2024-06-02 19:50:00', 7, 2, 32, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240013', 1, 0, 3, 'Apoyo de horas maquina para la rehabilitación de camino en la comunidad de Paso del cedro', 8, '2024-06-09 19:56:55', 10, 3, 45, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240014', 1, 0, 4, 'Apoyo para electrificación del barrio San José de la localidad de Dos luceros', 2, '2024-07-05 20:01:25', 16, 4, 23, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240015', 1, 0, 5, 'Petición de pintura para el kínder de la localidad de Matlaluca', 4, '2024-07-08 20:04:47', 3, 1, 23, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240016', 1, 0, 6, 'Apoyo para entrega de desayunos para la escuela primaria de Rincón Mariano', 5, '2024-07-11 20:08:36', 7, 2, 43, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240017', 1, 0, 7, 'Apoyo para la compra de semilla de maíz para los ciudadanos de la localidad de El consuelo', 7, '2024-07-20 20:12:19', 12, 3, 45, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240018', 1, 0, 8, 'Apoyo para la pavimentación de camino de la localidad de Mata coyote', 7, '2024-08-19 20:15:18', 15, 4, 150, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240019', 1, 0, 9, 'Apoyo para la fiesta patronal de la localidad de Ejido la piña', 8, '2024-08-25 20:18:30', 2, 1, 100, 0);

INSERT INTO `solicitudes` VALUES(NULL, '20240020', 1, 0, 10, 'Apoyo para la pavimentación de tramo carretero de la localidad de El cazon', 3, '2024-08-28 20:23:21', 15, 2, 54, 0);
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
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo de gastos funerarios', 2, 0);
-- Apoyos de Fomento Agropecuario:(id = 3)
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la compra de kits de herramientas', 3, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo de horas maquina', 3, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la compra de fertilizantes', 3, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para la compra de semilla de maiz', 3, 0);
-- Apoyos de Obras Públicas:(id = 4)
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para construccion de viviendas', 4, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo para construccion de baños', 4, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo de pavimentacion', 4, 0);
INSERT INTO `tipos_apoyo` VALUES(NULL, 'Apoyo de eletrificaciones', 4, 0);


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
INSERT INTO `usuarios` VALUES(NULL, 'maria', '63e24fa9907ca349f0557b5d10b2bb82b4c6a4e9bc957a667576baffd8651d8203843e4304a2fe570293e52712f429b7d8cdbf8a3357014ac33502899b42932e', 'Maria', 'Sandoval', 'Rosas', 2, 2, 1, 0);
INSERT INTO `usuarios` VALUES(NULL, 'berna', '63e24fa9907ca349f0557b5d10b2bb82b4c6a4e9bc957a667576baffd8651d8203843e4304a2fe570293e52712f429b7d8cdbf8a3357014ac33502899b42932e', 'Bernardino', 'Acosta', 'Quiroz', 3, 2, 1, 0);

-- --------------------------------------------------------

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
