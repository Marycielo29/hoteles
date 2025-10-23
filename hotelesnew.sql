-- ===== BASE DE DATOS PARA SISTEMA DE HOTELES =====

-- Tabla de hoteles
CREATE TABLE IF NOT EXISTS `hoteles` (
  `hotel_id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT,
  `direccion` VARCHAR(255),
  `ciudad` VARCHAR(100),
  `categoria` ENUM('1','2','3','4','5') DEFAULT '3',
  `telefono` VARCHAR(20),
  `email_contacto` VARCHAR(150),
  `latitud` DECIMAL(10,7),
  `longitud` DECIMAL(10,7),
  `fecha_registro` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hotel_id`),
  KEY `idx_ciudad` (`ciudad`),
  KEY `idx_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de habitaciones
CREATE TABLE IF NOT EXISTS `habitaciones` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` INT(11) NOT NULL,
  `tipo` VARCHAR(100) NOT NULL,
  `capacidad` VARCHAR(20),
  `precio_noche` DECIMAL(10,2) NOT NULL,
  `moneda` VARCHAR(10) DEFAULT 'EUR',
  `fecha` DATE,
  `cantidad_disponible` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_hotel` (`hotel_id`),
  KEY `idx_tipo` (`tipo`),
  CONSTRAINT `fk_habitaciones_hotel` FOREIGN KEY (`hotel_id`) REFERENCES `hoteles` (`hotel_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de servicios
