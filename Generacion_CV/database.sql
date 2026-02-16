-- Base de datos para el generador de CV
CREATE DATABASE IF NOT EXISTS cv_generator CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE cv_generator;

-- Tabla principal de CVs
CREATE TABLE IF NOT EXISTS cvs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    direccion VARCHAR(200),
    perfil_profesional TEXT,
    foto VARCHAR(255),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    version INT DEFAULT 1,
    cv_original_id INT NULL,
    INDEX idx_cv_original (cv_original_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de experiencia laboral
CREATE TABLE IF NOT EXISTS experiencia_laboral (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cv_id INT NOT NULL,
    empresa VARCHAR(150) NOT NULL,
    puesto VARCHAR(150) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE,
    descripcion TEXT,
    orden INT DEFAULT 0,
    FOREIGN KEY (cv_id) REFERENCES cvs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de formación académica
CREATE TABLE IF NOT EXISTS formacion_academica (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cv_id INT NOT NULL,
    institucion VARCHAR(150) NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE,
    descripcion TEXT,
    orden INT DEFAULT 0,
    FOREIGN KEY (cv_id) REFERENCES cvs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de habilidades
CREATE TABLE IF NOT EXISTS habilidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cv_id INT NOT NULL,
    habilidad VARCHAR(100) NOT NULL,
    nivel ENUM('Básico', 'Intermedio', 'Avanzado', 'Experto') DEFAULT 'Intermedio',
    FOREIGN KEY (cv_id) REFERENCES cvs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de idiomas
CREATE TABLE IF NOT EXISTS idiomas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cv_id INT NOT NULL,
    idioma VARCHAR(50) NOT NULL,
    nivel ENUM('Básico', 'Intermedio', 'Avanzado', 'Nativo') DEFAULT 'Intermedio',
    FOREIGN KEY (cv_id) REFERENCES cvs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
