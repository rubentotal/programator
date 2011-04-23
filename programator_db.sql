-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 23-04-2011 a las 02:38:47
-- Versión del servidor: 5.1.37
-- Versión de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `programator`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
CREATE TABLE IF NOT EXISTS `asignaturas` (
  `Codigo` char(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Curso` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Ciclo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcar la base de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`Codigo`, `Nombre`, `Descripcion`, `Curso`, `Ciclo`) VALUES
('DAE4G', 'Desarrollo de Aplicaciones en Entornos de 4a Gener', 'Desarrollo de Aplicaciones en Entornos de 4a Generación y Herramientas CASE', '2', 'DAI'),
('DAE4P', 'Pendientes - Desarrollo de Aplicaciones en Lenguajes de 4a Generación y Herramientas CASE', 'Pendientes - Desarrollo de Aplicaciones en Lenguajes de 4a Generación y Herramientas CASE', '2', 'DAI'),
('SIF', 'Seguridad Informática', 'Seguridad Informática', '2', 'Sistemas Microinformáticos y Redes'),
('SIF-p', 'Pendiente - Seguridad Informatica', 'Pendiente - Seguridad Informatica', '2', 'SMR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones`
--

DROP TABLE IF EXISTS `evaluaciones`;
CREATE TABLE IF NOT EXISTS `evaluaciones` (
  `Codigo` char(5) CHARACTER SET latin1 NOT NULL,
  `Inicio` date NOT NULL,
  `Fin` date NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcar la base de datos para la tabla `evaluaciones`
--

INSERT INTO `evaluaciones` (`Codigo`, `Inicio`, `Fin`) VALUES
('1', '2010-09-16', '2010-12-20'),
('2', '2010-12-21', '2011-03-23'),
('A1', '2011-04-04', '2011-06-10'),
('P', '2011-04-04', '2011-06-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `festivos`
--

DROP TABLE IF EXISTS `festivos`;
CREATE TABLE IF NOT EXISTS `festivos` (
  `Fecha` date NOT NULL,
  `Nombre` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`Fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcar la base de datos para la tabla `festivos`
--

INSERT INTO `festivos` (`Fecha`, `Nombre`) VALUES
('2010-10-12', 'La hispanidad'),
('2010-11-01', 'Todos los santos'),
('2010-12-06', 'Constitución'),
('2010-12-07', 'Constitución'),
('2010-12-08', 'Purísima'),
('2011-05-02', 'Día del trabajo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `asignatura` char(5) COLLATE utf8_spanish2_ci NOT NULL,
  `dia` int(11) NOT NULL,
  `horas` int(11) NOT NULL,
  PRIMARY KEY (`asignatura`,`dia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcar la base de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`asignatura`, `dia`, `horas`) VALUES
('DAE4G', 1, 3),
('DAE4G', 2, 3),
('DAE4G', 3, 3),
('DAE4G', 4, 3),
('DAE4G', 5, 2),
('DAE4P', 2, 3),
('DAE4P', 3, 2),
('DAE4P', 5, 2),
('SIF', 1, 2),
('SIF', 4, 1),
('SIF', 5, 2),
('SIF-p', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

DROP TABLE IF EXISTS `unidades`;
CREATE TABLE IF NOT EXISTS `unidades` (
  `Asignatura` char(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Codigo` char(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Duracion` int(11) NOT NULL,
  `Color` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`Asignatura`,`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcar la base de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`Asignatura`, `Codigo`, `Nombre`, `Descripcion`, `Duracion`, `Color`) VALUES
('DAE4G', '0', 'Introducción.  Modelo Entidad-Relación', 'Introducción.  Modelo Entidad-Relación', 9, 'DarkGreen'),
('DAE4G', '1', 'Access Avanzado', 'Access Avanzado', 40, 'DarkMagenta'),
('DAE4G', '2', 'SQL Avanzado', 'SQL Avanzado', 400, 'Gold'),
('DAE4P', '1', 'Pendiente', 'Pendiente', 300, 'Green'),
('SIF', '1', 'Introducción a la Seguridad Informática', 'Introducción a la Seguridad Informática', 5, 'Crimson'),
('SIF', '2', 'Seguridad Física', 'Seguridad Física', 15, 'SteelBlue'),
('SIF', '3', 'Seguridad Pasiva. Recuperación de datos.', 'Seguridad Pasiva. Recuperación de datos.', 30, ''),
('SIF', '4', 'Sistemas de identificación. Criptografía', 'Sistemas de identificación. Criptografía', 30, ''),
('SIF', '5', 'Seguridad activa en el sistema.', 'Seguridad activa en el sistema', 30, ''),
('SIF', '6', 'Seguridad activa en redes', 'Seguridad activa en redes', 30, ''),
('SIF', '7', 'Firewall', 'Firewall', 30, ''),
('SIF', '8', 'Proxy', 'Proxy', 30, ''),
('SIF-p', '1', 'Pendiente', 'Pendiente', 20, 'Green');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacaciones`
--

DROP TABLE IF EXISTS `vacaciones`;
CREATE TABLE IF NOT EXISTS `vacaciones` (
  `Codigo` char(5) COLLATE utf8_spanish2_ci NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Inicio` date NOT NULL,
  `Fin` date NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcar la base de datos para la tabla `vacaciones`
--

INSERT INTO `vacaciones` (`Codigo`, `Nombre`, `Inicio`, `Fin`) VALUES
('1', 'Navidades', '2010-12-23', '2011-01-06'),
('2', 'Semana Santa', '2011-04-21', '2011-05-02');
