-- ============================================
-- BACKUP BASE DE DATOS: enviosbd
-- ============================================
-- INSTRUCCIONES:
-- 1. Este archivo solo crea tablas con prefijo envio_.
-- 2. Si una tabla envio_ ya existe, MySQL la conserva sin modificarla.
-- 3. No elimina ni altera tablas de otros sistemas.
-- ============================================

-- Ejecutar este archivo en phpMyAdmin o consola MySQL
-- mysql -u root enviosbd < bk.sql


-- ============================================
-- TABLA: usuarios
-- ============================================
CREATE TABLE IF NOT EXISTS `envio_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `perfil` varchar(50) DEFAULT 'vendedor',
  `foto` varchar(255) DEFAULT '',
  `estado` int(1) DEFAULT 1,
  `plan` varchar(20) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `fecha` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tenant_id` (`tenant_id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ============================================
-- TABLA: configuracion
-- (Agrega aqui tus campos cuando los definas)
-- ============================================
CREATE TABLE IF NOT EXISTS `envio_configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre_empresa` varchar(200) DEFAULT '',
  `ruc` varchar(20) DEFAULT '',
  `telefono` varchar(20) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `direccion` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT '',
  `mensaje_ticket` text DEFAULT NULL,
  `fecha` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ============================================
-- USUARIO ADMIN POR DEFECTO
-- (Password: admin123)
-- ============================================
INSERT INTO `envio_usuarios` (`nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`)
SELECT 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5aunxs9bkpyGmGE/.vekdjFg83yRec789S', 'administrador', '', 1
WHERE NOT EXISTS (SELECT 1 FROM `envio_usuarios` WHERE `usuario` = 'admin');

-- Repara el usuario admin si una versión anterior guardó únicamente el salt.
UPDATE `envio_usuarios`
SET `password` = '$2a$07$asxx54ahjppf45sd87a5aunxs9bkpyGmGE/.vekdjFg83yRec789S'
WHERE `usuario` = 'admin'
  AND `password` = '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$';


-- ============================================
-- ============================================
--
--  AGREGA TUS TABLAS AQUI ABAJO
--  COPIA UN BLOQUE Y MODIFICALO:
--
--  CREATE TABLE IF NOT EXISTS `nombre_tabla` (
--    `id` int(11) NOT NULL AUTO_INCREMENT,
--    `campo1` varchar(100) NOT NULL,
--    `campo2` text DEFAULT NULL,
--    `fecha` timestamp DEFAULT CURRENT_TIMESTAMP,
--    PRIMARY KEY (`id`)
--  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- ============================================
-- ============================================


-- ============================================
-- EJEMPLO: TABLA ENVIO
-- (Descomenta y modifica segun necesites)
-- ============================================
-- CREATE TABLE IF NOT EXISTS `envios` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `codigo` varchar(50) NOT NULL,
--   `id_cliente` int(11) DEFAULT NULL,
--   `direccion_envio` text NOT NULL,
--   `ciudad` varchar(100) DEFAULT NULL,
--   `telefono` varchar(20) DEFAULT NULL,
--   `estado` varchar(50) DEFAULT 'pendiente',
--   `precio_envio` decimal(10,2) DEFAULT 0.00,
--   `fecha` timestamp DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ============================================
-- EJEMPLO: TABLA COMPROBANTE/PAGO
-- (Descomenta y modifica segun necesites)
-- ============================================
-- CREATE TABLE IF NOT EXISTS `comprobantes` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `id_venta` int(11) DEFAULT NULL,
--   `tipo` varchar(50) DEFAULT NULL,
--   `monto` decimal(10,2) DEFAULT 0.00,
--   `estado` varchar(50) DEFAULT 'pendiente',
--   `fecha` timestamp DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ============================================
-- TABLA: formularios_compartir
-- (Link compartible para formulario público)
-- ============================================
CREATE TABLE IF NOT EXISTS `envio_formularios_compartir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `token` varchar(64) NOT NULL,
  `enlace` varchar(500) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_formularios_compartir_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- TABLA: respuestas_formulario
-- (Respuestas del formulario compartido - usado en Envios)
-- ============================================
CREATE TABLE IF NOT EXISTS `envio_respuestas_formulario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'pendiente',
  `mensaje` text DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_respuestas_estado` (`estado`),
  KEY `idx_respuestas_fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- FIN DEL ARCHIVO
-- ============================================
-- No hay instrucciones DROP: las tablas de otros sistemas se conservan.
