-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2020 a las 04:08:16
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas_php`
--
CREATE DATABASE IF NOT EXISTS `ventas_php` DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE `ventas_php`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `NombreCategoria` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `NombreCategoria`) VALUES
(1, 'Bedidas'),
(2, 'Cereal'),
(3, 'Verduras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `DUI` char(10) COLLATE latin1_spanish_ci NOT NULL,
  `NIT` char(17) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre_Completo` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `Telefono` char(9) COLLATE latin1_spanish_ci NOT NULL,
  `Observaciones` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `idCredito` int(11) DEFAULT NULL,
  `Ventas_Totales` float DEFAULT NULL,
  `Pagos_Totales` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `DUI`, `NIT`, `Nombre_Completo`, `Telefono`, `Observaciones`, `idCredito`, `Ventas_Totales`, `Pagos_Totales`) VALUES
(1, '80328263-7', '9760-387489-802-2', 'Marah Kramer', '7056-6084', NULL, 2, NULL, NULL),
(2, '12345677-9', '1234-567898-765-4', 'Michelle Giron', '9876-5432', NULL, NULL, NULL, NULL),
(26, '98765432-1', '9876-543212-345-6', 'Alex Castillo', '6547-1238', NULL, 3, NULL, NULL),
(27, '32132489-7', '3122-315674-897-9', 'Hayde Cuarezma', '6489-7498', NULL, NULL, NULL, NULL),
(29, '97889789-7', '6545-644564-564-5', 'Cynthia Swanson', '6321-2315', NULL, NULL, NULL, NULL),
(30, '98749646-3', '9789-464567-487-4', 'Juan Perez', '7651-3114', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos`
--

CREATE TABLE `creditos` (
  `idCreditos` int(11) NOT NULL,
  `Saldo_Actual` float NOT NULL,
  `Dias_Credito` int(11) NOT NULL,
  `SAFPD` float NOT NULL,
  `CuotaMensual` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `creditos`
--

INSERT INTO `creditos` (`idCreditos`, `Saldo_Actual`, `Dias_Credito`, `SAFPD`, `CuotaMensual`) VALUES
(1, 1000, 360, 0, 120),
(2, 875.6, 12, 0, 50),
(3, 386.22, 300, 0, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pf`
--

CREATE TABLE `detalles_pf` (
  `idDetallePF` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `detalles_pf`
--

INSERT INTO `detalles_pf` (`idDetallePF`, `idFactura`, `idProducto`, `Cantidad`, `Precio`) VALUES
(1, 1, 2, 1, 1.85),
(23, 2, 2, 5, 9.25),
(24, 2, 3, 3, 4.5),
(25, 3, 2, 10, 18.5),
(26, 3, 3, 3, 4.5),
(27, 4, 2, 10, 18.5),
(28, 4, 3, 5, 7.5),
(29, 5, 2, 10, 18.5),
(30, 5, 3, 5, 7.5),
(31, 6, 2, 10, 18.5),
(32, 7, 2, 1, 1.85),
(33, 7, 3, 3, 4.5),
(34, 8, 2, 2, 3.7),
(35, 8, 3, 1, 1.5),
(36, 9, 3, 5, 7.5),
(37, 10, 2, 5, 9.25),
(38, 10, 3, 3, 4.5),
(39, 11, 2, 2, 3.7),
(40, 12, 2, 2, 3.7),
(41, 13, 3, 3, 4.5),
(44, 14, 2, 2, 3.7),
(45, 14, 3, 1, 1.5),
(46, 15, 2, 2, 3.7),
(47, 15, 3, 3, 4.5),
(48, 16, 2, 7, 12.95),
(49, 17, 2, 10, 18.5),
(50, 17, 3, 10, 15),
(51, 18, 2, 5, 9.25);

--
-- Disparadores `detalles_pf`
--
DELIMITER $$
CREATE TRIGGER `aumentar_stock` AFTER DELETE ON `detalles_pf` FOR EACH ROW BEGIN
DECLARE cant INT;
SET cant = old.Cantidad;
UPDATE productos SET `Stock`= Stock + cant
WHERE idProducto = old.idProducto;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `disminuir_stock` AFTER INSERT ON `detalles_pf` FOR EACH ROW BEGIN
DECLARE cant INT;
SET cant = new.Cantidad;
UPDATE productos SET `Stock`= Stock - cant
WHERE idProducto = new.idProducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `idEmpleado` int(11) NOT NULL,
  `DUI` char(10) COLLATE latin1_spanish_ci NOT NULL,
  `NIT` char(17) COLLATE latin1_spanish_ci NOT NULL,
  `Nombre` varchar(90) COLLATE latin1_spanish_ci NOT NULL,
  `Apellido` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Direccion` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `Telefono` char(9) COLLATE latin1_spanish_ci NOT NULL,
  `Observaciones` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`idEmpleado`, `DUI`, `NIT`, `Nombre`, `Apellido`, `Direccion`, `Telefono`, `Observaciones`, `idRol`) VALUES
(1, '04782353-8', '0614-140393-145-9', 'Pedro Antonio', 'Mendoza Ramirez', 'Soyapango, San Salvador', '7730-1602', '', 1),
(2, '27838819-3', '3307-302809-695-2', 'Lucia', 'Fernandez', 'Alameda Lorem ipsum dolor sit, 137B', '2979-2435', '', 2),
(3, '36184926-5', '6258-331192-794-2', 'Holmes', 'Weaver', '976-6119 Suspendisse Avda.', '7876-0528', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFactura` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idTPago` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Total_Pago` float NOT NULL,
  `idModoPago` int(11) DEFAULT NULL,
  `idTarjeta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`idFactura`, `idCliente`, `idTPago`, `idEmpleado`, `Fecha`, `Total_Pago`, `idModoPago`, `idTarjeta`) VALUES
(1, 1, 2, 3, '2020-02-24', 2.09, 1, NULL),
(2, 2, 2, 1, '2020-03-08', 15.54, 2, 1),
(3, 1, 1, 3, '2020-03-08', 22.28, NULL, NULL),
(4, 26, 1, 3, '2020-03-12', 556.89, NULL, NULL),
(5, 2, 2, 3, '2020-03-12', 29.38, 1, NULL),
(6, 2, 2, 3, '2020-03-12', 20.91, 1, NULL),
(7, 26, 2, 1, '2020-03-14', 7.18, 1, NULL),
(8, 1, 2, 1, '2020-03-14', 5.88, 2, 1),
(9, 26, 1, 1, '2020-03-14', 556.89, NULL, NULL),
(10, 26, 2, 1, '2020-03-20', 15.54, 1, NULL),
(11, 2, 2, 3, '2020-03-20', 4.18, 1, NULL),
(12, 2, 2, 1, '2020-03-23', 4.18, 1, NULL),
(13, 1, 1, 1, '2020-03-23', 22.28, NULL, NULL),
(14, 2, 2, 3, '2020-03-26', 5.88, 1, NULL),
(15, 29, 2, 1, '2020-04-04', 9.27, 1, NULL),
(16, 30, 2, 3, '2020-05-08', 14.63, 1, NULL),
(17, 1, 1, 1, '2020-05-08', 22.28, NULL, NULL),
(18, 30, 2, 1, '2020-05-08', 10.45, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modopago`
--

CREATE TABLE `modopago` (
  `idModoPago` int(11) NOT NULL,
  `nombre_pago` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `modopago`
--

INSERT INTO `modopago` (`idModoPago`, `nombre_pago`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `CodigoProducto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `NombreProducto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `PCF` float NOT NULL,
  `CosteFlete` float NOT NULL,
  `OtrosCostos` float NOT NULL,
  `PrecioVenta` float NOT NULL,
  `PrecioPublico` float NOT NULL,
  `Stock` int(11) NOT NULL,
  `Descripcion` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `CodigoProducto`, `NombreProducto`, `PCF`, `CosteFlete`, `OtrosCostos`, `PrecioVenta`, `PrecioPublico`, `Stock`, `Descripcion`, `idCategoria`) VALUES
(2, '978020137962', 'Coca-Cola 3L', 3, 3, 3, 1.5, 1.85, 7, 'Coca Cola 3 Litros', 1),
(3, '987946541321', 'Lechuga Romana', 5, 5, 5, 1.25, 1.5, 36, 'Lechuga Romana hecha en Roma desde Roma', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) NOT NULL,
  `NombreRol` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRoles`, `NombreRol`) VALUES
(1, 'Cajero'),
(2, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

CREATE TABLE `tarjetas` (
  `idTarjetas` int(11) NOT NULL,
  `NombreTarjetas` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Comision` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tarjetas`
--

INSERT INTO `tarjetas` (`idTarjetas`, `NombreTarjetas`, `Comision`) VALUES
(1, 'Visa', 2),
(2, 'Mastercard', 5),
(3, 'American Express', 4),
(4, 'Discover', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopago`
--

CREATE TABLE `tipopago` (
  `idTipoPago` int(11) NOT NULL,
  `NombreTipoPago` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tipopago`
--

INSERT INTO `tipopago` (`idTipoPago`, `NombreTipoPago`) VALUES
(1, 'Credito'),
(2, 'Contado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `idEmpleado`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pedrux', 'pdrmendoza007@gmail.com', NULL, '$2y$10$qyvP5TaPi9XW15wiawDFjeYBcr4a0hoA1lcb2GAfmuSPxFOt8AmS.', 1, NULL, '2020-02-18 04:54:17', '2020-02-18 04:54:17'),
(2, 'Lucia', 'lucia.fernandez@gmail.com', NULL, '$2y$10$WVjV/icT8s9XJZafPmaqJeJrYcqqNASmQ45EjNuNaE4dV4hRiCrK.', 2, NULL, NULL, NULL),
(3, 'Holmes', 'holmes.weaver@gmail.com', NULL, '$2y$10$qyvP5TaPi9XW15wiawDFjeYBcr4a0hoA1lcb2GAfmuSPxFOt8AmS.', 3, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `DUI` (`DUI`),
  ADD UNIQUE KEY `NIT` (`NIT`),
  ADD KEY `cliente_credito` (`idCredito`);

--
-- Indices de la tabla `creditos`
--
ALTER TABLE `creditos`
  ADD PRIMARY KEY (`idCreditos`);

--
-- Indices de la tabla `detalles_pf`
--
ALTER TABLE `detalles_pf`
  ADD PRIMARY KEY (`idDetallePF`),
  ADD KEY `DPF_1` (`idFactura`),
  ADD KEY `DPF_2` (`idProducto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD UNIQUE KEY `DUI` (`DUI`,`NIT`),
  ADD KEY `empleados_roles` (`idRol`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFactura`),
  ADD KEY `factura_cliente` (`idCliente`),
  ADD KEY `factura_tipo_pago` (`idTPago`),
  ADD KEY `factura_empleado` (`idEmpleado`),
  ADD KEY `factura_modo_pago` (`idModoPago`),
  ADD KEY `factura_tarjeta` (`idTarjeta`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modopago`
--
ALTER TABLE `modopago`
  ADD PRIMARY KEY (`idModoPago`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `CodigoProducto` (`CodigoProducto`),
  ADD KEY `producto_categoria` (`idCategoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD PRIMARY KEY (`idTarjetas`);

--
-- Indices de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`idTipoPago`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_empleados` (`idEmpleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `creditos`
--
ALTER TABLE `creditos`
  MODIFY `idCreditos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalles_pf`
--
ALTER TABLE `detalles_pf`
  MODIFY `idDetallePF` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modopago`
--
ALTER TABLE `modopago`
  MODIFY `idModoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  MODIFY `idTarjetas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `idTipoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `cliente_credito` FOREIGN KEY (`idCredito`) REFERENCES `creditos` (`idCreditos`);

--
-- Filtros para la tabla `detalles_pf`
--
ALTER TABLE `detalles_pf`
  ADD CONSTRAINT `DPF_1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`),
  ADD CONSTRAINT `DPF_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_roles` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRoles`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_cliente` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `factura_empleado` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`),
  ADD CONSTRAINT `factura_modo_pago` FOREIGN KEY (`idModoPago`) REFERENCES `modopago` (`idModoPago`),
  ADD CONSTRAINT `factura_tarjeta` FOREIGN KEY (`idTarjeta`) REFERENCES `tarjetas` (`idTarjetas`),
  ADD CONSTRAINT `factura_tipo_pago` FOREIGN KEY (`idTPago`) REFERENCES `tipopago` (`idTipoPago`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `producto_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `usuario_empleados` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
