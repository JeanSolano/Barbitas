"-- Script para agregar columna usuario_id a las tablas

-- Agregar columna usuario_id a la tabla citas
ALTER TABLE citas ADD COLUMN usuario_id INT NULL;
ALTER TABLE citas ADD FOREIGN KEY (usuario_id) REFERENCES usuarios(id);

-- Agregar columna usuario_id a la tabla facturas
ALTER TABLE facturas ADD COLUMN usuario_id INT NULL;
ALTER TABLE facturas ADD FOREIGN KEY (usuario_id) REFERENCES usuarios(id);

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_citas_usuario_id ON citas(usuario_id);
CREATE INDEX idx_facturas_usuario_id ON facturas(usuario_id);" 
