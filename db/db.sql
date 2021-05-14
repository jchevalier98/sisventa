-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2020 a las 00:23:43
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `svi_lite`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `caja_id` int(5) NOT NULL,
  `caja_numero` int(5) NOT NULL,
  `caja_nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `caja_estado` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `caja_efectivo` decimal(30,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`caja_id`, `caja_numero`, `caja_nombre`, `caja_estado`, `caja_efectivo`) VALUES
(1, 1, 'Caja Principal', 'Habilitada', '0.00');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(7) NOT NULL,
  `categoria_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_ubicacion` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `categoria_estado` varchar(17) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--
 
CREATE TABLE `cliente` (
  `cliente_id` int(10) NOT NULL,
  `cliente_codigo` varchar(10) NOT NULL,
  `cliente_tipo_documento` varchar(20),
  `cliente_numero_documento` varchar(35),
  `cliente_nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cumpleaños` varchar(50),
  `cliente_estado` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_direccion` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_cordenada` varchar(250),
  `cliente_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_tipo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_sitioweb` varchar(100),
  `cliente_vendedor_id` int(10) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_vendedor_nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_metodo_pago` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_ruta` varchar(30),
  `cliente_precio` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

CREATE TABLE `devolucion` (
  `devolucion_id` int(100) NOT NULL,
  `devolucion_codigo` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `devolucion_fecha` date NOT NULL,
  `devolucion_hora` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `devolucion_tipo` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `devolucion_descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `devolucion_cantidad` int(10) NOT NULL,
  `devolucion_precio` decimal(30,2) NOT NULL,
  `devolucion_total` decimal(30,2) NOT NULL,
  `compra_venta_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_id` int(20) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int(11) NOT NULL,
  `empresa_tipo_documento` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_numero_documento` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_impuesto_nombre` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_impuesto_porcentaje` int(3) NOT NULL,
  `empresa_factura_impuestos` varchar(3) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `movimiento_id` int(11) NOT NULL,
  `movimiento_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `movimiento_fecha` date NOT NULL,
  `movimiento_hora` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `movimiento_tipo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `movimiento_motivo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `movimiento_saldo_anterior` decimal(30,2) NOT NULL,
  `movimiento_cantidad` decimal(30,2) NOT NULL,
  `movimiento_saldo_actual` decimal(30,2) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `pago_id` int(11) NOT NULL,
  `pago_fecha` date NOT NULL,
  `pago_monto` decimal(30,2) NOT NULL,
  `pago_referencia` varchar(30),
  `venta_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `caja_id` int(5) NOT NULL,
  `cliente_codigo` varchar(10) NOT NULL,
  `cliente_metodo_pago` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(20) NOT NULL,
  `producto_codigo` varchar(77) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_sku` varchar(77) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_stock_total` int(25),
  `producto_peso` decimal(30,2),
  `producto_stock_vendido` int(50),
  `producto_tipo_unidad` varchar(20) COLLATE utf8_spanish2_ci,
  `producto_precio_compra` decimal(30,2),
  `producto_precio_venta` decimal(30,2),
  `producto_precio_mayoreo` decimal(30,2),
  `producto_descuento` int(3),
  `producto_marca` varchar(35) COLLATE utf8_spanish2_ci,
  `producto_modelo` varchar(35) COLLATE utf8_spanish2_ci,
  `producto_vencimiento` varchar(3) COLLATE utf8_spanish2_ci,
  `producto_fecha_vencimiento` date,
  `producto_garantia_unidad` int(3),
  `producto_garantia_tiempo` varchar(10) COLLATE utf8_spanish2_ci,
  `producto_estado` varchar(20) COLLATE utf8_spanish2_ci,
  `producto_foto` varchar(500) COLLATE utf8_spanish2_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(7) NOT NULL,
  `usuario_tipo_documento` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_numero_documento` varchar(35) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_apellido` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_genero` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_cargo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_clave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_foto` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_lector` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_tipo_codigo` varchar(7) COLLATE utf8_spanish2_ci NOT NULL,
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_tipo_documento`, `usuario_numero_documento`, `usuario_nombre`, `usuario_apellido`, `usuario_genero`, `usuario_email`, `usuario_cargo`, `usuario_usuario`, `usuario_clave`, `usuario_estado`, `usuario_telefono`, `usuario_foto`, `usuario_lector`, `usuario_tipo_codigo`, `caja_id`) VALUES
(1, 'DNI', '00000000', 'Administrador', 'Principal', 'Masculino', '', 'Administrador', 'Administrador', 'Qy93N2VQSG11QUlVT2duYmhDdktKUT09', 'Activa', '00000000', 'Avatar_Male_5.png', 'Habilitado', 'Barras', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `venta_id` int(30) NOT NULL,
  `venta_carga_tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `venta_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `venta_fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `venta_peso` decimal(30,2) NOT NULL,
  `venta_precio_cliente` decimal(30,2) NOT NULL,
  `venta_precio_venta` decimal(30,2) NOT NULL,
  `venta_delivery` decimal(30,2),
  `venta_total_final` decimal(30,2) NOT NULL,
  `venta_precio_paquete` decimal(30,2) NOT NULL,
  `venta_pagado` decimal(30,2),
  `venta_estado_pedido` varchar(20) NOT NULL,
  `venta_estado_pagado` varchar(20) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `cliente_codigo` varchar(10) NOT NULL,
  `venta_cliente_firma` LONGTEXT,
  `cliente_firma_nombre` varchar(100),
  `venta_entrega_foto` varchar(40),
  `venta_envio_email` varchar(1) DEFAULT 'S',
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

CREATE TABLE `venta_detalle` (
  `venta_detalle_id` int(100) NOT NULL,
  `venta_detalle_cantidad` int(10) NOT NULL,
  `venta_detalle_precio_compra` decimal(30,2) NOT NULL,
  `venta_detalle_precio_regular` decimal(30,2) NOT NULL,
  `venta_detalle_precio_venta` decimal(30,2) NOT NULL,
  `venta_detalle_subtotal` decimal(30,2) NOT NULL,
  `venta_detalle_impuestos` decimal(30,2) NOT NULL,
  `venta_detalle_descuento_porcentaje` int(3) NOT NULL,
  `venta_detalle_descuento_total` decimal(30,2) NOT NULL,
  `venta_detalle_total` decimal(30,2) NOT NULL,
  `venta_detalle_costo` decimal(30,2) NOT NULL,
  `venta_detalle_utilidad` decimal(30,2) NOT NULL,
  `venta_detalle_descripcion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `venta_detalle_garantia` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `venta_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD PRIMARY KEY (`devolucion_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`movimiento_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `venta_id` (`venta_codigo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`venta_id`),
  ADD UNIQUE KEY `venta_codigo` (`venta_codigo`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD PRIMARY KEY (`venta_detalle_id`),
  ADD KEY `venta_id` (`venta_codigo`),
  ADD KEY `producto_id` (`producto_id`);

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `devolucion`
--
ALTER TABLE `devolucion`
  MODIFY `devolucion_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `movimiento_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `pago_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `venta_id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `venta_detalle_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `devolucion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `devolucion_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`);

--
-- Filtros para la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `movimiento_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`venta_codigo`) REFERENCES `venta` (`venta_codigo`),
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD CONSTRAINT `venta_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  ADD CONSTRAINT `venta_detalle_ibfk_3` FOREIGN KEY (`venta_codigo`) REFERENCES `venta` (`venta_codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
