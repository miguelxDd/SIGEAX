-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.28-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para siax
DROP DATABASE IF EXISTS `siax`;
CREATE DATABASE IF NOT EXISTS `siax` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `siax`;

-- Volcando estructura para tabla siax.categoria_producto
DROP TABLE IF EXISTS `categoria_producto`;
CREATE TABLE IF NOT EXISTS `categoria_producto` (
  `categoriaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`categoriaID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.categoria_producto: ~13 rows (aproximadamente)
DELETE FROM `categoria_producto`;
INSERT INTO `categoria_producto` (`categoriaID`, `nombre_categoria`) VALUES
	(1, 'Calzado de niño'),
	(2, 'Calzado de adulto'),
	(3, 'Calzado general'),
	(4, 'Sábanas, sobrefundas, edredones y frazadas'),
	(5, 'Cokines y almohadas'),
	(6, 'Cortinas, manteles e individuales'),
	(7, 'Alfombras y organizadores'),
	(8, 'Joyería y bisuteria'),
	(9, 'Ropa de adulto'),
	(10, 'Ropa de niño'),
	(11, 'Ropa interior adulto y niño'),
	(12, 'Ropa interior adulto');

-- Volcando estructura para tabla siax.cliente
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `clienteID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_cliente` char(60) NOT NULL,
  `direccion_cliente` char(60) DEFAULT NULL,
  `departamentoID` int(11) DEFAULT NULL,
  `municipioID` int(11) DEFAULT NULL,
  `telefono_cliente` char(11) DEFAULT NULL,
  `tipo_documento_cliente` char(10) DEFAULT NULL,
  `num_documento_cliente` char(12) DEFAULT NULL,
  `es_vendedor` int(11) DEFAULT NULL,
  PRIMARY KEY (`clienteID`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.cliente: ~2 rows (aproximadamente)
DELETE FROM `cliente`;
INSERT INTO `cliente` (`clienteID`, `nombre_cliente`, `direccion_cliente`, `departamentoID`, `municipioID`, `telefono_cliente`, `tipo_documento_cliente`, `num_documento_cliente`, `es_vendedor`) VALUES
	(1, 'Juan Gabriel', 'calle cerca de ti 2', 5, 81, '12345678', 'dui', '123456788', 0),
	(2, 'Armando Paredes', 'col la pared', 6, 106, '87654321', 'dui', '98765432-1', 1);

-- Volcando estructura para tabla siax.cuentas
DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE IF NOT EXISTS `cuentas` (
  `cuentaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clienteID` int(10) unsigned NOT NULL,
  `metodo_pagoID` int(10) unsigned NOT NULL,
  `institucion` char(255) DEFAULT NULL,
  `numero_telefono` char(11) DEFAULT NULL,
  `numero_cuenta` char(20) DEFAULT NULL,
  `dui` char(12) DEFAULT NULL,
  `titular` char(60) DEFAULT NULL,
  `estado` char(20) DEFAULT NULL,
  PRIMARY KEY (`cuentaID`),
  KEY `FK_Relationship_14` (`clienteID`),
  KEY `FK_Relationship_25` (`metodo_pagoID`),
  CONSTRAINT `FK_Relationship_14` FOREIGN KEY (`clienteID`) REFERENCES `cliente` (`clienteID`),
  CONSTRAINT `FK_Relationship_25` FOREIGN KEY (`metodo_pagoID`) REFERENCES `metodo_pagos` (`metodo_pagoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.cuentas: ~0 rows (aproximadamente)
DELETE FROM `cuentas`;

-- Volcando estructura para tabla siax.departamento
DROP TABLE IF EXISTS `departamento`;
CREATE TABLE IF NOT EXISTS `departamento` (
  `departamentoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_departamento` char(30) NOT NULL,
  PRIMARY KEY (`departamentoID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.departamento: ~14 rows (aproximadamente)
DELETE FROM `departamento`;
INSERT INTO `departamento` (`departamentoID`, `nombre_departamento`) VALUES
	(1, 'Ahuachapán'),
	(2, 'Sonsonate'),
	(3, 'Santa Ana'),
	(4, 'La Libertad'),
	(5, 'Chalatenango'),
	(6, 'San Salvador'),
	(7, 'Cuscatlán'),
	(8, 'La Paz'),
	(9, 'San Vicente'),
	(10, 'Cabañas'),
	(11, 'Usulután'),
	(12, 'San Miguel'),
	(13, 'Morazán'),
	(14, 'La Unión');

-- Volcando estructura para tabla siax.destino
DROP TABLE IF EXISTS `destino`;
CREATE TABLE IF NOT EXISTS `destino` (
  `destinoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `departamentoID` int(10) unsigned NOT NULL,
  `municipioID` int(10) unsigned NOT NULL,
  `rutaID` int(10) unsigned DEFAULT NULL,
  `lugar_destino` char(255) DEFAULT NULL,
  `descripcion_destino` varchar(255) DEFAULT NULL,
  `hora_desde` time DEFAULT NULL,
  `hora_hasta` time DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`destinoID`),
  KEY `FK_Relationship_11` (`rutaID`),
  KEY `FK_Relationship_18` (`departamentoID`),
  KEY `FK_destino_municipio` (`municipioID`),
  CONSTRAINT `FK_Relationship_11` FOREIGN KEY (`rutaID`) REFERENCES `ruta` (`rutaID`),
  CONSTRAINT `FK_Relationship_18` FOREIGN KEY (`departamentoID`) REFERENCES `departamento` (`departamentoID`),
  CONSTRAINT `FK_destino_municipio` FOREIGN KEY (`municipioID`) REFERENCES `municipio` (`municipioID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.destino: ~21 rows (aproximadamente)
DELETE FROM `destino`;
INSERT INTO `destino` (`destinoID`, `departamentoID`, `municipioID`, `rutaID`, `lugar_destino`, `descripcion_destino`, `hora_desde`, `hora_hasta`, `estado`) VALUES
	(1, 6, 97, 1, 'Metrogalerías', 'Local 3-12', '09:00:00', '12:15:00', 1),
	(27, 4, 46, 1, 'Metrocentro Lourdes', 'Afuera, por Papa John\'s', '14:10:00', '14:40:00', 1),
	(28, 4, 46, 1, 'Encuentro Lourdes', 'Afuera, por Banco Promérica', '14:55:00', '15:15:00', 1),
	(29, 4, 54, 1, 'Ciudad Versailles', 'Gasolinera Uno', '15:35:00', '15:55:00', 1),
	(30, 4, 54, 1, 'Ciudad Marsella', 'Por la pasarela', '16:05:00', '16:25:00', 1),
	(31, 4, 53, 1, 'Quezaltepeque', 'Parque Central, por LeCafe', '16:45:00', '17:15:00', 1),
	(32, 2, 28, 2, 'Sonzacate', 'Parque, frende a la iglesia', '09:00:00', '09:30:00', 1),
	(33, 2, 27, 2, 'Sonsonate Centro', 'Parque, frente a Catedral', '10:00:00', '10:30:00', 1),
	(34, 2, 27, 2, 'Metrocentro Sonsonate', 'Afuera, por Pizza Hut', '11:00:00', '11:30:00', 1),
	(35, 2, 27, 2, 'Sonsonate Terminal nueva', 'Por el Pollo Campero por los taxis, en la acera', '12:00:00', '12:30:00', 1),
	(36, 2, 17, 2, 'Izalco', 'Por la alcaldía', '13:00:00', '13:30:00', 1),
	(37, 2, 145, 2, 'Caluco', 'Parque, frente a la Iglesia', '14:00:00', '14:30:00', 1),
	(38, 2, 23, 2, 'San Julián', 'Parque Central', '15:00:00', '15:30:00', 1),
	(39, 2, 14, 2, 'Armenia', 'Parque, frente a la Iglesia', '16:00:00', '16:30:00', 0),
	(40, 6, 97, 3, 'Metrogalerías', 'Local 3-12', '09:00:00', '12:15:00', 0),
	(41, 4, 46, 3, 'Metrocentro Lourdes', 'Afuera, por Papa John\'s', '14:10:00', '14:40:00', 0),
	(42, 4, 46, 3, 'Encuentro Lourdes', 'Afuera, por Banco Promérica', '14:55:00', '15:15:00', 0),
	(43, 4, 54, 3, 'Ciudad Versailles', 'Gasolinera Uno', '15:35:00', '15:55:00', 0),
	(44, 4, 54, 3, 'Ciudad Marsella', 'Por la pasarela', '16:05:00', '16:25:00', 0),
	(45, 4, 53, 3, 'Quezaltepeque2', 'Parque Central, por LeCafe2', '16:45:00', '17:16:00', 1);

-- Volcando estructura para tabla siax.empleado
DROP TABLE IF EXISTS `empleado`;
CREATE TABLE IF NOT EXISTS `empleado` (
  `empleadoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `negocioID` int(10) unsigned NOT NULL DEFAULT 1,
  `nombre_empleado` char(60) NOT NULL,
  `telefono_empleado` char(11) DEFAULT NULL,
  `direccion_empleado` char(60) DEFAULT NULL,
  `tipo_documento_empleado` char(10) NOT NULL,
  `num_documento_empleado` char(12) NOT NULL,
  PRIMARY KEY (`empleadoID`),
  KEY `FK_Relationship_6` (`negocioID`),
  CONSTRAINT `FK_Relationship_6` FOREIGN KEY (`negocioID`) REFERENCES `negocio` (`negocioID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.empleado: ~4 rows (aproximadamente)
DELETE FROM `empleado`;
INSERT INTO `empleado` (`empleadoID`, `negocioID`, `nombre_empleado`, `telefono_empleado`, `direccion_empleado`, `tipo_documento_empleado`, `num_documento_empleado`) VALUES
	(1, 1, 'EmpleadoDE nEGOCIO', '12235689', 'CASA de empleado', 'dui', '45568956'),
	(3, 1, 'María Rodríguez', '78564239', 'Avenida Central', 'nit', '76891234-5'),
	(4, 1, 'Pedro Hernández', '64527891', 'Casa de la Esquina', 'dui', '34561234-9');

-- Volcando estructura para tabla siax.historial_destinos
DROP TABLE IF EXISTS `historial_destinos`;
CREATE TABLE IF NOT EXISTS `historial_destinos` (
  `historialID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rutaID` int(11) unsigned NOT NULL DEFAULT 0,
  `destinoID` int(11) unsigned NOT NULL DEFAULT 0,
  `fecha` date NOT NULL DEFAULT curdate(),
  `total_paquetes` int(11) NOT NULL DEFAULT 0,
  `paquetes_entregados` int(11) NOT NULL DEFAULT 0,
  `finalizada` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`historialID`),
  KEY `FK_historial_destinos_ruta` (`rutaID`),
  KEY `FK_historial_destinos_destino` (`destinoID`),
  CONSTRAINT `FK_historial_destinos_destino` FOREIGN KEY (`destinoID`) REFERENCES `destino` (`destinoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_historial_destinos_ruta` FOREIGN KEY (`rutaID`) REFERENCES `ruta` (`rutaID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.historial_destinos: ~5 rows (aproximadamente)
DELETE FROM `historial_destinos`;
INSERT INTO `historial_destinos` (`historialID`, `rutaID`, `destinoID`, `fecha`, `total_paquetes`, `paquetes_entregados`, `finalizada`) VALUES
	(1, 2, 32, '2023-10-12', 0, 0, 1),
	(2, 1, 1, '2023-10-18', 0, 0, 0),
	(3, 1, 27, '2023-10-18', 0, 0, 0),
	(4, 1, 28, '2023-10-18', 0, 0, 0),
	(5, 3, 45, '2023-10-14', 0, 0, 0),
	(6, 3, 41, '2023-10-14', 0, 0, 1);

-- Volcando estructura para tabla siax.metodo_pagos
DROP TABLE IF EXISTS `metodo_pagos`;
CREATE TABLE IF NOT EXISTS `metodo_pagos` (
  `metodo_pagoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estado` char(20) DEFAULT NULL,
  `tipo_pago` char(20) NOT NULL,
  PRIMARY KEY (`metodo_pagoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.metodo_pagos: ~0 rows (aproximadamente)
DELETE FROM `metodo_pagos`;

-- Volcando estructura para tabla siax.municipio
DROP TABLE IF EXISTS `municipio`;
CREATE TABLE IF NOT EXISTS `municipio` (
  `municipioID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `departamentoID` int(10) unsigned NOT NULL,
  `nombre_municipio` char(40) NOT NULL,
  PRIMARY KEY (`municipioID`),
  KEY `FK_Relationship_19` (`departamentoID`),
  CONSTRAINT `FK_Relationship_19` FOREIGN KEY (`departamentoID`) REFERENCES `departamento` (`departamentoID`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.municipio: ~262 rows (aproximadamente)
DELETE FROM `municipio`;
INSERT INTO `municipio` (`municipioID`, `departamentoID`, `nombre_municipio`) VALUES
	(1, 1, 'Ahuachapán'),
	(2, 1, 'Apaneca'),
	(3, 1, 'Atiquizaya'),
	(4, 1, 'Concepción de Ataco'),
	(5, 1, 'El Refugio'),
	(6, 1, 'Guaymango'),
	(7, 1, 'Jujutla'),
	(8, 1, 'San Francisco Menéndez'),
	(9, 1, 'San Lorenzo'),
	(10, 1, 'San Pedro Puxtla'),
	(11, 1, 'Tacuba'),
	(12, 1, 'Turín'),
	(13, 2, 'Acajutla'),
	(14, 2, 'Armenia'),
	(15, 2, 'Caluco'),
	(16, 2, 'Cuisnahuat'),
	(17, 2, 'Izalco'),
	(18, 2, 'Juayúa'),
	(19, 2, 'Nahuizalco'),
	(20, 2, 'Nahulingo'),
	(21, 2, 'Salcoatitán'),
	(22, 2, 'San Antonio del Monte'),
	(23, 2, 'San Julián'),
	(24, 2, 'Santa Catarina Masahuat'),
	(25, 2, 'Santa Isabel Ishuatán'),
	(26, 2, 'Santo Domingo de Guzmán'),
	(27, 2, 'Sonsonate'),
	(28, 2, 'Sonzacate'),
	(29, 3, 'Santa Ana'),
	(30, 3, 'Candelaria de la Frontera'),
	(31, 3, 'Chalchuapa'),
	(32, 3, 'Coatepeque'),
	(33, 3, 'El Congo'),
	(34, 3, 'El Porvenir'),
	(35, 3, 'Masahuat'),
	(36, 3, 'Metapán'),
	(37, 3, 'San Antonio Pajonal'),
	(38, 3, 'San Sebastián Salitrillo'),
	(39, 3, 'Santa Rosa Guachipilín'),
	(40, 3, 'Santiago de la Frontera'),
	(41, 3, 'Texistepeque'),
	(42, 4, 'Santa Tecla'),
	(43, 4, 'Antiguo Cuscatlán'),
	(44, 4, 'Chiltiupán'),
	(45, 4, 'Ciudad Arce'),
	(46, 4, 'Colón'),
	(47, 4, 'Comasagua'),
	(48, 4, 'Huizúcar'),
	(49, 4, 'Jayaque'),
	(50, 4, 'Jicalapa'),
	(51, 4, 'La Libertad'),
	(52, 4, 'Nuevo Cuscatlán'),
	(53, 4, 'Quezaltepeque'),
	(54, 4, 'San Juan Opico'),
	(55, 4, 'Sacacoyo'),
	(56, 4, 'San José Villanueva'),
	(57, 4, 'San Matías'),
	(58, 4, 'San Pablo Tacachico'),
	(59, 4, 'Talnique'),
	(60, 4, 'Tamanique'),
	(61, 4, 'Teotepeque'),
	(62, 4, 'Tepecoyo'),
	(63, 4, 'Zaragoza'),
	(64, 5, 'Chalatenango'),
	(65, 5, 'Agua Caliente'),
	(66, 5, 'Arcatao'),
	(67, 5, 'Azacualpa'),
	(68, 5, 'Cancasque'),
	(69, 5, 'Citalá'),
	(70, 5, 'Comalapa'),
	(71, 5, 'Concepción Quezaltepeque'),
	(72, 5, 'Dulce Nombre de María'),
	(73, 5, 'El Carrizal'),
	(74, 5, 'El Paraíso'),
	(75, 5, 'La Laguna'),
	(76, 5, 'La Palma'),
	(77, 5, 'La Reina'),
	(78, 5, 'Las Flores'),
	(79, 5, 'Las Vueltas'),
	(80, 5, 'Nombre de Jesús'),
	(81, 5, 'Nueva Concepción'),
	(82, 5, 'Nueva Trinidad'),
	(83, 5, 'Ojos de Agua'),
	(84, 5, 'Potonico'),
	(85, 5, 'San Antonio de la Cruz'),
	(86, 5, 'San Antonio Los Ranchos'),
	(87, 5, 'San Fernando'),
	(88, 5, 'San Francisco Lempa'),
	(89, 5, 'San Francisco Morazán'),
	(90, 5, 'San Ignacio'),
	(91, 5, 'San Isidro Labrador'),
	(92, 5, 'San Luis del Carmen'),
	(93, 5, 'San Miguel de Mercedes'),
	(94, 5, 'San Rafael'),
	(95, 5, 'Santa Rita'),
	(96, 5, 'Tejutla'),
	(97, 6, 'San Salvador'),
	(98, 6, 'Aguilares'),
	(99, 6, 'Apopa'),
	(100, 6, 'Ayutuxtepeque'),
	(101, 6, 'Ciudad Delgado'),
	(102, 6, 'Cuscatancingo'),
	(103, 6, 'El Paisnal'),
	(104, 6, 'Guazapa'),
	(105, 6, 'Ilopango'),
	(106, 6, 'Mejicanos'),
	(107, 6, 'Nejapa'),
	(108, 6, 'Panchimalco'),
	(109, 6, 'Rosario de Mora'),
	(110, 6, 'San Marcos'),
	(111, 6, 'San Martín'),
	(112, 6, 'Santiago Texacuangos'),
	(113, 6, 'Santo Tomás'),
	(114, 6, 'Soyapango'),
	(115, 6, 'Tonacatepeque'),
	(116, 7, 'Cojutepeque'),
	(117, 7, 'Candelaria'),
	(118, 7, 'El Carmen'),
	(119, 7, 'El Rosario'),
	(120, 7, 'Monte San Juan'),
	(121, 7, 'Oratorio de Concepción'),
	(122, 7, 'San Bartolomé Perulapía'),
	(123, 7, 'San Cristóbal'),
	(124, 7, 'San José Guayabal'),
	(125, 7, 'San Pedro Perulapán'),
	(126, 7, 'San Rafael Cedros'),
	(127, 7, 'San Ramón'),
	(128, 7, 'Santa Cruz Analquito'),
	(129, 7, 'Santa Cruz Michapa'),
	(130, 7, 'Suchitoto'),
	(131, 7, 'Tenancingo'),
	(132, 8, 'Zacatecoluca'),
	(133, 8, 'Cuyultitán'),
	(134, 8, 'El Rosario'),
	(135, 8, 'Jerusalén'),
	(136, 8, 'Mercedes La Ceiba'),
	(137, 8, 'Olocuilta'),
	(138, 8, 'Paraíso de Osorio'),
	(139, 8, 'San Antonio Masahuat'),
	(140, 8, 'San Emigdio'),
	(141, 8, 'San Francisco Chinameca'),
	(142, 8, 'San Pedro Masahuat'),
	(143, 8, 'San Juan Nonualco'),
	(144, 8, 'San Juan Talpa'),
	(145, 8, 'San Juan Tepezontes'),
	(146, 8, 'San Luis La Herradura'),
	(147, 8, 'San Luis Talpa'),
	(148, 8, 'San Miguel Tepezontes'),
	(149, 8, 'San Pedro Nonualco'),
	(150, 8, 'San Rafael Obrajuelo'),
	(151, 8, 'Santa María Ostuma'),
	(152, 8, 'Santiago Nonualco'),
	(153, 8, 'Tapalhuaca'),
	(154, 9, 'San Vicente'),
	(155, 9, 'Apastepeque'),
	(156, 9, 'Guadalupe'),
	(157, 9, 'San Cayetano Istepeque'),
	(158, 9, 'San Esteban Catarina'),
	(159, 9, 'San Ildefonso'),
	(160, 9, 'San Lorenzo'),
	(161, 9, 'San Sebastián'),
	(162, 9, 'Santa Clara'),
	(163, 9, 'Santo Domingo'),
	(164, 9, 'Tecoluca'),
	(165, 9, 'Tepetitán'),
	(166, 9, 'Verapaz'),
	(167, 10, 'Sensuntepeque'),
	(168, 10, 'Cinquera'),
	(169, 10, 'Dolores'),
	(170, 10, 'Guacotecti'),
	(171, 10, 'Ilobasco'),
	(172, 10, 'Jutiapa'),
	(173, 10, 'San Isidro'),
	(174, 10, 'Tejutepeque'),
	(175, 10, 'Victoria'),
	(176, 11, 'Usulután'),
	(177, 11, 'Alegría'),
	(178, 11, 'Berlín'),
	(179, 11, 'California'),
	(180, 11, 'Concepción Batres'),
	(181, 11, 'El Triunfo'),
	(182, 11, 'Ereguayquín'),
	(183, 11, 'Estanzuelas'),
	(184, 11, 'Jiquilisco'),
	(185, 11, 'Jucuapa'),
	(186, 11, 'Jucuarán'),
	(187, 11, 'Mercedes Umaña'),
	(188, 11, 'Nueva Granada'),
	(189, 11, 'Ozatlán'),
	(190, 11, 'Puerto El Triunfo'),
	(191, 11, 'San Agustín'),
	(192, 11, 'San Buenaventura'),
	(193, 11, 'San Dionisio'),
	(194, 11, 'San Francisco Javier'),
	(195, 11, 'Santa Elena'),
	(196, 11, 'Santa María'),
	(197, 11, 'Santiago de María'),
	(198, 11, 'Tecapán'),
	(199, 12, 'San Miguel'),
	(200, 12, 'Carolina'),
	(201, 12, 'Chapeltique'),
	(202, 12, 'Chinameca'),
	(203, 12, 'Chirilagua'),
	(204, 12, 'Ciudad Barrios'),
	(205, 12, 'Comacarán'),
	(206, 12, 'El Tránsito'),
	(207, 12, 'Lolotique'),
	(208, 12, 'Moncagua'),
	(209, 12, 'Nueva Guadalupe'),
	(210, 12, 'Nuevo Edén de San Juan'),
	(211, 12, 'Quelepa'),
	(212, 12, 'San Antonio'),
	(213, 12, 'San Gerardo'),
	(214, 12, 'San Jorge'),
	(215, 12, 'San Luis de la Reina'),
	(216, 12, 'San Rafael Oriente'),
	(217, 12, 'Sesori'),
	(218, 12, 'Uluazapa'),
	(219, 13, 'San Francisco Gotera'),
	(220, 13, 'Arambala'),
	(221, 13, 'Cacaopera'),
	(222, 13, 'Chilanga'),
	(223, 13, 'Corinto'),
	(224, 13, 'Delicias de Concepción'),
	(225, 13, 'El Divisadero'),
	(226, 13, 'El Rosario'),
	(227, 13, 'Gualococti'),
	(228, 13, 'Guatajiagua'),
	(229, 13, 'Joateca'),
	(230, 13, 'Jocoatique'),
	(231, 13, 'Jocoro'),
	(232, 13, 'Lolotiquillo'),
	(233, 13, 'Meanguera'),
	(234, 13, 'Osicala'),
	(235, 13, 'Perquín'),
	(236, 13, 'San Carlos'),
	(237, 13, 'San Fermando'),
	(238, 13, 'San Isidro'),
	(239, 13, 'San Simón'),
	(240, 13, 'Sensembra'),
	(241, 13, 'Sociedad'),
	(242, 13, 'Torola'),
	(243, 13, 'Yamabal'),
	(244, 13, 'Yoloaiquín'),
	(245, 14, 'La Unión'),
	(246, 14, 'Anamorós'),
	(247, 14, 'Bolívar'),
	(248, 14, 'Concepción de Oriente'),
	(249, 14, 'Conchagua'),
	(250, 14, 'El Carmen'),
	(251, 14, 'El Sauce'),
	(252, 14, 'Intipucá'),
	(253, 14, 'Lislique'),
	(254, 14, 'Meanguera del Golfo'),
	(255, 14, 'Nueva Esparta'),
	(256, 14, 'Pasaquina'),
	(257, 14, 'Polorós'),
	(258, 14, 'San Alejo'),
	(259, 14, 'San José'),
	(260, 14, 'Santa Rosa de Lima'),
	(261, 14, 'Yayantique'),
	(262, 14, 'Yucaiquín');

-- Volcando estructura para tabla siax.negocio
DROP TABLE IF EXISTS `negocio`;
CREATE TABLE IF NOT EXISTS `negocio` (
  `negocioID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clienteID` int(10) unsigned DEFAULT NULL,
  `usuarioID` int(10) unsigned DEFAULT NULL,
  `nombre_negocio` char(60) NOT NULL,
  `telefono_negocio` char(10) DEFAULT NULL,
  `direccion_negocio` char(70) DEFAULT NULL,
  `departamentoID` int(10) unsigned DEFAULT NULL,
  `municipioID` int(10) unsigned DEFAULT NULL,
  `tipo_documento_negocio` char(10) DEFAULT NULL,
  `num_documento_negocio` char(12) DEFAULT NULL,
  `email_negocio` char(60) DEFAULT NULL,
  `logo_negocio` char(50) DEFAULT NULL,
  `link` varchar(255) NOT NULL DEFAULT '',
  `promocionar` int(1) unsigned NOT NULL DEFAULT 0,
  `estado_negocio` int(11) DEFAULT 1,
  PRIMARY KEY (`negocioID`),
  KEY `FK_Maneja` (`usuarioID`),
  KEY `FK_Relationship_9` (`clienteID`),
  CONSTRAINT `FK_Maneja` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`usuarioID`),
  CONSTRAINT `FK_Relationship_9` FOREIGN KEY (`clienteID`) REFERENCES `cliente` (`clienteID`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.negocio: ~2 rows (aproximadamente)
DELETE FROM `negocio`;
INSERT INTO `negocio` (`negocioID`, `clienteID`, `usuarioID`, `nombre_negocio`, `telefono_negocio`, `direccion_negocio`, `departamentoID`, `municipioID`, `tipo_documento_negocio`, `num_documento_negocio`, `email_negocio`, `logo_negocio`, `link`, `promocionar`, `estado_negocio`) VALUES
	(1, NULL, 1, 'Adara Xpress', '56564454', 'negociando cerca', 6, 106, 'nit', '5445456123', 'nociociando@negocios.com', 'negocioDefecto.png', 'https://www.facebook.com/', 1, 1),
	(14, 2, 2, 'Negocio Propio', '985632322', 'Calle al negocio', 6, 106, 'nit', '6523214542', 'propionegocio@gmail.com', 'negocioDefecto.png', '', 0, 1);

-- Volcando estructura para tabla siax.paquerte
DROP TABLE IF EXISTS `paquerte`;
CREATE TABLE IF NOT EXISTS `paquerte` (
  `paqueteID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identificador` varchar(10) NOT NULL DEFAULT '',
  `usuarioID` int(10) unsigned DEFAULT NULL,
  `vendedorID` int(11) unsigned NOT NULL,
  `remuneracionID` int(10) unsigned DEFAULT NULL,
  `rutaID` int(10) unsigned DEFAULT NULL,
  `destinoID` int(10) unsigned DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `es_personalizado` tinyint(1) NOT NULL,
  `listoSalir` int(11) NOT NULL DEFAULT 0,
  `nombre_cliente` varchar(255) DEFAULT NULL,
  `telefono_cliente` char(11) DEFAULT NULL,
  `telefono_vendedor` char(11) DEFAULT NULL,
  `fecha_entrega` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_envio` date NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `costo_envio` decimal(10,2) DEFAULT NULL,
  `estado` char(20) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `foto` longblob DEFAULT NULL,
  `direccion_cliente` char(60) DEFAULT NULL,
  `recibido_recepcion` int(11) DEFAULT 0,
  `devuelto` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`paqueteID`),
  KEY `FK_Relationship_12` (`remuneracionID`),
  KEY `FK_Relationship_5` (`usuarioID`),
  KEY `FK_paquerte_cliente` (`vendedorID`),
  KEY `FK_paquerte_destino` (`destinoID`),
  KEY `FK_paquerte_ruta` (`rutaID`),
  CONSTRAINT `FK_Relationship_12` FOREIGN KEY (`remuneracionID`) REFERENCES `remuneraciones` (`remuneracionID`),
  CONSTRAINT `FK_Relationship_5` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`usuarioID`),
  CONSTRAINT `FK_paquerte_cliente` FOREIGN KEY (`vendedorID`) REFERENCES `cliente` (`clienteID`),
  CONSTRAINT `FK_paquerte_destino` FOREIGN KEY (`destinoID`) REFERENCES `destino` (`destinoID`),
  CONSTRAINT `FK_paquerte_ruta` FOREIGN KEY (`rutaID`) REFERENCES `ruta` (`rutaID`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.paquerte: ~8 rows (aproximadamente)
DELETE FROM `paquerte`;
INSERT INTO `paquerte` (`paqueteID`, `identificador`, `usuarioID`, `vendedorID`, `remuneracionID`, `rutaID`, `destinoID`, `descripcion`, `es_personalizado`, `listoSalir`, `nombre_cliente`, `telefono_cliente`, `telefono_vendedor`, `fecha_entrega`, `fecha_envio`, `precio`, `costo_envio`, `estado`, `total`, `foto`, `direccion_cliente`, `recibido_recepcion`, `devuelto`) VALUES
	(122, '001-000001', 39, 2, NULL, 2, 32, 'probando 1', 0, 1, 'Paquete 1', '45362514', '87654321', '2023-10-10 23:01:50', '2023-10-12', 6.00, 1.25, 'Entregado', 7.25, NULL, '', 1, 0),
	(123, '001-000002', 39, 2, NULL, 2, 32, 'probando 2', 0, 1, 'Paquete 2', '45362514', '87654321', '2023-10-10 23:07:07', '2023-10-12', 4.00, 0.75, 'No retirado', 4.75, NULL, '', 1, 0),
	(124, '001-000003', 39, 2, NULL, 1, 1, 'prueba 3', 0, 1, 'Paquete 3', '45362514', '87654321', '2023-10-11 00:02:45', '2023-10-18', 3.00, 2.00, 'En bodega', 5.00, NULL, '', 1, 0),
	(125, '001-000004', 39, 2, NULL, 1, 27, 'prueba 4', 0, 1, 'Paquete 4', '45362514', '87654321', '2023-10-11 00:03:48', '2023-10-18', 4.00, 1.00, 'En bodega', 5.00, NULL, '', 1, 0),
	(126, '001-000005', 39, 2, NULL, 1, 28, 'prueba 5', 0, 1, 'Paquete 5', '45362514', '87654321', '2023-10-11 00:04:33', '2023-10-18', 5.00, 0.50, 'En bodega', 5.50, NULL, '', 1, 0),
	(128, '001-000006', 39, 2, NULL, NULL, NULL, 'prueba 6', 1, 1, 'Paquete 6', '45362514', '87654321', '2023-10-11 12:04:06', '2023-10-12', 5.00, 2.25, 'Entregado', 7.25, NULL, 'Colonia San Francisco, Avenida Las Camelias y Calle Los Abet', 1, 0),
	(129, '001-000007', 39, 2, NULL, NULL, NULL, 'prueba 7', 1, 1, 'Paquete 7', '45362514', '87654321', '2023-10-11 13:26:17', '2023-10-11', 12.00, 2.25, 'No retirado', 14.25, NULL, 'residencial las flores, san miguel', 1, 0),
	(130, '001-000008', 39, 2, NULL, 3, 41, 'Zapatos', 0, 1, 'Mario', '45362514', '87654321', '2023-10-12 23:40:36', '2023-10-14', 25.00, 1.50, 'No retirado', 26.50, NULL, '', 1, 0);

-- Volcando estructura para tabla siax.paquete_estados_fecha
DROP TABLE IF EXISTS `paquete_estados_fecha`;
CREATE TABLE IF NOT EXISTS `paquete_estados_fecha` (
  `paquete__estado_fechaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paqueteID` int(10) unsigned DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT '',
  `fecha_estado` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`paquete__estado_fechaID`),
  KEY `fk_paquete_estado_fecha_paquerte` (`paqueteID`),
  CONSTRAINT `fk_paquete_estado_fecha_paquerte` FOREIGN KEY (`paqueteID`) REFERENCES `paquerte` (`paqueteID`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.paquete_estados_fecha: ~22 rows (aproximadamente)
DELETE FROM `paquete_estados_fecha`;
INSERT INTO `paquete_estados_fecha` (`paquete__estado_fechaID`, `paqueteID`, `estado`, `fecha_estado`) VALUES
	(108, 126, 'En bodega', '2023-10-11 00:26:29'),
	(109, 125, 'En bodega', '2023-10-11 00:26:47'),
	(110, 124, 'En bodega', '2023-10-11 00:26:54'),
	(111, 122, 'En bodega', '2023-10-11 00:27:00'),
	(112, 123, 'En bodega', '2023-10-11 00:27:05'),
	(113, 123, 'En ruta', '2023-10-11 00:54:33'),
	(114, 122, 'En ruta', '2023-10-11 00:54:33'),
	(115, 123, 'Listo para entregar', '2023-10-11 00:55:11'),
	(116, 122, 'Listo para entregar', '2023-10-11 00:55:11'),
	(117, 122, 'Entregado', '2023-10-11 00:55:30'),
	(118, 123, 'No retirado', '2023-10-11 00:55:37'),
	(120, 128, 'En bodega', '2023-10-11 12:04:06'),
	(121, 129, 'En bodega', '2023-10-11 13:26:54'),
	(125, 129, 'En ruta', '2023-10-11 13:31:36'),
	(126, 129, 'Listo para entregar', '2023-10-11 13:32:42'),
	(127, 129, 'No retirado', '2023-10-11 13:32:46'),
	(128, 130, 'En bodega', '2023-10-12 23:46:34'),
	(129, 130, 'En ruta', '2023-10-12 23:53:06'),
	(130, 130, 'Listo para entregar', '2023-10-12 23:53:55'),
	(132, 130, 'No retirado', '2023-10-12 23:55:27'),
	(133, 128, 'En ruta', '2023-10-12 23:59:32'),
	(134, 128, 'Listo para entregar', '2023-10-12 23:59:46'),
	(135, 128, 'Entregado', '2023-10-13 00:00:07');

-- Volcando estructura para tabla siax.permiso
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE IF NOT EXISTS `permiso` (
  `permisoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_permiso` char(25) NOT NULL,
  PRIMARY KEY (`permisoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.permiso: ~0 rows (aproximadamente)
DELETE FROM `permiso`;

-- Volcando estructura para tabla siax.producto_categoria
DROP TABLE IF EXISTS `producto_categoria`;
CREATE TABLE IF NOT EXISTS `producto_categoria` (
  `producto_categoriaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoriaID` int(10) unsigned NOT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `costo_estimado_envio` decimal(7,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`producto_categoriaID`),
  KEY `fk_producto_categoria_categoria_producto` (`categoriaID`),
  CONSTRAINT `fk_producto_categoria_categoria_producto` FOREIGN KEY (`categoriaID`) REFERENCES `categoria_producto` (`categoriaID`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.producto_categoria: ~94 rows (aproximadamente)
DELETE FROM `producto_categoria`;
INSERT INTO `producto_categoria` (`producto_categoriaID`, `categoriaID`, `nombre_producto`, `costo_estimado_envio`) VALUES
	(1, 1, 'Zapatos de bebé (sin suela) en bolsa', 0.50),
	(2, 1, 'Zapatos, sandalias, yinas o pantuflas en bolsa', 0.75),
	(3, 1, 'Botas en bolsa', 1.00),
	(4, 2, 'Sandalias pachitas o yinas de dama en bolsa', 1.25),
	(5, 2, 'Zapatos, sandalias altas o pantuflas de dama en bolsa', 1.00),
	(6, 2, 'Zapatos o yinas de caballero o pantuflas en bolsa', 1.25),
	(7, 2, 'Botas en bolsa', 1.50),
	(8, 2, 'Calzado en caja', 1.75),
	(9, 3, 'Zapatera de tela o plástico (de colgar)', 1.00),
	(10, 3, 'Zapatera armable pequeña', 1.50),
	(11, 3, 'Zapatera armable grande', 2.00),
	(12, 4, '1 sábana (tela delgada)', 0.75),
	(13, 4, '2 sábanas (tela delgada)', 1.50),
	(14, 4, '3 sábanas (tela delgada)', 2.00),
	(15, 4, '4 o más sábanas (tela delgada), precio por c/u', 0.50),
	(16, 4, 'Edredón', 1.75),
	(17, 4, '1 sobrefunda', 0.50),
	(18, 4, '2 sobrefundas', 0.75),
	(19, 4, '3 sobrefundas', 1.00),
	(20, 4, '4 o más sobrefundas, precio por c/u', 0.25),
	(21, 4, 'Set de cama (tela delgada)', 1.75),
	(22, 4, 'Set de cama (tela gruesa, con adredón)', 2.50),
	(23, 4, 'Frazada pequeña', 1.00),
	(24, 4, 'Frazada mediana', 1.50),
	(25, 4, 'Frazada grande', 1.75),
	(26, 5, 'Cojín pequeño', 0.75),
	(27, 5, 'Cojín mediano', 1.00),
	(28, 5, 'Cojín grande', 1.75),
	(29, 5, 'Almohada pequeña', 1.00),
	(30, 5, 'Almohada grande', 1.75),
	(31, 6, '1 cortina (tela delgada)', 0.75),
	(32, 6, 'Par de cortinas (tela delgada)', 1.00),
	(33, 6, '1 cortina (tela gruesa)', 1.00),
	(34, 6, 'Par de cortinas (tela gruesa)', 1.50),
	(35, 6, 'Cortina de baño', 0.75),
	(36, 6, '1 a 2 cortinas de cocina', 0.50),
	(37, 6, 'Mantel pequeño', 0.50),
	(38, 6, 'Mantel mediano', 0.75),
	(39, 6, 'Mantel grande', 1.00),
	(40, 6, 'Set de individuales de tela delgada', 1.00),
	(41, 6, 'Set de individuales de material doble', 1.50),
	(42, 7, 'Alfombra pequeña', 0.75),
	(43, 7, 'Alfombra mediana', 1.25),
	(44, 7, 'Alfombra grande entre $1.75 y $2.50 dependiendo el tamaño', 0.00),
	(45, 7, 'Organizador pequeño', 0.50),
	(46, 7, 'Organizador mediano', 0.75),
	(47, 7, 'Organizador grande', 1.25),
	(48, 8, '1 a 3 piezas (anillos, aretes, cadena, esclava, tobillera) en bolsa', 0.50),
	(49, 8, '4 a 6 piezas (anillos, aretes, cadena, esclava, tobillera) en bolsa', 1.00),
	(50, 8, '7 a 9 piezas (anillos, aretes, cadena, esclava, tobillera) en bolsa', 1.25),
	(51, 8, '10 a 12 piezas (anillos, aretes, cadena, esclava, tobillera) en bolsa', 1.50),
	(52, 8, '1 a 2 piezas de bisutería con piedras grandes en bolsa', 0.50),
	(53, 8, '3 a 4 piezas de bisutería con piedras grandes en bolsa', 0.75),
	(54, 8, '5 a 6 piezas de bisutería con piedras grandes en bolsa', 1.00),
	(55, 8, '7 a 9 piezas de bisutería con piedras grandes en bolsa', 1.50),
	(56, 8, '10 a 12 piezas de bisutería con piedras grandes en bolsa', 1.75),
	(57, 8, 'Set de joyas o bisutería en bolsa', 1.00),
	(58, 8, 'Set de joyas o bisutería en caja', 1.50),
	(60, 8, 'Joyero pequeño', 1.00),
	(61, 8, 'Joyero mediano', 1.50),
	(62, 8, 'Joyero grande', 1.75),
	(63, 8, 'Mostrador de anillos (mano)', 0.75),
	(64, 8, 'Mostrador de anillos pequeño', 0.50),
	(65, 9, '1 prenda', 0.75),
	(66, 9, '2 prendas', 1.50),
	(67, 9, '3 prendas', 2.00),
	(68, 9, '4 prendas o más $0.50 c/u', 0.50),
	(69, 9, 'Docena de ropa', 4.50),
	(70, 9, 'Suéter o chaqueta (tela gruesa)', 1.00),
	(71, 9, 'Bata de baño (tela gruesa)', 1.00),
	(72, 9, 'Pijama (tela gruesa)', 1.00),
	(73, 10, 'Prenda de niño $0.50 c/u', 0.50),
	(74, 10, 'Docena de ropa', 4.50),
	(75, 10, 'Vestido pomposo', 0.75),
	(76, 10, 'Suéter o chaquete (tela gruesa)', 0.75),
	(77, 10, 'Bata de baño (tela gruesa)', 0.75),
	(78, 10, 'Pijama (tela gruesa)', 0.75),
	(79, 11, '1 a 2 bloumer, top, calzoncillo, bóxer o calcetines', 0.50),
	(80, 11, '3 bloumer, top, calzoncillo, bóxer o calcetines', 0.75),
	(81, 11, '4 bloumer, top, calzoncillo, bóxer o calcetines', 1.00),
	(82, 11, '5 bloumer, top, calzoncillo, bóxer o calcetines', 1.25),
	(83, 11, '7 a 8 bloumer, top, calzoncillo, bóxer o calcetines', 1.50),
	(84, 11, '9 a 10 bloumer, top, calzoncillo, bóxer o calcetines', 1.75),
	(86, 11, '11 a 12 bloumer, top, calzoncillo, bóxer o calcetines', 2.00),
	(87, 12, '1 brasier, top, bralet, medias o set de lencería', 0.50),
	(88, 12, '2 brasier, top, bralet, medias o set de lencería', 1.00),
	(89, 12, '3 a 4  brasier, top, bralet, medias o set de lencería', 1.50),
	(90, 12, '5 brasier, top, bralet, medias o set de lencería', 1.75),
	(92, 12, '6 brasier, top, bralet, medias o set de lencería', 2.00),
	(93, 12, '7 brasier, top, bralet, medias o set de lencería', 2.25),
	(94, 12, '8 brasier, top, bralet, medias o set de lencería', 2.50),
	(95, 12, '9 a 10 brasier, top, bralet, medias o set de lencería', 2.75),
	(96, 12, '11 a 12 brasier, top, bralet, medias o set de lencería', 3.00);

-- Volcando estructura para tabla siax.quejas
DROP TABLE IF EXISTS `quejas`;
CREATE TABLE IF NOT EXISTS `quejas` (
  `QuejaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clienteID` int(10) unsigned NOT NULL,
  `empleadoID` int(10) unsigned NOT NULL,
  `asunto` char(255) NOT NULL,
  `contenido` char(255) NOT NULL,
  PRIMARY KEY (`QuejaID`),
  KEY `FK_Relationship_15` (`empleadoID`),
  KEY `FK_Relationship_16` (`clienteID`),
  CONSTRAINT `FK_Relationship_15` FOREIGN KEY (`empleadoID`) REFERENCES `empleado` (`empleadoID`),
  CONSTRAINT `FK_Relationship_16` FOREIGN KEY (`clienteID`) REFERENCES `cliente` (`clienteID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.quejas: ~0 rows (aproximadamente)
DELETE FROM `quejas`;

-- Volcando estructura para tabla siax.reenvio
DROP TABLE IF EXISTS `reenvio`;
CREATE TABLE IF NOT EXISTS `reenvio` (
  `reenvioID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paqueteID` int(10) unsigned NOT NULL,
  `destino` char(255) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `costo_reenvio` decimal(10,0) NOT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`reenvioID`),
  KEY `FK_Relationship_17` (`paqueteID`),
  CONSTRAINT `FK_Relationship_17` FOREIGN KEY (`paqueteID`) REFERENCES `paquerte` (`paqueteID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.reenvio: ~0 rows (aproximadamente)
DELETE FROM `reenvio`;

-- Volcando estructura para tabla siax.remuneraciones
DROP TABLE IF EXISTS `remuneraciones`;
CREATE TABLE IF NOT EXISTS `remuneraciones` (
  `remuneracionID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `metodo_pagoID` int(10) unsigned NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `comprobante` longblob DEFAULT NULL,
  PRIMARY KEY (`remuneracionID`),
  KEY `FK_Relationship_24` (`metodo_pagoID`),
  CONSTRAINT `FK_Relationship_24` FOREIGN KEY (`metodo_pagoID`) REFERENCES `metodo_pagos` (`metodo_pagoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.remuneraciones: ~0 rows (aproximadamente)
DELETE FROM `remuneraciones`;

-- Volcando estructura para tabla siax.ruta
DROP TABLE IF EXISTS `ruta`;
CREATE TABLE IF NOT EXISTS `ruta` (
  `rutaID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empleadoID` int(10) unsigned NOT NULL DEFAULT 4,
  `dia` char(20) NOT NULL,
  `hora_desde` time NOT NULL DEFAULT '07:30:00',
  `hora_hasta` time NOT NULL DEFAULT '17:30:00',
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`rutaID`),
  KEY `FK_Relationship_20` (`empleadoID`),
  CONSTRAINT `FK_Relationship_20` FOREIGN KEY (`empleadoID`) REFERENCES `empleado` (`empleadoID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.ruta: ~3 rows (aproximadamente)
DELETE FROM `ruta`;
INSERT INTO `ruta` (`rutaID`, `empleadoID`, `dia`, `hora_desde`, `hora_hasta`, `estado`) VALUES
	(1, 4, 'Miércoles', '09:00:00', '17:15:00', 1),
	(2, 4, 'Jueves', '09:00:00', '16:30:00', 1),
	(3, 4, 'Sábado', '09:00:00', '17:15:00', 0);

-- Volcando estructura para tabla siax.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuarioID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empleadoID` int(10) unsigned DEFAULT NULL,
  `clienteID` int(10) unsigned DEFAULT NULL,
  `tipo_usuario` char(20) NOT NULL,
  `user_login` char(20) NOT NULL,
  `contrasena` char(255) NOT NULL,
  `estado_usuario` int(10) unsigned NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`usuarioID`),
  KEY `FK_Relationship_23` (`empleadoID`),
  KEY `FK_Relationship_26` (`clienteID`),
  CONSTRAINT `FK_Relationship_23` FOREIGN KEY (`empleadoID`) REFERENCES `empleado` (`empleadoID`),
  CONSTRAINT `FK_Relationship_26` FOREIGN KEY (`clienteID`) REFERENCES `cliente` (`clienteID`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.usuario: ~6 rows (aproximadamente)
DELETE FROM `usuario`;
INSERT INTO `usuario` (`usuarioID`, `empleadoID`, `clienteID`, `tipo_usuario`, `user_login`, `contrasena`, `estado_usuario`, `fecha_creacion`) VALUES
	(1, NULL, NULL, 'admin', 'admin', '20f3765880a5c269b747e1e906054a4b4a3a991259f1e16b5dde4742cec2319a', 1, '2023-03-24 11:18:35'),
	(2, NULL, 2, 'vendedor', 'pared', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 1, '2023-04-17 14:15:21'),
	(38, 3, NULL, 'recepcion', 'maria', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 1, '2023-03-25 22:33:41'),
	(39, NULL, 1, 'cliente', 'gabriel', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 1, '2023-04-26 17:13:41'),
	(58, 4, NULL, 'repartidor', 'pedro', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 1, '2023-03-25 16:21:27');

-- Volcando estructura para tabla siax.usuario_permiso
DROP TABLE IF EXISTS `usuario_permiso`;
CREATE TABLE IF NOT EXISTS `usuario_permiso` (
  `usuario_permisoID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permisoID` int(10) unsigned NOT NULL,
  `usuarioID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`usuario_permisoID`),
  KEY `FK_Relationship_21` (`permisoID`),
  KEY `FK_Relationship_22` (`usuarioID`),
  CONSTRAINT `FK_Relationship_21` FOREIGN KEY (`permisoID`) REFERENCES `permiso` (`permisoID`),
  CONSTRAINT `FK_Relationship_22` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`usuarioID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla siax.usuario_permiso: ~0 rows (aproximadamente)
DELETE FROM `usuario_permiso`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
