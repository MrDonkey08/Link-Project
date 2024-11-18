-- # Creación de Tablas

-- ## Tablas para usuarios

-- Tabla padre padre para usuarios
CREATE TABLE usuario (
    id_usuario SERIAL PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellido_pat VARCHAR(50) NOT NULL,
    apellido_mat VARCHAR(50) NOT NULL,
    num_tel VARCHAR(15) UNIQUE NOT NULL,
    correo VARCHAR(128) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL,
    codigo_escolar VARCHAR(9) UNIQUE NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    foto BYTEA
);

-- Tabla hija para estudiantes (heredada de tb usuarios)
CREATE TABLE estudiante (
    id_estudiante SERIAL PRIMARY KEY,
    carrera VARCHAR(50) NOT NULL,
    habilidades TEXT
) INHERITS (usuario);

-- Tabla hija para asesores (heredada de tb usuarios)
CREATE TABLE asesor (
    id_asesor SERIAL PRIMARY KEY,
    departamento VARCHAR(255)
) INHERITS (usuario);

-- ## Tablas para proyectos

-- Tabla de Proyecto
CREATE TABLE proyecto (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(128) NOT NULL,
    descripcion TEXT NOT NULL,
    area VARCHAR(128) NOT NULL,
    cupos SMALLINT CHECK (cupos <= 3) DEFAULT 3,
    activo BOOLEAN DEFAULT TRUE,
    conocimientos_requeridos TEXT,
    nivel_de_innovacion VARCHAR(20),
    logo BYTEA
);

-- ## Tablas intermedias

-- Tabla para integrantes del equipo
CREATE TABLE integrante (
    id SERIAL PRIMARY KEY,
    id_estudiante INT REFERENCES estudiante (id_estudiante) ON DELETE CASCADE,
    id_proyecto INT REFERENCES proyecto (id) ON DELETE CASCADE
);

-- Table for Project Leaders
CREATE TABLE lider (
    id SERIAL PRIMARY KEY,
    id_estudiante INT REFERENCES estudiante (id_estudiante) ON DELETE CASCADE,
    id_proyecto INT REFERENCES proyecto (id) ON DELETE CASCADE,
    UNIQUE (id_estudiante, id_proyecto)
);

-- Table for Project Advisors
CREATE TABLE proyecto_asesor (
    id_asesor INT REFERENCES asesor (id_asesor) ON DELETE CASCADE,
    id_proyecto INT REFERENCES proyecto (id) ON DELETE CASCADE,
    PRIMARY KEY (id_proyecto, id_asesor)
);

-- # Inserción de Datos

INSERT INTO estudiante (
    nombres,
    apellido_pat,
    apellido_mat,
    num_tel,
    correo,
    clave,
    carrera,
    codigo_escolar
) VALUES (
    'Juan',
    'Romero',
    'Mendez',
    '1234567890',
    'john.doe@example.com',
    'pass',
    'Ingeniería en Computación',
    '123456789'
), (
    'Andrea',
    'García',
    'Hernandez',
    '019283745',
    'mauricio.lopez@example.com',
    'pass',
    'Licenciatura en Matemáticas',
    '650192834'
);


INSERT INTO asesor (
    nombres,
    apellido_pat,
    apellido_mat,
    num_tel,
    correo,
    clave,
    departamento,
    codigo_escolar
) VALUES (
    'Elias',
    'Castillo',
    'Del Toro',
    '987654321',
    'elias.castillo@example.com',
    'pass',
    'Departamento de Matemáticas',
    'S12345678'
), (
    'Mauricio',
    'López',
    'Delgado',
    '019283745',
    'mauricio.lopez@example.com',
    'pass',
    'Departamento de Física',
    'S2345678'
);

INSERT INTO proyecto (
    nombre,
    descripcion,
    area
) VALUES (
    'Androide',
    'Robot que actúa y se ve como un humano',
    'Róbotica e IA'
), (
    'Sueños Online',
    'Dispositivo que permite conectar sueños de distintas personas',
    'IA y Biomédicina'
);

INSERT INTO integrante (
    id_estudiante,
    id_proyecto
) VALUES
    (1, 1),
    (2, 1);

INSERT INTO lider (
    id_estudiante,
    id_proyecto
) VALUES (2, 1);

INSERT INTO proyecto_asesor (
    id_asesor,
    id_proyecto
) VALUES (1, 1);

-- # Muestreo de Tablas

SELECT * FROM usuario;
SELECT * FROM estudiante;
SELECT * FROM asesor;
SELECT * FROM proyecto;
SELECT * FROM integrante;
SELECT * FROM lider;
SELECT * FROM proyecto_asesor;

-- # Eliminación de Tablas

-- Vacía las tablas y reinicia las secuencias recursivamente
--TRUNCATE TABLE usuario RESTART IDENTITY CASCADE;
--TRUNCATE TABLE proyecto RESTART IDENTITY CASCADE;
