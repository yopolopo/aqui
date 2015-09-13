-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-09-2015 a las 11:13:48
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `demanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `pasando` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `apellido`, `correo`, `telefono`, `pasando`) VALUES
(1, 'Pablo', 'Hubbard', 'drabbuh@hotmail.com', '9981490533', 'a69947ff588f2fd595ce3f0558419fb3'),
(2, 'aaaa', 'bbbbb', 'Correo', 'Telefono', ''),
(3, 'Nooo', 'Soy', 'Nadie@nono.com', 'Telefono', ''),
(4, 'no ', 'soy', '', 'nadie', 'b8bb1218b0760236c37db00ea66b21f5'),
(5, 'no soy', 'nadie', '', '1000 8000', '1ec7e29e224496d8dc1706c25b3d9767');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demanda`
--

CREATE TABLE IF NOT EXISTS `demanda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folio` varchar(10) NOT NULL,
  `idc` int(11) NOT NULL,
  `ids` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `latitud` decimal(22,16) NOT NULL,
  `longitud` decimal(22,16) NOT NULL,
  `estatus` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `respuesta` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcar la base de datos para la tabla `demanda`
--

INSERT INTO `demanda` (`id`, `folio`, `idc`, `ids`, `comentario`, `imagen`, `latitud`, `longitud`, `estatus`, `fecha`, `respuesta`) VALUES
(1, '11', 0, 1, 'amazing', '', 20.6357160971144680, -86.8507969379425000, 3, '2014-07-01 23:02:28', 'Resueltoooooooooooooooo'),
(2, '12', 0, 2, 'aaaaa', 'imagenes/blank.png', 20.6357876971144680, -86.8535259000000200, 1, '2014-07-02 18:35:22', ''),
(3, '13', 1, 1, 'erase una vez un lobito bueno al que maltrataban todos los corderos', 'imagenes/1358317588556.jpg', 20.6312360971144680, -86.8561862936707000, 1, '2014-07-02 18:46:30', ''),
(5, '22', 0, 2, 'hay un huecote, aqui mismo', '', 21.1570405148672830, -86.8454980115784000, 1, '2014-07-22 00:05:17', ''),
(6, '23', 2, 2, 'aaaa', 'imagenes/', 21.1583775999999980, -86.8536323000000200, 1, '2014-11-04 17:29:04', ''),
(7, '24', 0, 2, 'Test foto', 'imagenes/1442081436389-79826597.jpg', 21.1658303000000000, -86.8211952000000300, 1, '2015-09-12 13:11:22', ''),
(8, '25', 0, 2, 'Test foto', 'imagenes/1442081436389-79826597.jpg', 21.1658303000000000, -86.8211952000000300, 0, '2015-09-12 13:11:23', ''),
(9, '26', 3, 2, 'Test teeeeest y mas test', 'imagenes/14421177467681635838605.jpg', 21.1658378000000000, -86.8211486999999800, 1, '2015-09-12 23:16:49', ''),
(10, '13', 0, 1, 'mi casa se quema, se quema mi casa', 'imagenes/', 21.1658300999999970, -86.8211460000000000, 1, '2015-09-12 23:19:54', ''),
(11, '27', 0, 2, 'Estoy hartoooo :(', 'imagenes/CAM00119.jpg', 21.1658231000000000, -86.8211903000000100, 1, '2015-09-13 00:06:29', ''),
(12, '14', 0, 1, 'no quiso dar su nombre', '', 21.1656634445327650, -86.8211317062378000, 1, '2015-09-13 02:08:15', ''),
(13, '28', 0, 2, 'agua pasa por mi casa, cate de mi... ', '', 21.1658300999999970, -86.8211460000000000, 1, '2015-09-13 02:13:49', ''),
(14, '29', 0, 2, 'solo me quejo y me quejo ', '', 21.1658300999999970, -86.8211460000000000, 1, '2015-09-13 02:14:41', ''),
(15, '15', 4, 1, 'nadieeeee', '', 21.1658300999999970, -86.8211460000000000, 1, '2015-09-13 02:15:41', ''),
(16, '16', 5, 1, 'jaaaaaa', '', 21.1658300999999970, -86.8211460000000000, 1, '2015-09-13 02:16:16', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE IF NOT EXISTS `estatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`id`, `nombre`) VALUES
(1, 'Nuevo'),
(2, 'Proceso'),
(3, 'Solucionado'),
(4, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iniciativas`
--

CREATE TABLE IF NOT EXISTS `iniciativas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `texto` varchar(5000) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcar la base de datos para la tabla `iniciativas`
--

INSERT INTO `iniciativas` (`id`, `titulo`, `descripcion`, `texto`, `imagen`, `fecha`) VALUES
(1, 'Alianza para el gobierno abierto', 'La Alianza para el Gobierno Abierto (AGA) es una iniciativa multilateral, en donde los gobiernos de 63 países miembros trabajan en conjunto con la sociedad civil para promover la participación ciudadana.', 'La Alianza para el Gobierno Abierto (AGA) es una iniciativa multilateral, en donde los gobiernos de 63 países miembros trabajan en conjunto con la sociedad civil para promover la participación ciudadana, incrementar la transparencia, combatir la corrupción, y usar la tecnología como habilitador de esta apertura.  Gobierno abierto significa impulsar un nuevo modelo de gobernanza, que requiere de un proceso de compromiso, colaboración y corresponsabilidad permanente y sostenible por parte del gobierno y todos los sectores de la sociedad.  En Me?xico, la Alianza para el Gobierno Abierto (AGA) es un espacio de dia?logo e intercambio de ideas que, en colaboracio?n con la sociedad civil, permite que el gobierno asuma compromisos para transformar la calidad de vida de las personas.', 'iniciativa/flyersAGA_envivoWeb_v01.jpg', '2014-07-17 18:37:30'),
(3, 'Las Aventuras de Fly', 'Valieeeeenteeeee Flyyyyyyy', 'Por el cielo y el mar, tu poder reinara, nunca dejes de luchar, valiente fly.\r\nSigue asi, buscando siempre la paz, y tus sueÃ±os un dia lograras realizar.', 'iniciativa/', '2014-07-18 02:16:37'),
(4, 'Las Aventuras de Fly', 'Valieeeeenteeeee Flyyyyyyy', 'Por el cielo y el mar, tu poder reinara, nunca dejes de luchar, valiente fly.\r\nSigue asi, buscando siempre la paz, y tus sueÃ±os un dia lograras realizar.', 'iniciativa/[UTWoots]_Sword_Art_Online_.jpg', '2014-07-18 02:17:39'),
(5, 'Cacao', 'Muajaja', '"Nunca pensÃ© en irme de Juventus. Quiero estar acÃ¡ y quedarme todo el tiempo que dure mi contrato", remarcÃ³ el argentino.\r\n\r\n"Lamento la salida de Conte, es una persona que nos ha ayudado mucho, pero ahora lo que tenemos que demostrar los jugadores es que es el equipo el que vence y no el entrenador", afirmÃ³ Tevez.', 'iniciativa/_CHIBI_L__by_saiyagina.jpg', '2014-07-23 16:27:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notademanda`
--

CREATE TABLE IF NOT EXISTS `notademanda` (
  `idd` int(11) NOT NULL,
  `nota` varchar(2000) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `notademanda`
--

INSERT INTO `notademanda` (`idd`, `nota`, `fecha`, `idu`) VALUES
(1, 'primera nota\r\n', '2014-07-07 20:10:28', 1),
(1, '', '2015-09-13 01:37:25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `quea`
--

CREATE TABLE IF NOT EXISTS `quea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `idc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `quea`
--

INSERT INTO `quea` (`id`, `nombre`, `idc`) VALUES
(1, '12697143', 1),
(2, '68837280', 4),
(3, '69982604', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `queu`
--

CREATE TABLE IF NOT EXISTS `queu` (
  `idp` int(11) NOT NULL,
  `varia` varchar(25) NOT NULL,
  PRIMARY KEY (`idp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `queu`
--

INSERT INTO `queu` (`idp`, `varia`) VALUES
(1, 'admin'),
(2, 'asdf1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE IF NOT EXISTS `servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcar la base de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id`, `nombre`) VALUES
(1, 'SEGURIDAD PUBLICA'),
(2, 'PAVIMENTACION Y BACHEO'),
(3, 'ALUMBRADO PUBLICO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `pasando` varchar(100) NOT NULL,
  `grupo` int(11) NOT NULL,
  `noombre` varchar(35) NOT NULL,
  `appaterno` varchar(35) NOT NULL,
  `apmaterno` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `pasando`, `grupo`, `noombre`, `appaterno`, `apmaterno`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '', '', ''),
(2, 'betelgeuse', '1adbb3178591fd5bb0c248518f39bf6d', 1, 'jaime', 'hernandez', 'guzman');
