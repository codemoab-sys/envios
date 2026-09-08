-- Esquema aislado de MOABCODE Envios.
-- Este archivo solo crea tablas con prefijo envio_.
-- No modifica ni elimina tablas de otros sistemas.

CREATE TABLE IF NOT EXISTS `envio_usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `perfil` varchar(50) DEFAULT 'vendedor',
  `foto` varchar(255) DEFAULT '',
  `estado` tinyint(1) DEFAULT 1,
  `plan` varchar(20) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_vencimiento` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_envio_usuarios_tenant` (`tenant_id`),
  UNIQUE KEY `uk_envio_usuarios_usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `envio_configuracion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int DEFAULT NULL,
  `nombre_emprendimiento` varchar(150) NOT NULL DEFAULT '',
  `whatsapp` varchar(9) NOT NULL DEFAULT '',
  `metodos_envio` text NOT NULL,
  `dias_despacho` text NOT NULL,
  `hora_corte` time NOT NULL DEFAULT '18:00:00',
  `anticipacion` int NOT NULL DEFAULT 0,
  `tema` varchar(10) NOT NULL DEFAULT 'light',
  `color_cabecera` varchar(7) NOT NULL DEFAULT '#dd4b39',
  `color_boton_primario` varchar(7) NOT NULL DEFAULT '#3b82f6',
  `color_boton_secundario` varchar(7) NOT NULL DEFAULT '#202c42',
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_envio_configuracion_usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `envio_formularios_compartir` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `token` varchar(64) NOT NULL,
  `enlace` varchar(500) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_envio_formularios_token` (`token`),
  KEY `idx_envio_formularios_tenant` (`tenant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `envio_respuestas_formulario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenant_id` int DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `agencia` varchar(100) NOT NULL DEFAULT 'SHALOM',
  `fecha_envio` varchar(50) DEFAULT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'pendiente',
  `mensaje` text DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_envio_respuestas_tenant` (`tenant_id`),
  KEY `idx_envio_respuestas_estado` (`estado`),
  KEY `idx_envio_respuestas_fecha` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
