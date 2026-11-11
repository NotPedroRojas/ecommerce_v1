-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2026 a las 19:54:50
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
-- Base de datos: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `idCarrito` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `identificadorSesion` varchar(128) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritos`
--

INSERT INTO `carritos` (`idCarrito`, `idUsuario`, `identificadorSesion`, `fechaCreacion`) VALUES
(31, 6, NULL, '2026-11-10 10:12:40'),
(40, 5, NULL, '2026-11-11 15:38:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `idCategoriaPadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nombre`, `idCategoriaPadre`) VALUES
(1, 'Componentes de PC', NULL),
(2, 'Periféricos', NULL),
(3, 'Monitores', NULL),
(4, 'Accesorios', NULL),
(5, 'Procesadores', 1),
(6, 'Placas de video', 1),
(7, 'Placas madre', 1),
(8, 'Memorias RAM', 1),
(9, 'Almacenamiento', 1),
(10, 'Fuentes de alimentación', 1),
(11, 'Gabinetes', 1),
(12, 'Teclados', 2),
(13, 'Mouse', 2),
(14, 'Auriculares', 2),
(15, 'Micrófonos', 2),
(16, 'Cámaras web', 2),
(17, 'Joysticks y controles', 2),
(18, 'Monitores gaming', 3),
(19, 'Monitores de oficina', 3),
(20, 'Mousepads', 4),
(21, 'Hubs USB', 4),
(22, 'Cables y adaptadores', 4),
(23, 'Soportes', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `idDireccion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `pisoDepto` varchar(50) DEFAULT NULL,
  `localidad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `codigoPostal` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `idItems` int(11) NOT NULL,
  `idVenta` int(11) NOT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `nombreProducto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_carrito`
--

CREATE TABLE `items_carrito` (
  `idItemCarrito` int(11) NOT NULL,
  `idCarrito` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombre`, `codigo`, `idCategoria`, `descripcion`, `costo`, `precio`, `foto`, `idProveedor`, `stock`) VALUES
(1, 'Teclado Logitech G Pro X TKL LIGHTSPEED', 'LOGI-GPROX-TKL', 12, 'Teclado mecanico inalambrico para gaming.', 30000.00, 45000.00, 'logitech-gpro-x-tkl.jpg', 1, 15),
(2, 'Mouse Logitech G305 LIGHTSPEED', 'LOGI-G305', 13, 'Mouse inalambrico para gaming con sensor HERO.', 15000.00, 25000.00, 'logitech-g305.jpg', 1, 23),
(3, 'Auriculares HyperX Cloud III', 'HYP-CLOUD-III', 14, 'Auriculares gaming con microfono y sonido envolvente.', 22000.00, 35000.00, 'hyperx-cloud-iii.jpg', 2, 4),
(4, 'Monitor Samsung Odyssey G5 27 pulgadas', 'SAMS-ODYSSEY-G5', 18, 'Monitor gaming de 27 pulgadas de la serie Odyssey G5.', 120000.00, 180000.00, 'samsung-odyssey-g5.jpg', 3, 8),
(5, 'Placa de video ASRock Intel Arc B580 Challenger 12GB OC', 'ASROCK-ARC-B580', 6, 'Placa de video Intel Arc B580 con 12 GB de memoria GDDR6.', 250000.00, 320000.00, 'asrock-arc-b580.jpg', 2, 5),
(6, 'Procesador AMD Ryzen 5 5600', 'PROC-001', 5, 'Procesador AMD Ryzen 5 5600 de 6 nucleos y 12 hilos, socket AM4.', 150000.00, 185000.00, 'amd-ryzen-5-5600.jpg', 1, 10),
(7, 'Placa de video NVIDIA GeForce RTX 4060 8GB', 'GPU-001', 6, 'Placa de video NVIDIA GeForce RTX 4060 con 8GB de memoria GDDR6.', 490000.00, 580000.00, 'nvidia-rtx-4060.jpg', 1, 6),
(8, 'Placa madre MSI B550M PRO-VDH WIFI', 'MOT-001', 7, 'Motherboard MSI B550M PRO-VDH WIFI con socket AM4 y conectividad WiFi.', 130000.00, 160000.00, 'msi-b550m-pro-vdh-wifi.jpg', 1, 5),
(9, 'Memoria RAM Kingston Fury Beast 16GB DDR4 3200MHz', 'RAM-001', 8, 'Memoria RAM Kingston Fury Beast de 16GB DDR4 a 3200MHz.', 45000.00, 58000.00, 'kingston-fury-beast-16gb.jpg', 1, 10),
(10, 'SSD Kingston NV2 1TB NVMe', 'ALM-001', 9, 'Unidad SSD Kingston NV2 de 1TB con interfaz M.2 NVMe.', 68000.00, 85000.00, 'kingston-nv2-1tb.jpg', 1, 10),
(11, 'Fuente de alimentación Corsair CV650 650W 80 Plus Bronze', 'FUE-001', 10, 'Fuente Corsair CV650 de 650W con certificacion 80 Plus Bronze.', 75000.00, 95000.00, 'corsair-cv650.jpg', 1, 8),
(12, 'Gabinete Corsair 4000D Airflow', 'GAB-001', 11, 'Gabinete Corsair 4000D Airflow con frente mallado y buen flujo de aire.', 135000.00, 165000.00, 'corsair-4000d-airflow.jpg', 1, 4),
(13, 'Teclado Redragon Kumara K552', 'TEC-001', 12, 'Teclado mecanico Redragon Kumara K552 compacto con iluminacion.', 42000.00, 55000.00, 'redragon-kumara-k552.jpg', 1, 10),
(14, 'Mouse Logitech G502 HERO', 'MOU-001', 13, 'Mouse Logitech G502 HERO con sensor gaming de alta precision.', 65000.00, 85000.00, 'logitech-g502-hero.jpg', 1, 8),
(15, 'Auriculares HyperX Cloud II', 'AUR-001', 14, 'Auriculares HyperX Cloud II con sonido envolvente virtual 7.1.', 115000.00, 145000.00, 'hyperx-cloud-ii.jpg', 1, 10),
(16, 'Micrófono HyperX SoloCast', 'MIC-001', 15, 'Microfono USB HyperX SoloCast para streaming y grabacion.', 75000.00, 95000.00, 'hyperx-solocast.jpg', 1, 5),
(17, 'Cámara web Logitech C920 HD Pro', 'CAM-001', 16, 'Camara web Logitech C920 HD Pro con resolucion Full HD 1080p.', 75000.00, 95000.00, 'logitech-c920.jpg', 1, 6),
(18, 'Joystick Xbox Wireless Controller', 'JOY-001', 17, 'Control inalambrico Xbox compatible con PC y consolas Xbox.', 90000.00, 110000.00, 'xbox-wireless-controller.jpg', 1, 6),
(19, 'Monitor ASUS TUF Gaming VG249Q1A', 'MON-001', 18, 'Monitor ASUS TUF Gaming de 23.8 pulgadas Full HD para gaming.', 230000.00, 280000.00, 'asus-tuf-vg249q1a.jpg', 1, 3),
(20, 'Monitor Dell P2422H', 'MON-002', 19, 'Monitor Dell P2422H de 24 pulgadas Full HD para oficina.', 230000.00, 280000.00, 'dell-p2422h.jpg', 1, 3),
(21, 'Mousepad Logitech G240', 'PAD-001', 20, 'Mousepad Logitech G240 con superficie optimizada para gaming.', 18000.00, 25000.00, 'logitech-g240.jpg', 1, 10),
(22, 'Hub USB TP-Link UH700 USB 3.0', 'HUB-001', 21, 'Hub USB TP-Link UH700 con 7 puertos USB 3.0.', 50000.00, 65000.00, 'tp-link-uh700.jpg', 1, 5),
(23, 'Cable HDMI 2.1 UGREEN', 'CAB-001', 22, 'Cable HDMI 2.1 UGREEN para conectar monitores y televisores compatibles.', 13000.00, 18000.00, 'ugreen-hdmi-2-1.jpg', 1, 15),
(24, 'Soporte para monitor North Bayou F80', 'SOP-001', 23, 'Soporte articulado North Bayou F80 para monitor.', 50000.00, 65000.00, 'north-bayou-f80.jpg', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idProveedor` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cuit` varchar(11) NOT NULL,
  `razonSocial` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `nombre`, `cuit`, `razonSocial`) VALUES
