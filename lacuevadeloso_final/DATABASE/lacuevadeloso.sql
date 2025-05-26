-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-05-2025 a las 23:18:17
-- Versión del servidor: 8.0.42
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lacuevadeloso`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colecciones`
--

CREATE TABLE `colecciones` (
  `id` int NOT NULL,
  `coleccion_nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `colecciones`
--

INSERT INTO `colecciones` (`id`, `coleccion_nombre`) VALUES
(1, 'Verano'),
(2, 'Invierno'),
(3, 'Otoño'),
(4, 'Primavera'),
(7, 'WINTER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` int NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `nombre`) VALUES
(3, 'verde'),
(24, 'gris'),
(26, 'rosa'),
(28, 'amarillo'),
(29, 'azul');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int NOT NULL,
  `id_pedido` int NOT NULL,
  `id_prenda` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS ((`cantidad` * `precio_unitario`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_prenda`, `cantidad`, `precio_unitario`) VALUES
(25, 16, 34, 1, 800.00),
(26, 16, 33, 1, 900.00),
(27, 17, 33, 1, 900.00),
(28, 17, 34, 2, 800.00),
(29, 18, 33, 2, 900.00),
(30, 18, 34, 3, 800.00),
(31, 19, 33, 5, 900.00),
(32, 19, 34, 4, 800.00),
(33, 20, 33, 3, 900.00),
(34, 21, 33, 1, 900.00),
(35, 21, 38, 1, 900.00),
(36, 21, 34, 1, 800.00),
(37, 22, 33, 4, 900.00),
(38, 22, 34, 1, 800.00),
(39, 22, 38, 1, 900.00),
(40, 23, 33, 1, 900.00),
(41, 24, 33, 1, 900.00),
(42, 24, 34, 1, 800.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion_envio`
--

CREATE TABLE `direccion_envio` (
  `id_direccion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `especificaciones` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `direccion_envio`
--

INSERT INTO `direccion_envio` (`id_direccion`, `id_usuario`, `direccion`, `especificaciones`) VALUES
(26, 6, 'rfrgt', 'r4rgtrgt'),
(27, 13, 'En mi casa', 'hola'),
(28, 6, 'EN FIME', 'edificio 3'),
(29, 4, 'ferf', 'frewferf'),
(30, 4, 'de', 'de'),
(31, 4, 'e3e3e', '3e3e3e'),
(32, 4, 'ede', 'dde'),
(33, 4, 'e', 'e'),
(34, 4, 'fff', 'fff');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id` int NOT NULL,
  `genero` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `genero`) VALUES
(1, 'Hombre'),
(2, 'Mujer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_prenda`
--

CREATE TABLE `imagenes_prenda` (
  `id` int NOT NULL,
  `prenda_id` int NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `tipo` enum('principal','complementaria') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `imagenes_prenda`
--

INSERT INTO `imagenes_prenda` (`id`, `prenda_id`, `ruta_imagen`, `tipo`) VALUES
(33, 33, 'IMG_PRENDAS/683346c24d510_blusa_verde.jpg', 'principal'),
(34, 34, 'IMG_PRENDAS/6833474ceb533_pantalon_gris.jpg', 'principal'),
(35, 34, 'IMG_PRENDAS/6833474ceb533_pantalon_gris.jpg.jpg', 'complementaria'),
(43, 38, 'IMG_PRENDAS/chaqueta_negro.jpg', 'principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_pago`
--

CREATE TABLE `medio_pago` (
  `id_medio_pago` int NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `medio_pago`
--

INSERT INTO `medio_pago` (`id_medio_pago`, `descripcion`) VALUES
(1, 'VISA'),
(2, 'MASTERCARD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_pedido` decimal(10,2) NOT NULL,
  `id_direccion` int DEFAULT NULL,
  `id_medio_pago` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `fecha_pedido`, `total_pedido`, `id_direccion`, `id_medio_pago`) VALUES
(16, 6, '2025-05-26 07:37:35', 1700.00, 26, 2),
(17, 13, '2025-05-26 09:44:11', 2500.00, 27, 2),
(18, 6, '2025-05-26 09:53:58', 4200.00, 28, 2),
(19, 4, '2025-05-26 10:45:06', 7700.00, 29, 1),
(20, 4, '2025-05-26 10:47:33', 2700.00, 30, 1),
(21, 4, '2025-05-26 14:35:15', 2600.00, 31, 2),
(22, 4, '2025-05-26 15:42:51', 5300.00, 32, 1),
(23, 4, '2025-05-26 15:45:35', 900.00, 33, 1),
(24, 4, '2025-05-26 15:50:06', 1700.00, 34, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas`
--

CREATE TABLE `prendas` (
  `id` int NOT NULL,
  `nombre_prenda` varchar(100) NOT NULL,
  `costo_produccion` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `tipo_prenda_id` int DEFAULT NULL,
  `color_id` int DEFAULT NULL,
  `talla_id` int DEFAULT NULL,
  `genero_id` int DEFAULT NULL,
  `coleccion_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `prendas`
--

INSERT INTO `prendas` (`id`, `nombre_prenda`, `costo_produccion`, `precio_venta`, `tipo_prenda_id`, `color_id`, `talla_id`, `genero_id`, `coleccion_id`) VALUES
(33, 'blusa verde', 200.00, 900.00, 1, 3, 2, 2, 1),
(34, 'Pantalon azul', 200.00, 800.00, 2, 26, 3, 1, 3),
(38, 'chaqueta negra', 100.00, 900.00, 1, 24, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int NOT NULL,
  `rol` varchar(100) NOT NULL,
  `usuario_id` int DEFAULT NULL,
  `roles_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'administrador'),
(2, 'usuario'),
(3, 'dueño');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int NOT NULL,
  `nombre` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `nombre`) VALUES
(1, 'G'),
(2, 'Ch'),
(3, 'EG'),
(4, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_prenda`
--

CREATE TABLE `tipos_prenda` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipos_prenda`
--

INSERT INTO `tipos_prenda` (`id`, `nombre`) VALUES
(1, 'parte superior'),
(2, 'parte inferior');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nombre_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `contra_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nacimiento_usuario` date NOT NULL,
  `rolusuario_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre_usuario`, `contra_usuario`, `email_usuario`, `nacimiento_usuario`, `rolusuario_id`) VALUES
(1, 'Emiliano', '$2y$10$9f/ajOk2k61itOhTGKoZGOpLtCnsWatOPX439FYK3.CPXgYZn//FS', 'emifrufuyr@gmail.com', '2000-03-02', 1),
(4, 'Raul', '$2y$10$n80HioJAwFI/N12WmtIJkexkYnrR2yP2w6lxLnybF4s5XUTvcqF/6', 'raulito@gmail.com', '1990-12-12', 2),
(5, 'Daniela', '$2y$10$.gO/1FsCEd/fiDmvRLjfNOMn3Ih6aOyaTBhk9ppqQKtZmTDN.JCIO', 'daniamormivida@gmail.com', '2006-01-29', 1),
(6, 'LUIS LEPE', '$2y$10$6aqzU2f3YxyC2rfvczBWe.f9AIHjDlJYLDFPaSlwTEXEUXSX0RaS6', 'luislepe@gmail.com', '2000-12-12', 1),
(7, 'Emiliano Montalvo', '$2y$10$31uxn.Rb3NHLO2Ftwxhut.iXhq8z6FQgN4WsGLg3L/.ZcaT/S8LJm', 'emilianomt780@gmail.com', '2006-02-03', 3),
(8, 'Emi Torres', '$2y$10$lis0oFn8bRBKE6shN4IR7e8PG.YleFUQjo3UKnbtxNrs.f4TNUTya', 'emi670@gmail.com', '2006-02-02', 2),
(9, 'Pablo', '$2y$10$cRMRlyLWpRWXf2omtByKFeDqMWUbTdWyYRbnlvYi5xxronhSOJ6Gq', 'pabloisa@gmail.com', '1990-06-22', 2),
(10, 'danielita', '$2y$10$f6CWlsI3Acz/OP3VaARChu7BqhpoRk7mXqsOTMNCyHCYMZTobqaAu', 'daniii@gmail.com', '2000-11-11', 2),
(11, 'Pablo', '$2y$10$Y4j6E4BOA55vk6qsqz8ykeYu.M8ozU/3mtMldw9sBwQE/Ui5C/rgG', 'pabloisa@gmail.com', '2000-11-11', 2),
(12, 'Pablo Isais', '$2y$10$6g2XjX3dhOnwXgpEAj05QODRH2xNwKBupxZSGn09YgGDlneM/ixWC', 'variablesalaizquierda@gmail.com', '1974-08-10', 2),
(13, 'Mateo', '$2y$10$rX7soTp9SvSdyErTQml7v.KEnzua5GFMbkjjeyw6iVa7j8lBG26CO', 'mateo@gmail.com', '2000-11-12', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `colecciones`
--
ALTER TABLE `colecciones`
  ADD UNIQUE KEY `colecciones` (`id`) USING BTREE;

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_prenda` (`id_prenda`);

--
-- Indices de la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `imagenes_prenda`
--
ALTER TABLE `imagenes_prenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prenda_id` (`prenda_id`);

--
-- Indices de la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  ADD PRIMARY KEY (`id_medio_pago`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_direccion` (`id_direccion`),
  ADD KEY `id_medio_pago` (`id_medio_pago`);

--
-- Indices de la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_prenda_id` (`tipo_prenda_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `talla_id` (`talla_id`),
  ADD KEY `coleccion_id` (`coleccion_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `roles_id` (`roles_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_prenda`
--
ALTER TABLE `tipos_prenda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rolusuario_id` (`rolusuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `colecciones`
--
ALTER TABLE `colecciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  MODIFY `id_direccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `imagenes_prenda`
--
ALTER TABLE `imagenes_prenda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `medio_pago`
--
ALTER TABLE `medio_pago`
  MODIFY `id_medio_pago` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `prendas`
--
ALTER TABLE `prendas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipos_prenda`
--
ALTER TABLE `tipos_prenda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_prenda`) REFERENCES `prendas` (`id`);

--
-- Filtros para la tabla `direccion_envio`
--
ALTER TABLE `direccion_envio`
  ADD CONSTRAINT `direccion_envio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `imagenes_prenda`
--
ALTER TABLE `imagenes_prenda`
  ADD CONSTRAINT `imagenes_prenda_ibfk_1` FOREIGN KEY (`prenda_id`) REFERENCES `prendas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_direccion`) REFERENCES `direccion_envio` (`id_direccion`),
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`id_medio_pago`) REFERENCES `medio_pago` (`id_medio_pago`);

--
-- Filtros para la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD CONSTRAINT `prendas_ibfk_1` FOREIGN KEY (`tipo_prenda_id`) REFERENCES `tipos_prenda` (`id`),
  ADD CONSTRAINT `prendas_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`),
  ADD CONSTRAINT `prendas_ibfk_3` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`),
  ADD CONSTRAINT `prendas_ibfk_4` FOREIGN KEY (`coleccion_id`) REFERENCES `colecciones` (`id`),
  ADD CONSTRAINT `prendas_ibfk_5` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`id`);

--
-- Filtros para la tabla `rol`
--
ALTER TABLE `rol`
  ADD CONSTRAINT `rol_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `rol_ibfk_2` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rolusuario_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
