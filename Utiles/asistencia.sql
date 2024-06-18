-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:4040
-- Tiempo de generación: 18-06-2024 a las 22:33:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `ID_EMP` int(11) NOT NULL,
  `CED_EMP` varchar(20) NOT NULL,
  `PASS_EMP` varchar(45) NOT NULL,
  `NOM_EMP` varchar(25) DEFAULT NULL,
  `APE_EMP` varchar(25) DEFAULT NULL,
  `CORR_EMP` varchar(50) DEFAULT NULL,
  `EST_EMP` tinyint(4) DEFAULT 0,
  `ROL_EMP` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`ID_EMP`, `CED_EMP`, `PASS_EMP`, `NOM_EMP`, `APE_EMP`, `CORR_EMP`, `EST_EMP`, `ROL_EMP`) VALUES
(1, '1801', '1801', 'JOEL_M', 'DURAN', 'jduran4532@uta.edu.ec', 1, 'ADMIN'),
(2, '1802', '1802', 'ANGELA', 'ARMIJOS', 'aarmijos2104@uta.edu.ec', 0, 'DOCENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `ID_HOR` int(11) NOT NULL,
  `ENTRADA` time DEFAULT NULL,
  `SALIDA` time DEFAULT NULL,
  `JORNADA` varchar(45) DEFAULT NULL,
  `ID_EMP_PER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`ID_HOR`, `ENTRADA`, `SALIDA`, `JORNADA`, `ID_EMP_PER`) VALUES
(1, '08:00:00', '13:00:00', 'MATUTINA', 1),
(2, '17:00:00', '20:00:00', 'VISPERTINO', 1),
(3, '11:00:00', '13:00:00', 'MATUTINA', 2),
(4, '14:00:00', '20:00:00', 'VISPERTINA', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_asistencia`
--

CREATE TABLE `registro_asistencia` (
  `ID_REG` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `JORNADA` varchar(20) DEFAULT NULL,
  `HORA_INGRESO` time DEFAULT NULL,
  `HORA_SALIDA` time DEFAULT NULL,
  `DESCUENTO` decimal(10,2) DEFAULT 0.00,
  `HORAS_POR_JORNADA` time DEFAULT '00:00:00',
  `SUBTOTAL_JORNADA` decimal(10,2) DEFAULT 0.00,
  `ID_EMP_PER` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`ID_EMP`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`ID_HOR`),
  ADD KEY `FK_EMP_HOR_idx` (`ID_EMP_PER`);

--
-- Indices de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  ADD PRIMARY KEY (`ID_REG`),
  ADD KEY `FK_EMP_REG_idx` (`ID_EMP_PER`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `ID_EMP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `ID_HOR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  MODIFY `ID_REG` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `FK_EMP_HOR` FOREIGN KEY (`ID_EMP_PER`) REFERENCES `empleados` (`ID_EMP`);

--
-- Filtros para la tabla `registro_asistencia`
--
ALTER TABLE `registro_asistencia`
  ADD CONSTRAINT `FK_EMP_REG` FOREIGN KEY (`ID_EMP_PER`) REFERENCES `empleados` (`ID_EMP`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
