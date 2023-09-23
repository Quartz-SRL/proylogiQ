-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2023 a las 05:53:11
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `logiq`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `id` int(30) NOT NULL,
  `calle` varchar(30) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `departamento` varchar(30) NOT NULL,
  `cantEntradas` int(30) DEFAULT NULL,
  `codigoVerificacion` int(30) DEFAULT NULL,
  `ciudadesCubre` varchar(30) DEFAULT NULL,
  `Firma` varchar(30) DEFAULT NULL,
  `km` int(30) NOT NULL,
  `ruta` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id`, `calle`, `numero`, `ciudad`, `departamento`, `cantEntradas`, `codigoVerificacion`, `ciudadesCubre`, `Firma`, `km`, `ruta`) VALUES
(1, '1', '1', '1', '1', 1, 0, '1', '1', 1, 0),
(2, '2', '2', '2', '2', 2, 2, '2', '2', 2, 2),
(12, '21', '122121', '21', '12', 21, 21, '12', '12', 121, 0),
(4234, '324', '324', '3242', '432', 432, 432, '32', '4324', 32, 432),
(4324, '432', '432', '432', '432', 432, 432, '432', '432', 4, 32),
(5345345, '5345', '5345', '345', '3455', 354, 534, '534', '', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camionero`
--

CREATE TABLE `camionero` (
  `documento` int(11) NOT NULL,
  `nombre` varchar(11) NOT NULL,
  `apellido` varchar(11) NOT NULL,
  `enServicio` varchar(11) NOT NULL,
  `tipoLibreta` varchar(11) NOT NULL,
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camionero`
--

INSERT INTO `camionero` (`documento`, `nombre`, `apellido`, `enServicio`, `tipoLibreta`, `id`) VALUES
(324, '76', '32432', '0', '0', NULL),
(324, '76', '32432', '0', '0', NULL),
(11, '11', '11', '0', '0', NULL),
(27, '27', '27', '0', '27', NULL),
(278, '278', '278', '0', '278', NULL),
(24325, 'camionero1', 'uno', '', 'D', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `pesoLote` int(30) DEFAULT NULL,
  `fechaIngresoLote` int(30) DEFAULT NULL,
  `destino` varchar(30) DEFAULT NULL,
  `matricula` varchar(30) DEFAULT NULL,
  `idLote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`pesoLote`, `fechaIngresoLote`, `destino`, `matricula`, `idLote`) VALUES
(9, 23, 'montevcideo', '324', 15),
(23, 23, '23', NULL, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `codigo` int(30) NOT NULL,
  `peso` varchar(30) DEFAULT NULL,
  `categoria` varchar(30) DEFAULT NULL,
  `fragil` varchar(30) DEFAULT NULL,
  `calle` varchar(30) NOT NULL,
  `numero` varchar(30) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `departamento` varchar(30) NOT NULL,
  `emailDestino` varchar(30) DEFAULT NULL,
  `telDestino` int(30) NOT NULL,
  `fechaIngreso` int(30) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL,
  `idLote` int(11) DEFAULT NULL,
  `matricula` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`codigo`, `peso`, `categoria`, `fragil`, `calle`, `numero`, `ciudad`, `departamento`, `emailDestino`, `telDestino`, `fechaIngreso`, `estado`, `idLote`, `matricula`) VALUES
