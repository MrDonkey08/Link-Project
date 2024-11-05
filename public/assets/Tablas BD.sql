CREATE TABLE estudiante (
    ID SERIAL PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Apellidos VARCHAR(128) NOT NULL,
    Correo_institucional VARCHAR(100) UNIQUE NOT NULL,
    Num_tel VARCHAR(10),
    Codigo_estudiante VARCHAR(9) UNIQUE NOT NULL,
    Carrera VARCHAR(50) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    Estado VARCHAR(20) DEFAULT 'activo',
    Foto BYTEA,
    Habilidades TEXT
);



CREATE TABLE asesor (
    ID SERIAL PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Apellidos VARCHAR(128) NOT NULL,
    Codigo VARCHAR(9) UNIQUE NOT NULL,
    Correo_institucional VARCHAR(100) UNIQUE NOT NULL,
    Departamento VARCHAR(100) NOT NULL,
    Foto BYTEA,
    Clave VARCHAR(255) NOT NULL
);


CREATE TABLE proyecto (
    ID_proyecto SERIAL PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT NOT NULL,
    Area VARCHAR(100) NOT NULL,
    Cupos INT CHECK (Cupos <= 3) NOT NULL,
    Estado VARCHAR(20) DEFAULT 'activo',
    Asesor VARCHAR(100),
    Conocimientos_requeridos TEXT,
    Nivel_innovacion VARCHAR(20) NOT NULL,
    Logo BYTEA
);


CREATE TABLE lider (
    ID SERIAL PRIMARY KEY,
    ID_estudiante INT REFERENCES estudiante(ID) ON DELETE CASCADE,
    ID_proyecto INT REFERENCES proyecto(ID_proyecto) ON DELETE CASCADE
);

