-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-03-2023 a las 17:22:17
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdlistadotarea`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcat` int NOT NULL AUTO_INCREMENT,
  `nombrecat` varchar(40) NOT NULL,
  PRIMARY KEY (`idcat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcat`, `nombrecat`) VALUES
(3, 'Reunion'),
(4, 'Cita médica'),
(5, 'Gym');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `usuarios` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `operaciones` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`usuarios`, `fecha`, `operaciones`) VALUES
('jcoronel', '2023-03-07 15:19:47', 'tareas eliminada'),
('jcoronel', '2023-03-07 15:20:47', 'tareas eliminada'),
('jcoronel', '2023-03-07 15:38:09', 'tareas eliminada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

DROP TABLE IF EXISTS `tareas`;
CREATE TABLE IF NOT EXISTS `tareas` (
  `ident` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `idCategoria` int NOT NULL,
  `titulo` varchar(40) NOT NULL,
  `imagen` varchar(40) NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` varchar(20) NOT NULL,
  `lugar` varchar(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ident`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idCategoria` (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`ident`, `idUsuario`, `idCategoria`, `titulo`, `imagen`, `descripcion`, `prioridad`, `lugar`, `fecha`) VALUES
(43, 1, 3, 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', '2023-03-07 16:20:30'),
(44, 1, 4, 'asdf', 'asdfsdd', 'sddsdsds', 'sddsds', 'dsds', '2023-03-07 16:20:44'),
(45, 1, 3, 'df', 'df', 'df', 'df', 'df', '2023-03-07 16:37:46'),
(47, 1, 3, 'asdf', 'asdf', 'asdf', 'asdf', 'asdf', '2023-03-07 16:44:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `nick` varchar(40) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `contrasenia` varchar(40) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  `rol` varchar(40) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`iduser`, `nick`, `nombre`, `apellidos`, `email`, `contrasenia`, `avatar`, `rol`) VALUES
(1, 'jcoronel', 'José', 'Coronel Camacho', 'jcoronel@gmail.com', '123', 'avatar1.png', 'admin'),
(2, 'nano', 'Fernando', 'Alonso', 'falonso@gmail.com', '12345', 'avatar2.png', 'user'),
(3, 'sainzjr', 'Carlos', 'Sainz', 'carlosainzjr@gmail.com', '123', '', 'user');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`iduser`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idcat`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
