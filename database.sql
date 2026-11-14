
CREATE DATABASE IF NOT EXISTS biblio_express CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblio_express;

CREATE TABLE IF NOT EXISTS libro (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    isbn VARCHAR(50) NOT NULL UNIQUE,
    ano_publicacion INT CHECK (ano_publicacion > 1500),
    idioma VARCHAR(50) NOT NULL,
    numero_paginas INT CHECK (numero_paginas > 0)
);

INSERT INTO libro (titulo, isbn, ano_publicacion, idioma, numero_paginas) VALUES
('Clean Code', '978-0132350884', 2008, 'Inglés', 464),
('Arquitectura Limpia', '978-8441542914', 2017, 'Español', 432);

-- ===== PostgreSQL =====
-- CREATE DATABASE biblio_express;
-- \c biblio_express
-- Cambiar la primera columna por:  id_libro SERIAL PRIMARY KEY,
-- El resto de la tabla y los INSERT son iguales.

USE biblio_express;
SHOW TABLES;
SELECT * FROM libro;