(1, 'Tech Argentina', '30712345678', 'Tech Argentina S.A.'),
(2, 'Hardware Center', '30723456789', 'Hardware Center S.R.L.'),
(3, 'Digital Store', '30734567890', 'Digital Store S.A.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipoUsuario` enum('cliente','administrador') NOT NULL DEFAULT 'cliente',
  `metodoPago` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `email`, `contrasena`, `tipoUsuario`, `metodoPago`) VALUES
(5, 'admin', 'admin@gmail.com', '$2y$10$z4w6IasanT68UWwS6AyspuwD/NFk5DTHetN94qfbrCOZbSzV6/UUG', 'administrador', 'Mercado Pago'),
(6, 'angel correa', 'angel@gmail.com', '$2y$10$6mQdlYCFaK3s0BTnKkQbNezSxj2/CIRhj9ZUGQiSYU9R08XtUHOgC', 'cliente', 'Mercado Pago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idVenta` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `idUsuario` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `codigoPostal` varchar(20) NOT NULL,
  `metodoPago` varchar(50) NOT NULL,
  `pisoDepto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`idCarrito`),
  ADD UNIQUE KEY `identificadorSesion` (`identificadorSesion`),
  ADD UNIQUE KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`),
  ADD KEY `idCategoriaPadre` (`idCategoriaPadre`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`idDireccion`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`idItems`),
  ADD KEY `idVenta` (`idVenta`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `items_carrito`
--
ALTER TABLE `items_carrito`
  ADD PRIMARY KEY (`idItemCarrito`),
  ADD UNIQUE KEY `idCarrito` (`idCarrito`,`idProducto`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idCategoria` (`idCategoria`),
  ADD KEY `idProveedor` (`idProveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idProveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `idCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `idDireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `idItems` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `items_carrito`
--
ALTER TABLE `items_carrito`
  MODIFY `idItemCarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `carritos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`idCategoriaPadre`) REFERENCES `categorias` (`idCategoria`) ON DELETE SET NULL;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `direcciones_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`idVenta`) REFERENCES `ventas` (`idVenta`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE SET NULL;

--
-- Filtros para la tabla `items_carrito`
--
ALTER TABLE `items_carrito`
  ADD CONSTRAINT `items_carrito_ibfk_1` FOREIGN KEY (`idCarrito`) REFERENCES `carritos` (`idCarrito`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_carrito_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
