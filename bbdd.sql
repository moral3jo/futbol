-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2013 a las 18:23:40
-- Versión del servidor: 5.6.11-log
-- Versión de PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `login`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE IF NOT EXISTS `jugadores` (
  `idpartido` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `color` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(2) NOT NULL,
  `dia` date NOT NULL,
  `lugar` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id`, `estado`, `dia`, `lugar`) VALUES
(1, 'OK', '2013-10-11', 'LA SALUD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `correo` varchar(64) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `pass`, `estado`, `codigo`) VALUES
(1, 'roberto', 'moral3jo@gmail.com', '$2y$10$mS/PnUFOTFccBBkLvAFAaOcw6K.zTi.DkngOIbuzKyEETEM1I.WH6', 'fi', 'roberto'),
(2, 'ivan', 'ivan@correo.com', '$2y$10$Es.go8FQZWK8mGQKzFpN8uBolEY/os3hAViAjRXvSWYG0CO9cWuRu', 'fi', 'ivan'),
(3, 'oskar', 'oskar@correo.com', '$2y$10$DlJUaJbHxkYYZJwp2ZeEdOwIHHVX342buj7t.z6C2zYrHtWYIFQ2u', 'fi', 'oskar'),
(4, 'fer', 'fer@correo.com', '$2y$10$O30uJFuiuLKzLZ3LUz8qkuoaKGKLw1dcRSAk2slMAz4JN4rYgdR1.', 'no', 'fer'),
(5, 'miguel', 'miguel@hotmail.com', '$2y$10$UJhx.dNqlxwgqIN.RDe7Ae2HatNZq.NbuBs9ojwS91J2GMwQYiKeC', 'no', 'miguel');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
