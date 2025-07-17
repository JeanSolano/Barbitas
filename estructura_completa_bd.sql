-- ============================================
-- ESTRUCTURA COMPLETA DE LA BASE DE DATOS BARBITAS
-- Archivo de respaldo y creación de base de datos
-- Fecha: 2025-07-17
-- ============================================

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS barbitas CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE barbitas;

-- ============================================
-- TABLA: usuarios
-- ============================================
CREATE TABLE `usuarios` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nombre` varchar(50) NOT NULL,
 `apellido` varchar(50) NOT NULL,
 `correo_electronico` varchar(100) NOT NULL,
 `username` varchar(50) NOT NULL,
 `password` varchar(100) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `correo_electronico` (`correo_electronico`),
 UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- TABLA: sucursales
-- ============================================
CREATE TABLE `sucursales` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nombre` varchar(100) NOT NULL,
 `direccion` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- TABLA: servicios
-- ============================================
CREATE TABLE `servicios` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nombre` varchar(100) NOT NULL,
 `precio` decimal(10,2) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- TABLA: barberos
-- ============================================
CREATE TABLE `barberos` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nombre` varchar(100) NOT NULL,
 `especialidad` varchar(100) DEFAULT NULL,
 `id_sucursal` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `id_sucursal` (`id_sucursal`),
 CONSTRAINT `barberos_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- TABLA: citas
-- ============================================
CREATE TABLE `citas` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `fecha` date NOT NULL,
 `hora` time NOT NULL,
 `servicio` varchar(100) NOT NULL,
 `id_barbero` int(11) DEFAULT NULL,
 `id_sucursal` int(11) DEFAULT NULL,
 `cliente` varchar(255) NOT NULL,
 `usuario_id` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `id_barbero` (`id_barbero`),
 KEY `id_sucursal` (`id_sucursal`),
 KEY `idx_citas_usuario_id` (`usuario_id`),
 CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`id_barbero`) REFERENCES `barberos` (`id`) ON DELETE SET NULL,
 CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id`) ON DELETE SET NULL,
 CONSTRAINT `citas_ibfk_4` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- TABLA: facturas
-- ============================================
CREATE TABLE `facturas` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `fecha` date NOT NULL,
 `hora` time NOT NULL,
 `id_barbero` int(11) NOT NULL,
 `id_sucursal` int(11) NOT NULL,
 `cliente` varchar(255) NOT NULL,
 `total` decimal(10,2) NOT NULL,
 `numero_factura` varchar(50) NOT NULL,
 `usuario_id` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `idx_facturas_usuario_id` (`usuario_id`),
 CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- TABLA: factura_detalles
-- ============================================
CREATE TABLE `factura_detalles` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `id_factura` int(11) NOT NULL,
 `servicio` varchar(255) NOT NULL,
 `precio` decimal(10,2) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `id_factura` (`id_factura`),
 CONSTRAINT `factura_detalles_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- DATOS DE EJEMPLO (OPCIONAL)
-- ============================================

-- Insertar sucursales de ejemplo
INSERT INTO `sucursales` (`nombre`, `direccion`) VALUES
('Sucursal Centro', 'Av. Principal 123, Centro'),
('Sucursal Norte', 'Calle Norte 456, Zona Norte'),
('Sucursal Sur', 'Blvd. Sur 789, Zona Sur');

-- Insertar servicios de ejemplo
INSERT INTO `servicios` (`nombre`, `precio`) VALUES
('Corte de Cabello', 25.00),
('Corte y Barba', 35.00),
('Afeitado', 15.00);

-- Insertar barberos de ejemplo
INSERT INTO `barberos` (`nombre`, `especialidad`, `id_sucursal`) VALUES
('Luis Miguel', 'Cortes Clásicos', 1),
('Jean Solano', 'Barbería Moderna', 2),
('Carlos Mendez', 'Especialista en Barba', 1),
('Roberto Silva', 'Cortes Modernos', 3);

-- Insertar usuario administrador
INSERT INTO `usuarios` (`nombre`, `apellido`, `correo_electronico`, `username`, `password`) VALUES
('Admin', 'Admin', 'admin@barbitas.com', 'admin', 'admin');

-- ============================================
-- NOTAS IMPORTANTES:
-- ============================================
-- 1. Este archivo contiene la estructura completa de la base de datos
-- 2. Incluye todas las relaciones y restricciones necesarias
-- 3. Los datos de ejemplo son opcionales y pueden eliminarse
-- 4. Para usar: ejecutar en phpMyAdmin o cualquier cliente MySQL
-- 5. Asegúrate de hacer respaldo antes de ejecutar en producción
