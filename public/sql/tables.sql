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
    token VARCHAR(8) UNIQUE,
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

--- ### Tablas para participantes del equipo

-- Tabla para integrantes del equipo
CREATE TABLE integrante (
    id SERIAL PRIMARY KEY,
    id_estudiante INT REFERENCES estudiante (id_estudiante) ON DELETE CASCADE,
    id_proyecto INT REFERENCES proyecto (id) ON DELETE CASCADE,
    lider BOOLEAN DEFAULT FALSE
);

-- Table for Project Advisors
CREATE TABLE proyecto_asesor (
    id SERIAL PRIMARY KEY,
    id_asesor INT REFERENCES asesor (id_asesor) ON DELETE CASCADE,
    id_proyecto INT REFERENCES proyecto (id) ON DELETE CASCADE
);

-- ### Tablas para reuniones

-- Tabla para reuniones
CREATE TABLE reunion (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    id_proyecto INT REFERENCES proyecto (id) ON DELETE CASCADE
);

-- Tabla para participantes de reuniones
CREATE TABLE reunion_participante (
    id SERIAL PRIMARY KEY,
    id_reunion INT REFERENCES reunion (id) ON DELETE CASCADE,
    id_integrante INT REFERENCES integrante (id) ON DELETE CASCADE,
    id_asesor INT REFERENCES asesor (id_asesor) ON DELETE CASCADE,
    UNIQUE (id_reunion, id_integrante),
    UNIQUE (id_reunion, id_asesor)
);

-- ### Tablas para kaban

-- Tabla para tareas asignadas por líder
CREATE TABLE tarea (
    id SERIAL PRIMARY KEY,
    descripcion TEXT NOT NULL,
    -- 1: pendiente, 2: en proceso y 3: finalizado
    fase SMALLINT CHECK (fase <= 3) DEFAULT 1,
    id_proyecto INT REFERENCES proyecto (id) ON DELETE CASCADE
);

-- Tabla para integrantes que pertenecen a dicha tarea
CREATE TABLE tarea_integrantes (
    id SERIAL PRIMARY KEY,
    id_integrante INT REFERENCES integrante (id) ON DELETE CASCADE,
    id_tarea INT REFERENCES tarea (id) ON DELETE CASCADE
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
SELECT * FROM proyecto_asesor;
SELECT * FROM reunion;
SELECT * FROM reunion_participante;
SELECT * FROM tarea;
SELECT * FROM tarea_integrantes;

-- # Eliminación de Tablas

-- Vacía las tablas y reinicia las secuencias recursivamente
--TRUNCATE TABLE usuario RESTART IDENTITY CASCADE;
--TRUNCATE TABLE proyecto RESTART IDENTITY CASCADE;
