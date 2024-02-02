-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-02-2024 a las 03:30:25
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
-- Base de datos: `redesunity`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `player`
--

CREATE TABLE `player` (
  `playerId` bigint(20) NOT NULL,
  `playerName` text NOT NULL,
  `playerExp` int(11) NOT NULL,
  `playerEdad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `player`
--

INSERT INTO `player` (`playerId`, `playerName`, `playerExp`, `playerEdad`) VALUES
(1, 'Gustavo', -20, 48),
(2, 'Rondamon', 5000, 55),
(3, 'ramon', 584, 26),
(4, 'Estravagancia', 124, 36);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`playerId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `player`
--
ALTER TABLE `player`
  MODIFY `playerId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
