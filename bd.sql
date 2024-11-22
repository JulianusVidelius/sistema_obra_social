CREATE DATABASE obra_social;

USE obra_social;

-- Tabla para almacenar usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') DEFAULT 'usuario',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para planes de afiliación
CREATE TABLE afiliaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    plan VARCHAR(50) NOT NULL,
    fecha_afiliacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE planes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    precio DECIMAL(10,2) NOT NULL
);

-- Asegúrate de estar usando la base de datos correcta
USE obra_social;

-- Crear un usuario administrador
INSERT INTO usuarios (nombre, apellido, email, contrasena, rol)
VALUES  --la password es admin123
('Admin', 'Principal', 'admin@obrasocial.com', 
    -- Aquí usamos una contraseña hasheada para mayor seguridad
    '$2y$10$eJzMZzOrAv7Nj/hcXszRNe7RYZPYqRSQknHL5mr7HtVuwTE8Rm/SK', 
    'admin');

-- Agregar un campo descripcion a la tabla planes 
ALTER TABLE planes ADD COLUMN descripcion TEXT;

    -- Insertar datos de ejemplo en la tabla planes
INSERT INTO planes (nombre, precio, descripcion) 
VALUES 
    ('Plan Básico', 2500.00, 'Cobertura en medicina general y consultas básicas.'),
    ('Plan Familiar', 5000.00, 'Cobertura para toda la familia, incluyendo pediatría y ginecología.'),
    ('Plan Premium', 8000.00, 'Cobertura integral con acceso a especialistas y estudios avanzados.');