(3, '3', '3', 'fragil', 'wwfdsfdssfd', '3', 'fdg', '3', 'yo', 3, 7, NULL, NULL, '3'),
(143424, '2', '3', 'fragil', '324', '342', '423', '4324', '32', 434322, 4324, NULL, NULL, NULL),
(342423, '4324324', '234324', 'fragil', '324', '23', '232', '43243', '43242', 432, 423432, NULL, NULL, NULL),
(3243244, NULL, NULL, NULL, 'masini', '234', 'montevideo', 'montevcideo', NULL, 1545, NULL, NULL, 15, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportista`
--

CREATE TABLE `transportista` (
  `documento` int(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `enServicio` varchar(30) NOT NULL,
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transportista`
--

INSERT INTO `transportista` (`documento`, `nombre`, `apellido`, `enServicio`, `id`) VALUES
(213, '213', '213', 'on', NULL),
(324, '342', '32432', 'on', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(30) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `contraseña` varchar(200) NOT NULL,
  `tipoUsuario` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`, `tipoUsuario`) VALUES
(1, 'administrador', '$2y$10$VpNXJh6BuKQE7mraw7Gll.qUM8NdxjhjN/dVcdSR1EpHG4j9q2HtC', 'administrador'),
(2, 'almacen', '$2y$10$D5ZgniSxUuvKoWiCgUkkwOtt2dv4hFgRkntB1uoJELoaG2Mx/9AgG', 'empAlmacen'),
(3, 'camionero', '$2y$10$PdOpQ/AKhPMwfDoUXZ6cIOZdb24bl929peYzmOOmUnaHjSHFTQw4K', 'camionero'),
(4, '6', '$2y$10$.cTIGojLS5vFpg3oOtaU/.x0yVSTJXsZDg92YblETgoH/PatRJ6jW', 'camionero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculoligero`
--

CREATE TABLE `vehiculoligero` (
  `matricula` varchar(30) NOT NULL,
  `pesoMax` int(30) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculoligero`
--

INSERT INTO `vehiculoligero` (`matricula`, `pesoMax`, `estado`) VALUES
('1', 9999, 'activo'),
('123', 123, 'activo'),
('2', 8, 'activo'),
('3', 8, 'activo'),
('4', 23, 'activo'),
('45645', 45645, 'activo'),
('56', 56, 'incati'),
('565', 6, 'activo'),
('7777666', 7777, 'igdsf'),
('77777', 7777, 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculopesado`
--

CREATE TABLE `vehiculopesado` (
  `matricula` varchar(30) NOT NULL,
  `pesoMax` int(30) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `tipoCamion` varchar(30) NOT NULL,
  `tamanoCaja` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculopesado`
--

INSERT INTO `vehiculopesado` (`matricula`, `pesoMax`, `estado`, `tipoCamion`, `tamanoCaja`) VALUES
('1915', 500, '1', 'b12', '15'),
('23', 7777, '8888', '77777', '34324'),
('324', 324, 'activo', '324', '324'),
('3434', 3244343, 'activo', '43433243', '32443'),
('434343343', 324443, 'activo', '4343', '343'),
('4444', 324443, 'activo', '4343', '343'),
('4545', 4545, 'activo', '45', '5454'),
('6666', 324443, 'activo', '4343', '343'),
('8888', 7777, 'activo', '888', '888'),
('88888', 324443, 'activo', '4343', '343'),
('ASD234', 5, 'activo', '55', '232323');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `camionero`
--
ALTER TABLE `camionero`
  ADD KEY `fk_camionero_usuario` (`id`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`idLote`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `idLote` (`idLote`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `transportista`
--
ALTER TABLE `transportista`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `vehiculoligero`
--
ALTER TABLE `vehiculoligero`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `vehiculopesado`
--
ALTER TABLE `vehiculopesado`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `matricula` (`matricula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `idLote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `camionero`
--
ALTER TABLE `camionero`
  ADD CONSTRAINT `camionero_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_camionero_usuario` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `lotes_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `vehiculopesado` (`matricula`);

--
-- Filtros para la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD CONSTRAINT `paquetes_ibfk_1` FOREIGN KEY (`idLote`) REFERENCES `lotes` (`idLote`),
  ADD CONSTRAINT `paquetes_ibfk_2` FOREIGN KEY (`matricula`) REFERENCES `vehiculoligero` (`matricula`);

--
-- Filtros para la tabla `transportista`
--
ALTER TABLE `transportista`
  ADD CONSTRAINT `transportista_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
