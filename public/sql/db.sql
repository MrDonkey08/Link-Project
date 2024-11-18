-- Creación de BD con soporte directo de Español MX
CREATE DATABASE "link-project"
WITH
    ENCODING 'UTF8'
    LC_COLLATE='es_MX.utf8'
    LC_CTYPE='es_MX.utf8'
    TEMPLATE template0;

-- Elimintación de BD
DROP DATABASE "link-project";
