CREATE DATABASE IF NOT EXISTS tiempo_db CHARACTER SET utf8mb4;
USE tiempo_db;

CREATE TABLE IF NOT EXISTS ciudades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    pais VARCHAR(10) NOT NULL,
    lat DECIMAL(9,6) NOT NULL,
    lon DECIMAL(9,6) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_ciudad (nombre, pais)
);

CREATE TABLE IF NOT EXISTS consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ciudad_id INT NOT NULL,
    tipo_consulta ENUM('actual','horas','semana') NOT NULL,
    ip_cliente VARCHAR(45),
    realizada_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ciudad_id) REFERENCES ciudades(id)
);

CREATE TABLE IF NOT EXISTS datos_actuales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ciudad_id INT NOT NULL,
    temperatura DECIMAL(5,2),
    sensacion_termica DECIMAL(5,2),
    temp_min DECIMAL(5,2),
    temp_max DECIMAL(5,2),
    humedad INT,
    presion INT,
    velocidad_viento DECIMAL(5,2),
    descripcion VARCHAR(100),
    icono VARCHAR(20),
    obtenido_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ciudad_id) REFERENCES ciudades(id)
);

CREATE TABLE IF NOT EXISTS datos_horas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ciudad_id INT NOT NULL,
    dt VARCHAR(10) NOT NULL,
    temperatura DECIMAL(5,2),
    humedad INT,
    velocidad_viento DECIMAL(5,2),
    descripcion VARCHAR(100),
    icono VARCHAR(20),
    probabilidad_lluvia DECIMAL(4,2),
    obtenido_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ciudad_id) REFERENCES ciudades(id)
);

CREATE TABLE IF NOT EXISTS datos_semana (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ciudad_id INT NOT NULL,
    fecha DATE NOT NULL,
    temp_min DECIMAL(5,2),
    temp_max DECIMAL(5,2),
    humedad INT,
    velocidad_viento DECIMAL(5,2),
    descripcion VARCHAR(100),
    icono VARCHAR(20),
    probabilidad_lluvia DECIMAL(4,2),
    obtenido_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ciudad_id) REFERENCES ciudades(id)
);