CREATE TABLE IF NOT EXISTS `servicios` (
  `servicio_id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`servicio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla intermedia hoteles_servicios
CREATE TABLE IF NOT EXISTS `hoteles_servicios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` INT(11) NOT NULL,
  `servicio_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_hotel` (`hotel_id`),
  KEY `fk_servicio` (`servicio_id`),
  CONSTRAINT `fk_hotel_servicio_hotel` FOREIGN KEY (`hotel_id`) REFERENCES `hoteles` (`hotel_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_hotel_servicio_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`servicio_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de clientes API
CREATE TABLE IF NOT EXISTS `Client_API` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ruc` VARCHAR(20) NOT NULL,
  `razon_social` VARCHAR(150) NOT NULL,
  `telefono` VARCHAR(20),
  `correo` VARCHAR(100),
  `fecha_registro` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `estado` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_ruc` (`ruc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de tokens
CREATE TABLE IF NOT EXISTS `Tokens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_client_api` INT(11) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `fecha_reg` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `estado` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_token` (`token`),
  KEY `fk_cliente` (`id_client_api`),
  CONSTRAINT `fk_token_cliente` FOREIGN KEY (`id_client_api`) REFERENCES `Client_API` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Count_request` (
  `id` int NOT NULL,
  `id_token` int NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
   PRIMARY KEY (`id`),
  KEY `fk_token` (`id_token`),
  CONSTRAINT `fk_token` FOREIGN KEY (`id_token`) REFERENCES `Tokens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===== DATOS DE EJEMPLO =====
CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','empleado','cliente') DEFAULT 'cliente',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `token_password` varchar(40) DEFAULT NULL,
  `reset_password` int DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sesiones` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `token` text NOT NULL,
  `fecha_hora_inicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_hora_fin` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

  -- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

  ALTER TABLE `sesiones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

  --
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

  --
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `estado`, `token_password`, `reset_password`, `creado_en`) VALUES
(1, 'Marycielo', 'admin@hotel.com', '$2y$10$3gw5NXnlpweD/yOccbQyceYT5JPI/W5F99jAfgAb9nMDX1OzyK6zK', 'admin', 1, NULL, NULL, '2025-09-09 13:51:10');


-- Insertar servicios
INSERT INTO `servicios` (`servicio_id`, `nombre`) VALUES
(1, 'Wi-Fi'),
(2, 'Desayuno'),
(3, 'TV por cable'),
(4, 'Gimnasio'),
(5, 'Minibar'),
(6, 'Jacuzzi'),
(7, 'Vista panorámica'),
(8, 'Aire acondicionado'),
(9, 'Vista al mar'),
(10, 'Balcón'),
(11, 'Sala de reuniones'),
(12, 'Servicio 24h'),
(13, 'Terraza privada'),
(14, 'Chef privado'),
(15, 'Spa'),
(16, 'Calefacción'),
(17, 'Chimenea'),
(18, 'Cocina'),
(19, 'Piscina'),
(20, 'Bata de baño'),
(21, 'Servicio habitación'),
(22, 'Soundbar'),
(23, 'Bañera hidromasaje'),
(24, 'Todo incluido'),
(25, 'Animación'),
(26, 'Club infantil'),
(27, 'Piscina privada'),
(28, 'Playa privada'),
(29, 'Mayordomo');

-- Insertar hoteles
INSERT INTO `hoteles` (`hotel_id`, `nombre`, `descripcion`, `direccion`, `ciudad`, `categoria`, `telefono`, `email_contacto`, `latitud`, `longitud`) VALUES
(1, 'Hotel del Sol', 'Hotel moderno en el centro de la ciudad con vistas espectaculares y servicios de primera clase.', 'Calle Gran Vía 25', 'Madrid', '4', '+34 91 123 4567', 'info@hoteldelsol.es', 40.4168, -3.7038),
(2, 'Gran Hotel Barcelona', 'Elegante hotel frente al mar con acceso directo a la playa y restaurante gourmet.', 'Paseo Marítimo 101', 'Barcelona', '5', '+34 93 234 5678', 'reservas@granhotelbarcelona.es', 41.3851, 2.1734),
(3, 'Hotel Montaña Verde', 'Refugio natural en las montañas, perfecto para amantes de la naturaleza y deportes de aventura.', 'Camino Rural km 5', 'Asturias', '3', '+34 98 345 6789', 'contacto@montanaverde.es', 43.3614, -5.8593),
(4, 'Palace Hotel Sevilla', 'Hotel histórico con arquitectura andaluza, jardines interiores y piscina.', 'Plaza de España 8', 'Sevilla', '4', '+34 95 456 7890', 'info@palacehotelsevilla.es', 37.3891, -5.9845),
(5, 'Hotel Boutique Valencia', 'Hotel de diseño contemporáneo en el corazón de la ciudad, cerca de la Ciudad de las Artes.', 'Calle Colón 45', 'Valencia', '4', '+34 96 567 8901', 'reservas@boutiquevalencia.es', 39.4699, -0.3763),
(6, 'Resort Costa del Sol', 'Resort all-inclusive con playa privada, múltiples piscinas y actividades para toda la familia.', 'Urbanización Playa Dorada', 'Málaga', '5', '+34 95 678 9012', 'info@resortcostadelsol.es', 36.7213, -4.4214);

-- Insertar habitaciones
INSERT INTO `habitaciones` (`id`, `hotel_id`, `tipo`, `capacidad`, `precio_noche`, `moneda`, `fecha`, `cantidad_disponible`) VALUES
-- Hotel del Sol
(1, 1, 'simple', '1 persona', 80.00, 'EUR', '2025-01-01', 5),
(2, 1, 'doble', '2 personas', 120.00, 'EUR', '2025-01-01', 8),
(3, 1, 'suite', '2-4 personas', 200.00, 'EUR', '2025-01-01', 0),

-- Gran Hotel Barcelona
(4, 2, 'simple', '1 persona', 95.00, 'EUR', '2025-01-01', 6),
(5, 2, 'doble', '2 personas', 140.00, 'EUR', '2025-01-01', 10),
(6, 2, 'suite ejecutiva', '2 personas', 250.00, 'EUR', '2025-01-01', 4),
(7, 2, 'penthouse', '4 personas', 400.00, 'EUR', '2025-01-01', 0),

-- Hotel Montaña Verde
(8, 3, 'cabaña simple', '2 personas', 65.00, 'EUR', '2025-01-01', 8),
(9, 3, 'cabaña doble', '4 personas', 100.00, 'EUR', '2025-01-01', 6),
(10, 3, 'suite familiar', '6 personas', 180.00, 'EUR', '2025-01-01', 3),

-- Palace Hotel Sevilla
(11, 4, 'simple', '1 persona', 75.00, 'EUR', '2025-01-01', 7),
(12, 4, 'doble deluxe', '2 personas', 135.00, 'EUR', '2025-01-01', 9),
(13, 4, 'suite', '2-3 personas', 220.00, 'EUR', '2025-01-01', 4),

-- Hotel Boutique Valencia
(14, 5, 'simple premium', '1 persona', 90.00, 'EUR', '2025-01-01', 5),
(15, 5, 'doble', '2 personas', 130.00, 'EUR', '2025-01-01', 0),
(16, 5, 'loft', '2-3 personas', 190.00, 'EUR', '2025-01-01', 3),

-- Resort Costa del Sol
(17, 6, 'habitación estándar', '2 personas', 110.00, 'EUR', '2025-01-01', 15),
(18, 6, 'junior suite', '2-3 personas', 160.00, 'EUR', '2025-01-01', 10),
(19, 6, 'suite familiar', '4-5 personas', 240.00, 'EUR', '2025-01-01', 6),
(20, 6, 'villa privada', '6 personas', 450.00, 'EUR', '2025-01-01', 0);

-- Asignar servicios a hoteles
INSERT INTO `hoteles_servicios` (`hotel_id`, `servicio_id`) VALUES
-- Hotel del Sol
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7),
-- Gran Hotel Barcelona
(2, 1), (2, 2), (2, 8), (2, 9), (2, 10), (2, 11), (2, 12), (2, 13), (2, 14), (2, 15),
-- Hotel Montaña Verde
(3, 1), (3, 16), (3, 17), (3, 18), (3, 9),
-- Palace Hotel Sevilla
(4, 1), (4, 2), (4, 19), (4, 10), (4, 20), (4, 21),
-- Hotel Boutique Valencia
(5, 1), (5, 2), (5, 22), (5, 23), (5, 18),
-- Resort Costa del Sol
(6, 1), (6, 24), (6, 19), (6, 9), (6, 25), (6, 26), (6, 27), (6, 28), (6, 14), (6, 29);

-- Insertar cliente de prueba
INSERT INTO `Client_API` (`id`, `ruc`, `razon_social`, `telefono`, `correo`, `estado`) VALUES
(123, '20123456789', 'Empresa Demo S.A.', '+51 987654321', 'demo@empresa.com', 1);

-- Insertar token de prueba
INSERT INTO `Tokens` (`id`, `id_client_api`, `token`, `estado`) VALUES
(1, 123, 'xxx-xxx-123', 1);

-- ===== FIN DEL SCRIPT =====