-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-08-2019 a las 20:07:34
-- Versión del servidor: 5.6.39-83.1
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `softengi_datac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cat_id` int(8) NOT NULL,
  `cat_nom` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cat_fechai` date NOT NULL,
  `tps_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cat_id`, `cat_nom`, `cat_fechai`, `tps_id`) VALUES
(1, 'Salario', '2019-08-06', 1),
(5, 'Comida', '2019-08-03', 2),
(6, 'Freelancer', '2019-08-03', 1),
(9, 'Gastos Fijos1', '2019-08-06', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cli_id` int(8) NOT NULL,
  `cli_nom` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cli_empresa` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cli_sitio` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cli_numero` int(10) NOT NULL,
  `cli_fecha` date NOT NULL,
  `cli_email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cli_ubicacion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `usr_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cli_id`, `cli_nom`, `cli_empresa`, `cli_sitio`, `cli_numero`, `cli_fecha`, `cli_email`, `cli_ubicacion`, `usr_id`) VALUES
(1, 'Juan perez', 'ksjks', 'sdklkdsl', 233, '2019-08-16', 'dldsklskd', 'sdklds', 13),
(2, '', '', '', 0, '0000-00-00', '', '', 66),
(3, 'Albert Gomez', 'QR25', 'REM', 2147483647, '2019-08-26', 'jp_178@hotmail.com', 'KLKLSKL', 13),
(4, 'lkkl', 'ñl', 'sdlñlds', 333, '2019-08-27', 'xw_1745@hotmail.com', 's', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `pro_id` int(8) NOT NULL,
  `pro_nom` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `pro_fecha` date NOT NULL,
  `pro_precio` int(8) NOT NULL,
  `cli_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`pro_id`, `pro_nom`, `pro_fecha`, `pro_precio`, `cli_id`) VALUES
(1, 'vlññldf', '2019-08-21', 234, 1),
(9, 'Web', '2019-08-21', 250, 1),
(23, '', '0000-00-00', 0, 2),
(24, 'YTU', '2019-08-29', 150, 3),
(25, 'qq', '2019-08-27', 123, 4),
(26, 'qq', '2019-08-27', 123, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `tar_id` int(8) NOT NULL,
  `pro_id` int(8) NOT NULL,
  `tar_descripcion` varchar(2500) COLLATE utf8_unicode_ci NOT NULL,
  `tar_tiempo` datetime NOT NULL,
  `tar_pago` float NOT NULL,
  `tar_status` int(11) NOT NULL,
  `tar_final` datetime NOT NULL,
  `tar_precio` float NOT NULL,
  `tar_dif` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`tar_id`, `pro_id`, `tar_descripcion`, `tar_tiempo`, `tar_pago`, `tar_status`, `tar_final`, `tar_precio`, `tar_dif`) VALUES
(38, 1, 'Hola', '0000-00-00 00:00:00', 0, 0, '2019-08-16 23:46:16', 914.861, 13174),
(44, 1, 'yii', '2019-08-17 00:22:08', 234, 0, '2019-08-17 00:22:21', 0.845, 13),
(47, 1, 'ñllñdflñdf', '2019-08-19 08:55:18', 234, 0, '2019-08-19 08:55:24', 0.39, 6),
(50, 1, 'lñlññl', '2019-08-19 09:10:18', 234, 0, '2019-08-19 09:10:23', 0.325, 5),
(67, 9, 'kks', '2019-08-26 18:07:21', 250, 0, '2019-08-26 18:29:17', 91.3889, 1316),
(70, 9, '', '2019-08-26 18:32:31', 250, 1, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `tps_id` int(8) NOT NULL,
  `tps_nom` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`tps_id`, `tps_nom`) VALUES
(1, 'Ingresos'),
(2, 'Gastos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `trs_id` int(8) NOT NULL,
  `trs_tipo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` int(8) NOT NULL,
  `trs_descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `trs_cantidad` float NOT NULL,
  `trs_fechai` date NOT NULL,
  `trs_repetir` int(11) NOT NULL,
  `usr_id` int(8) NOT NULL,
  `tps_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`trs_id`, `trs_tipo`, `cat_id`, `trs_descripcion`, `trs_cantidad`, `trs_fechai`, `trs_repetir`, `usr_id`, `tps_id`) VALUES
(4, 'dsjkhdsjs', 1, 'dslkdjksjlkd', 43436, '2019-08-13', 0, 24, 1),
(16, '9', 1, 'Db', 3000, '2019-08-09', 0, 13, 1),
(19, '5', 6, 'Prueba', 120, '2019-08-09', 0, 13, 1),
(22, '', 6, 'Clases', 10000, '2019-08-13', 0, 13, 1),
(23, '', 5, 'Cena en chester', 2000, '2019-08-07', 0, 13, 2),
(25, '', 9, 'hshs', 3002, '2019-08-08', 0, 13, 2),
(29, '', 5, 'desayuno', 250, '2019-08-08', 0, 13, 2),
(32, '', 1, 'teclado', 200, '2019-08-08', 0, 13, 1),
(33, '', 9, 'Casa', 3500, '2019-08-08', 0, 13, 2),
(34, '', 5, 'cena', 2000, '2019-08-08', 0, 13, 2),
(35, '6', 1, 'Pago Barrer1', 1000, '2019-08-09', 0, 75, 1),
(36, '', 1, 'Pago de Proyecto', 10000, '2019-08-13', 0, 13, 1),
(37, '', 5, '', 0, '2019-08-13', 0, 13, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usr_id` int(8) NOT NULL,
  `usr_nom` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_password` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_fechai` date NOT NULL,
  `usr_status` int(11) NOT NULL,
  `usr_fechar` date NOT NULL,
  `usr_recuperar` int(11) NOT NULL,
  `token` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `usr_foto` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usr_id`, `usr_nom`, `usr_email`, `usr_password`, `usr_fechai`, `usr_status`, `usr_fechar`, `usr_recuperar`, `token`, `usr_foto`) VALUES
(13, 'Oliver Ortiz 1', 'xw_1745@hotmail.com', '12345678', '2019-08-08', 1, '2019-08-03', 0, '', '../../assets/images/team-member-2.png'),
(24, 'Max', 'xc.,cxm,xcv.m,', '12345678', '2019-08-27', 1, '0000-00-00', 0, '', ''),
(66, 'Juan Lopez', 'jp_178@hotmail.com', '12345678', '2019-08-27', 1, '0000-00-00', 0, '', ''),
(75, 'Abraham Pech', 'abraham_16_69@hotmail.com', '123456', '2019-08-13', 1, '0000-00-00', 0, '', '../../assets/images/23600611_10214767340286833_808564317_o.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `tps_id` (`tps_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cli_id`),
  ADD KEY `urs_id` (`usr_id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `proyectos_ibfk_1` (`cli_id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`tar_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`tps_id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`trs_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `usr_id` (`usr_id`),
  ADD KEY `tps_id` (`tps_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cat_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cli_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `pro_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `tar_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `tps_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `trs_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usr_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`tps_id`) REFERENCES `tipos` (`tps_id`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `usuarios` (`usr_id`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`cli_id`) REFERENCES `cliente` (`cli_id`);

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `proyectos` (`pro_id`);

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categorias` (`cat_id`),
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`usr_id`) REFERENCES `usuarios` (`usr_id`),
  ADD CONSTRAINT `transacciones_ibfk_3` FOREIGN KEY (`tps_id`) REFERENCES `tipos` (`tps_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
