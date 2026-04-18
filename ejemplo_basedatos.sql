-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-04-2026 a las 15:36:24
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_clase`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE IF NOT EXISTS `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `platform` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `games`
--

INSERT INTO `games` (`id`, `name`, `genre`, `platform`) VALUES
(1, 'Resident Evil 4', 'Terror', 'PC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(2, 'Eliminar usuarios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permiso_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournaments`
--

DROP TABLE IF EXISTS `tournaments`;
CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `game_id` int NOT NULL,
  `organizer_id` int NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `prize` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_game` (`game_id`),
  KEY `fk_user` (`organizer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tournaments`
--

INSERT INTO `tournaments` (`id`, `name`, `game_id`, `organizer_id`, `start_date`, `end_date`, `prize`) VALUES
(3, 'Torneo FIFA', 1, 4, '2026-05-01', '2026-05-03', 500000.00),
(4, 'Summer Cup', 1, 4, '2026-01-10', '2026-01-20', NULL),
(5, 'Summer Cup', 1, 4, '2026-01-10', '2026-01-20', 500000.00),
(6, 'Free fires Cup', 1, 4, '2026-01-10', '2026-01-30', 600000.00),
(7, 'Free fire Cup', 1, 4, '2026-01-10', '2026-01-20', 500000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournament_players`
--

DROP TABLE IF EXISTS `tournament_players`;
CREATE TABLE IF NOT EXISTS `tournament_players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tournament_id` int NOT NULL,
  `player_id` int NOT NULL,
  `registration_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tournament` (`tournament_id`),
  KEY `fk_player` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tournament_players`
--

INSERT INTO `tournament_players` (`id`, `tournament_id`, `player_id`, `registration_date`) VALUES
(4, 5, 4, '2026-04-17'),
(5, 5, 4, '2026-04-17'),
(6, 5, 4, '2026-04-17'),
(7, 5, 4, '2026-04-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`) VALUES
(4, 'Favierd', 'darioj99@gmail.com', '$2y$10$hJNeNfoP.lQ0yhxcsk0a2u9iZSe0rsGTEfgbb5AFzwKwukXXTa1IS', 1),
(5, 'Juan Pérez', 'dariojav99@gmail.com', '$2y$10$vDLE3OGY5OOpV1swy.y/j.WYQtKs41n33M/eHwe.H/yWtcP2AEFgO', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `fk_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `tournament_players`
--
ALTER TABLE `tournament_players`
  ADD CONSTRAINT `fk_player` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_tournament` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
