-- ## Tablas para Usuarios

-- Tabla para usuarios generales
CREATE TABLE usuario (
    usuario_id SERIAL PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellido_pat VARCHAR(50) NOT NULL,
    apellido_mat VARCHAR(50) NOT NULL,
    num_tel VARCHAR(12) UNIQUE NOT NULL,
    correo VARCHAR(128) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    foto BYTEA,
    -- Clave foránea que vincula al proyecto
    proyecto_id INT REFERENCES proyecto (id) ON DELETE SET NULL
);

-- Tabla para estudiantes (hereda de usuario)
CREATE TABLE estudiante (
    usuario_id INT PRIMARY KEY REFERENCES usuario (usuario_id) ON DELETE CASCADE,
    carrera VARCHAR(50) NOT NULL,
    codigo_estudiante VARCHAR(9) UNIQUE NOT NULL,
    habilidades TEXT
);

-- Tabla para asesores (hereda de usuario)
CREATE TABLE asesor (
    usuario_id INT PRIMARY KEY REFERENCES usuario (usuario_id) ON DELETE CASCADE,
    codigo_asesor VARCHAR(9) UNIQUE NOT NULL,
    departamento VARCHAR(255)
);

-- ## Tablas para Proyectos

-- Tabla para proyectos
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

-- ## Tablas Intermedias

-- Integrantes del proyecto
CREATE TABLE integrante (
    integrante_id SERIAL PRIMARY KEY,
    -- Enlace a estudiante
    estudiante_id INT REFERENCES estudiante (usuario_id) ON DELETE CASCADE,
    proyecto_id INT REFERENCES proyecto (id) ON DELETE CASCADE, -- Enlace a proyecto
    UNIQUE (estudiante_id, proyecto_id)
);

-- Líder del proyecto
CREATE TABLE lider (
    lider_id SERIAL PRIMARY KEY,
    -- Enlace a un estudiante como líder
    estudiante_id INT REFERENCES estudiante (usuario_id) ON DELETE CASCADE,
    proyecto_id INT REFERENCES proyecto (id) ON DELETE CASCADE -- Enlace al proyecto
);

-- Asesores del proyecto
CREATE TABLE proyecto_asesor (
    proyecto_id INT REFERENCES proyecto (id) ON DELETE CASCADE,
    asesor_id INT REFERENCES asesor (usuario_id) ON DELETE CASCADE,
    -- Clave primaria compuesta para asegurar combinaciones únicas
    PRIMARY KEY (proyecto_id, asesor_id)
);
