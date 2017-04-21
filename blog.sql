-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-04-2017 a las 15:17:59
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `blog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Desarrollo Web 2', 'Categoria de desarrollo web 2'),
(2, 'Desarrollo Android', 'Categoria de desarrollo android'),
(5, 'Business Intelligence', 'este es un ejemplo'),
(6, 'Administación', 'esto es un ejemplo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entries`
--

CREATE TABLE `entries` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `category_id` int(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `status` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entries`
--

INSERT INTO `entries` (`id`, `user_id`, `category_id`, `title`, `content`, `status`, `image`) VALUES
(7, 1, 2, 'Esto es un titulo 3 editado', 'contenido editado', 'private', '1492030905.jpeg'),
(8, 1, 2, 'Esto es un titulo 4', 'contenido 4', 'private', '1491514229.jpeg'),
(9, 1, 2, 'Esto es un titulo 5', 'contenido 5', 'public', '1491516340.jpeg'),
(10, 1, 2, 'Esto es un titulo 6', 'contenido', 'public', '1492033895.jpeg'),
(11, 1, 6, 'Esto es un titulo 7', 'contenido', 'public', '1492033945.jpeg'),
(12, 1, 2, 'Esto es un titulo 8', 'contenido', 'public', '1492033979.jpeg'),
(13, 1, 5, 'Esto es un titulo 9', 'contenido', 'private', '1492034298.jpeg'),
(14, 1, 1, 'Esto es un titulo 10', 'contenido', 'private', '1492034396.jpeg'),
(15, 1, 2, 'Esto es un titulo cambiado 11', 'contenido cambiado', 'private', '1492461190.jpeg'),
(16, 1, 6, 'Esto es un titulo 12', 'contenido', 'private', '1492036955.jpeg'),
(17, 1, 5, 'Esto es un titulo 13', 'contenido', 'public', '1492036991.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entry_tag`
--

CREATE TABLE `entry_tag` (
  `id` int(255) NOT NULL,
  `entry_id` int(255) NOT NULL,
  `tag_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entry_tag`
--

INSERT INTO `entry_tag` (`id`, `entry_id`, `tag_id`) VALUES
(7, 8, 1),
(8, 8, 8),
(9, 8, 9),
(10, 8, 10),
(11, 9, 1),
(12, 9, 8),
(13, 9, 9),
(14, 9, 10),
(24, 7, 11),
(25, 7, 12),
(26, 7, 8),
(27, 7, 13),
(28, 10, 1),
(29, 10, 8),
(30, 10, 9),
(31, 10, 10),
(32, 11, 1),
(33, 11, 8),
(34, 11, 9),
(35, 11, 10),
(36, 12, 1),
(37, 12, 8),
(38, 13, 1),
(39, 13, 8),
(40, 14, 1),
(41, 14, 8),
(43, 16, 1),
(44, 17, 1),
(46, 15, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE `tags` (
  `id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `name`, `description`) VALUES
(1, 'php ', 'php tag'),
(2, 'symfony', 'symfony tag'),
(3, 'html', 'html tag'),
(4, 'zend framework 2', 'apuntate al curso de zend framework 2'),
(5, 'Django', 'Framework Python'),
(7, 'code igniter', 'framework php'),
(8, ' html', ' html'),
(9, ' symfony', ' symfony'),
(10, ' css', ' css'),
(11, 'javascript', 'javascript'),
(12, ' php', ' php'),
(13, ' zend framework 1', ' zend framework 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `surname`, `email`, `password`, `imagen`) VALUES
(1, 'ROLE_ADMIN', 'diego', 'abanto', 'dabanto@gmail.com', '$2a$04$BmneWv37pHlnzv6UmTUGuOgD7DHBgDcaaxmpfdqciTPzxMKI2SEWa', NULL),
(2, 'ROLE_USER', 'luis', 'abanto', 'labanto@gmail.com', '$2a$04$PFyHxwvrGXILOuUAukzO9ev3AtaItX/TGVNbWX7Mae7m8Nvzkln5W', NULL),
(3, 'ROLE_USER', 'David', 'Abanto', 'david.abanto@gmail.com', 'user', NULL),
(4, 'ROLE_USER', 'Luis Gabriel', 'Arroyo', 'lgabanto@gmail.com', 'user', NULL),
(6, 'ROLE_USER', 'Eduardo Isidro', 'Arroyo', 'earroyo@gmail.com', '$2y$04$0lQasI0lB6Cu0BrqC9STNe0O8IqLv2Bt1xaAx79FQ6EgQQzFYe20G', NULL),
(7, 'ROLE_USER', 'Diego Enrique', 'Abanto', 'dabanto21@gmail.com', '$2y$04$N28/faq7Hjw8elHyRrcaZu2B5E4DCOwT4I9B6e5t0MN6Oamzj1ICy', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_entries_users` (`user_id`),
  ADD KEY `pk_entries_categories` (`category_id`);

--
-- Indices de la tabla `entry_tag`
--
ALTER TABLE `entry_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_entry_tag_entries` (`entry_id`),
  ADD KEY `pk_entry_tag_tags` (`tag_id`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `entry_tag`
--
ALTER TABLE `entry_tag`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `pk_entries_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `pk_entries_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `entry_tag`
--
ALTER TABLE `entry_tag`
  ADD CONSTRAINT `pk_entry_tag_entries` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`),
  ADD CONSTRAINT `pk_entry_tag_tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
