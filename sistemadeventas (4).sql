-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2022 a las 22:18:19
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemadeventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categorias` text NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categorias`, `fecha`) VALUES
(1, 'andamios', '0000-00-00'),
(2, 'equipos mecanicos', '0000-00-00'),
(3, 'generadores de energia', '0000-00-00'),
(4, 'articulos de limpieza', '0000-00-00'),
(5, 'tuercas', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `documento` int(11) NOT NULL,
  `email` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`) VALUES
(1, 'luis alberto', 456786433, 'rolando@gmail.com', '646654566gggggg', 'mz y usa lote 6ggggggg', '2022-04-19', 37, '2022-05-17 20:57:06', '2022-05-18 01:57:06'),
(3, 'alejandro molina', 666666, 'alejandro@gmail.com', '(111) 111-1111', 'wdeswss', '2011-11-11', 16, '2022-05-13 21:33:38', '2022-05-14 02:33:38'),
(4, 'alejandro martines', 666666, 'pepe@gmail.com', '(111) 111-1111', 'wdeswss', '2011-11-11', 37, '2022-04-25 15:11:11', '2022-05-14 02:44:44'),
(5, 'alejandro magno', 666666, 'aleja1ndro@gmail.com', '(111) 111-1111', '4444@gmail.com', '1990-02-02', 18, '2022-05-18 11:11:51', '2022-05-18 16:11:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `fecha`) VALUES
(1, 1, '101', 'Aspiradora Industrial ', 'vistas/img/productos/101/105.png', 0, 1000, 1200, 0, '2022-03-30 17:22:06'),
(2, 1, '102', 'Plato Flotante para Allanadora', 'vistas/img/productos/102/940.jpg', 8, 4500, 6300, 1, '2022-03-30 16:10:53'),
(3, 1, '103', 'Compresor de Aire para pintura', 'vistas/img/productos/103/763.jpg', 9, 3000, 4200, 11, '2022-03-30 16:10:53'),
(4, 1, '104', 'Cortadora de Adobe sin Disco ', 'vistas/img/productos/104/957.jpg', 16, 4000, 5600, 4, '2017-12-26 15:03:22'),
(5, 1, '105', 'Cortadora de Piso sin Disco ', 'vistas/img/productos/105/630.jpg', 13, 1540, 2156, 7, '2017-12-26 15:03:22'),
(6, 1, '106', 'Disco Punta Diamante ', 'vistas/img/productos/106/635.jpg', 15, 1100, 1540, 5, '2017-12-26 15:04:38'),
(7, 1, '107', 'Extractor de Aire ', 'vistas/img/productos/107/848.jpg', 12, 1540, 2156, 8, '2017-12-26 15:04:11'),
(8, 1, '108', 'Guadañadora ', 'vistas/img/productos/108/163.jpg', 13, 1540, 2156, 7, '2017-12-26 15:03:52'),
(9, 1, '109', 'Hidrolavadora Eléctrica ', 'vistas/img/productos/109/769.jpg', 15, 2600, 3640, 5, '2017-12-26 15:05:09'),
(10, 1, '110', 'Hidrolavadora Gasolina', 'vistas/img/productos/110/582.jpg', 18, 2210, 3094, 2, '2017-12-26 15:05:09'),
(11, 1, '111', 'Motobomba a Gasolina', 'vistas/img/productos/default/anonymous.png', 20, 2860, 4004, 0, '2017-12-21 21:56:28'),
(12, 1, '112', 'Motobomba El?ctrica', 'vistas/img/productos/default/anonymous.png', 20, 2400, 3360, 0, '2017-12-21 21:56:28'),
(13, 1, '113', 'Sierra Circular ', 'vistas/img/productos/default/anonymous.png', 20, 1100, 1540, 0, '2017-12-21 21:56:28'),
(14, 1, '114', 'Disco de tugsteno para Sierra circular', 'vistas/img/productos/default/anonymous.png', 20, 4500, 6300, 0, '2017-12-21 21:56:28'),
(15, 1, '115', 'Soldador Electrico ', 'vistas/img/productos/default/anonymous.png', 20, 1980, 2772, 0, '2017-12-21 21:56:28'),
(16, 1, '116', 'Careta para Soldador', 'vistas/img/productos/default/anonymous.png', 20, 4200, 5880, 0, '2017-12-21 21:56:28'),
(17, 1, '117', 'Torre de iluminacion ', 'vistas/img/productos/default/anonymous.png', 20, 1800, 2520, 0, '2017-12-21 21:56:28'),
(18, 2, '201', 'Martillo Demoledor de Piso 110V', 'vistas/img/productos/default/anonymous.png', 20, 5600, 7840, 0, '2017-12-21 21:56:28'),
(19, 2, '202', 'Muela o cincel martillo demoledor piso', 'vistas/img/productos/default/anonymous.png', 20, 9600, 13440, 0, '2017-12-21 21:56:28'),
(20, 2, '203', 'Taladro Demoledor de muro 110V', 'vistas/img/productos/default/anonymous.png', 20, 3850, 5390, 0, '2017-12-21 21:56:28'),
(21, 2, '204', 'Muela o cincel martillo demoledor muro', 'vistas/img/productos/default/anonymous.png', 20, 9600, 13440, 0, '2017-12-21 21:56:28'),
(22, 2, '205', 'Taladro Percutor de 1/2 Madera y Metal', 'vistas/img/productos/default/anonymous.png', 20, 8000, 11200, 0, '2017-12-21 22:28:24'),
(23, 2, '206', 'Taladro Percutor SDS Plus 110V', 'vistas/img/productos/default/anonymous.png', 20, 3900, 5460, 0, '2017-12-21 21:56:28'),
(24, 2, '207', 'Taladro Percutor SDS Max 110V (Mineria)', 'vistas/img/productos/default/anonymous.png', 20, 4600, 6440, 0, '2017-12-21 21:56:28'),
(25, 3, '301', 'Andamio colgante', 'vistas/img/productos/default/anonymous.png', 20, 1440, 2016, 0, '2017-12-21 21:56:28'),
(26, 3, '302', 'Distanciador andamio colgante', 'vistas/img/productos/default/anonymous.png', 20, 1600, 2240, 0, '2017-12-21 21:56:28'),
(27, 3, '303', 'Marco andamio modular ', 'vistas/img/productos/default/anonymous.png', 20, 900, 1260, 0, '2017-12-21 21:56:28'),
(28, 3, '304', 'Marco andamio tijera', 'vistas/img/productos/default/anonymous.png', 20, 100, 140, 0, '2017-12-21 21:56:28'),
(29, 3, '305', 'Tijera para andamio', 'vistas/img/productos/default/anonymous.png', 20, 162, 226, 0, '2017-12-21 21:56:28'),
(30, 3, '306', 'Escalera interna para andamio', 'vistas/img/productos/default/anonymous.png', 20, 270, 378, 0, '2017-12-21 21:56:28'),
(31, 3, '307', 'Pasamanos de seguridad', 'vistas/img/productos/default/anonymous.png', 20, 75, 105, 0, '2017-12-21 21:56:28'),
(32, 3, '308', 'Rueda giratoria para andamio', 'vistas/img/productos/default/anonymous.png', 20, 168, 235, 0, '2017-12-21 21:56:28'),
(33, 3, '309', 'Arnes de seguridad', 'vistas/img/productos/default/anonymous.png', 20, 1750, 2450, 0, '2017-12-21 21:56:28'),
(34, 3, '310', 'Eslinga para arnes', 'vistas/img/productos/default/anonymous.png', 20, 175, 245, 0, '2017-12-21 21:56:28'),
(35, 3, '311', 'Plataforma Met?lica', 'vistas/img/productos/default/anonymous.png', 20, 420, 588, 0, '2017-12-21 21:56:28'),
(36, 4, '401', 'Planta Electrica Diesel 6 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3500, 4900, 0, '2017-12-21 21:56:28'),
(37, 4, '402', 'Planta Electrica Diesel 10 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3550, 4970, 0, '2017-12-21 21:56:28'),
(38, 4, '403', 'Planta Electrica Diesel 20 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3600, 5040, 0, '2017-12-21 21:56:28'),
(39, 4, '404', 'Planta Electrica Diesel 30 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3650, 5110, 0, '2017-12-21 21:56:28'),
(40, 4, '405', 'Planta Electrica Diesel 60 Kva', 'vistas/img/productos/default/anonymous.png', 20, 3700, 5180, 0, '2017-12-21 21:56:28'),
(41, 4, '406', 'Planta Electrica Diesel 75 Kva', 'vistas/img/productos/default/anonymous.png', 19, 3750, 5250, 1, '2022-04-25 22:11:11'),
(42, 4, '407', 'Planta Electrica Diesel 100 Kva', 'vistas/img/productos/default/anonymous.png', 19, 3800, 5320, 1, '2022-04-25 22:11:11'),
(43, 4, '408', 'Planta Electrica Diesel 120 Kva', 'vistas/img/productos/default/anonymous.png', 19, 3850, 5390, 1, '2022-04-25 22:11:11'),
(44, 5, '501', 'Escalera de Tijera Aluminio ', 'vistas/img/productos/default/anonymous.png', 20, 350, 490, 0, '2017-12-21 21:56:28'),
(45, 5, '502', 'Extension Electrica ', 'vistas/img/productos/default/anonymous.png', 20, 370, 518, 0, '2017-12-21 21:56:28'),
(46, 5, '503', 'Gato tensor', 'vistas/img/productos/default/anonymous.png', 20, 380, 532, 0, '2017-12-21 21:56:28'),
(47, 5, '504', 'Lamina Cubre Brecha ', 'vistas/img/productos/default/anonymous.png', 19, 380, 532, 1, '2022-05-14 02:33:37'),
(48, 5, '505', 'Llave de Tubo', 'vistas/img/productos/default/anonymous.png', 18, 480, 672, 2, '2022-05-14 02:33:37'),
(49, 5, '506', 'Manila por Metro', 'vistas/img/productos/default/anonymous.png', 15, 600, 840, 5, '2022-05-14 02:33:37'),
(50, 5, '507', 'Polea 2 canales', 'vistas/img/productos/default/anonymous.png', 14, 900, 1260, 6, '2022-05-14 02:44:44'),
(52, 5, '509', 'Bascula ', 'vistas/img/productos/509/878.jpg', 9, 130, 182, 11, '2022-05-14 02:44:44'),
(53, 5, '510', 'Bomba Hidrostatica', 'vistas/img/productos/510/870.jpg', 5, 770, 1078, 15, '2022-05-14 02:44:44'),
(54, 5, '511', 'Chapeta', 'vistas/img/productos/511/239.jpg', 13, 660, 924, 7, '2022-05-14 02:44:44'),
(55, 5, '512', 'Cilindro muestra de concreto', 'vistas/img/productos/512/266.jpg', 13, 400, 560, 10, '2022-04-25 22:09:55'),
(56, 5, '513', 'Cizalla de Palanca', 'vistas/img/productos/513/445.jpg', 0, 450, 630, 29, '2022-04-25 22:08:11'),
(57, 5, '514', 'Cizalla de Tijera', 'vistas/img/productos/514/249.jpg', 12, 580, 812, 24, '2022-05-18 01:57:06'),
(58, 5, '515', 'Coche llanta neumatica', 'vistas/img/productos/515/174.jpg', 1, 420, 588, 28, '2022-05-18 16:11:51'),
(59, 5, '516', 'Cono slump', 'vistas/img/productos/516/228.jpg', 0, 140, 196, 5, '2022-04-12 16:29:55'),
(60, 5, '517', 'Cortadora de Baldosin6', 'vistas/img/productos/517/746.jpg', 0, 930, 1302, 8, '2022-05-18 01:57:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `perfil` text NOT NULL,
  `foto` text NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `fecha`) VALUES
(1, 'luis orlando', 'luisito', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Administrador', 'vistas/img/usuarios/luisito/441.jpg', 1, '2022-04-25 23:56:52'),
(2, 'alonso', 'alonso12', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', 'Administrador', 'vistas/img/usuarios/alonso12/398.jpg', 1, '2022-04-25 23:56:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text NOT NULL,
  `impuesto` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `id_cliente`, `id_vendedor`, `productos`, `impuesto`, `neto`, `total`, `metodo_pago`, `fecha`) VALUES
(1, 10002, 1, 1, '[{\"id\":\"55\",\"descripcion\":\"Cilindro muestra de concreto\",\"cantidad\":\"3\",\"stock\":\"13\",\"precio\":\"560\",\"total\":\"1680\"}]', 10, 100, 900, 'paypal', '2022-05-13 21:59:43'),
(3, 10003, 3, 1, '[{\"id\":\"55\",\"descripcion\":\"Cilindro muestra de concreto\",\"cantidad\":\"3\",\"stock\":\"13\",\"precio\":\"560\",\"total\":\"1680\"}]', 33.6, 1680, 1713.6, 'efectivo', '2022-04-25 22:09:55'),
(4, 10004, 4, 1, '[{\"id\":\"53\",\"descripcion\":\"Bomba Hidrostatica\",\"cantidad\":\"1\",\"stock\":\"7\",\"precio\":\"1078\",\"total\":\"1078\"},{\"id\":\"54\",\"descripcion\":\"Chapeta\",\"cantidad\":\"1\",\"stock\":\"15\",\"precio\":\"924\",\"total\":\"924\"},{\"id\":\"50\",\"descripcion\":\"Polea 2 canales\",\"cantidad\":\"1\",\"stock\":\"16\",\"precio\":\"1260\",\"total\":\"1260\"},{\"id\":\"52\",\"descripcion\":\"Bascula \",\"cantidad\":\"1\",\"stock\":\"11\",\"precio\":\"182\",\"total\":\"182\"},{\"id\":\"49\",\"descripcion\":\"Manila por Metro\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"840\",\"total\":\"840\"},{\"id\":\"48\",\"descripcion\":\"Llave de Tubo\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"672\",\"total\":\"672\"},{\"id\":\"41\",\"descripcion\":\"Planta Electrica Diesel 75 Kva\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"5250\",\"total\":\"5250\"},{\"id\":\"42\",\"descripcion\":\"Planta Electrica Diesel 100 Kva\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"5320\",\"total\":\"5320\"},{\"id\":\"43\",\"descripcion\":\"Planta Electrica Diesel 120 Kva\",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"5390\",\"total\":\"5390\"}]', 627.48, 20916, 21543.5, 'efectivo', '2022-04-25 22:11:11'),
(5, 10005, 5, 1, '[{\"id\":\"58\",\"descripcion\":\"Coche llanta neumatica\",\"cantidad\":\"3\",\"stock\":\"11\",\"precio\":\"588\",\"total\":\"1764\"},{\"id\":\"47\",\"descripcion\":\"Lamina Cubre Brecha \",\"cantidad\":\"1\",\"stock\":\"19\",\"precio\":\"532\",\"total\":\"532\"},{\"id\":\"48\",\"descripcion\":\"Llave de Tubo\",\"cantidad\":\"1\",\"stock\":\"18\",\"precio\":\"672\",\"total\":\"672\"},{\"id\":\"49\",\"descripcion\":\"Manila por Metro\",\"cantidad\":\"2\",\"stock\":\"13\",\"precio\":\"840\",\"total\":\"1680\"}]', 278.88, 4648, 4926.88, '', '2022-01-08 17:10:22'),
(6, 10006, 1, 1, '[{\"id\":\"50\",\"descripcion\":\"Polea 2 canales\",\"cantidad\":\"2\",\"stock\":\"14\",\"precio\":\"1260\",\"total\":\"2520\"},{\"id\":\"49\",\"descripcion\":\"Manila por Metro\",\"cantidad\":\"2\",\"stock\":\"17\",\"precio\":\"840\",\"total\":\"1680\"}]', 42, 4200, 4242, 'efectivo', '2022-04-25 23:47:21'),
(9, 10007, 3, 1, '[{\"id\":\"58\",\"descripcion\":\"Coche llanta neumatica\",\"cantidad\":\"2\",\"stock\":\"3\",\"precio\":\"588\",\"total\":\"1176\"},{\"id\":\"57\",\"descripcion\":\"Cizalla de Tijera\",\"cantidad\":\"2\",\"stock\":\"13\",\"precio\":\"812\",\"total\":\"1624\"},{\"id\":\"54\",\"descripcion\":\"Chapeta\",\"cantidad\":\"2\",\"stock\":\"13\",\"precio\":\"924\",\"total\":\"1848\"},{\"id\":\"53\",\"descripcion\":\"Bomba Hidrostatica\",\"cantidad\":\"2\",\"stock\":\"5\",\"precio\":\"1078\",\"total\":\"2156\"},{\"id\":\"52\",\"descripcion\":\"Bascula \",\"cantidad\":\"2\",\"stock\":\"9\",\"precio\":\"182\",\"total\":\"364\"}]', 286.72, 7168, 7454.72, '', '2022-05-14 02:33:38'),
(11, 10008, 1, 1, '[{\"id\":\"60\",\"descripcion\":\"Cortadora de Baldosin6\",\"cantidad\":\"1\",\"stock\":\"0\",\"precio\":\"1302\",\"total\":\"1302\"},{\"id\":\"58\",\"descripcion\":\"Coche llanta neumatica\",\"cantidad\":\"1\",\"stock\":\"2\",\"precio\":\"588\",\"total\":\"588\"},{\"id\":\"57\",\"descripcion\":\"Cizalla de Tijera\",\"cantidad\":\"1\",\"stock\":\"12\",\"precio\":\"812\",\"total\":\"812\"}]', 108.08, 2702, 2810.08, 'efectivo', '2022-02-18 02:57:06'),
(12, 10009, 5, 1, '[{\"id\":\"58\",\"descripcion\":\"Coche llanta neumatica\",\"cantidad\":\"1\",\"stock\":\"1\",\"precio\":\"588\",\"total\":\"588\"}]', 17.64, 588, 605.64, 'efectivo', '2022-03-18 16:11:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
