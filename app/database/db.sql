CREATE DATABASE TiendaRopa;
USE TiendaRopa;

CREATE TABLE productos (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    tipo    VARCHAR(40)     NOT NULL,
    genero  CHAR(1)         NOT NULL CHECK (genero IN ('M', 'F', 'U')),
    talla   VARCHAR(10)     NOT NULL,
    precio  DECIMAL(10,2)   NOT NULL
) ENGINE=INNODB;

-- Tabla de usuarios 
CREATE TABLE usuarios (
    id_usuario       INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo  VARCHAR(100) 	NOT NULL,
    nombre_usuario   VARCHAR(50) 	UNIQUE NOT NULL,
    telefono         CHAR(9) 		UNIQUE NOT NULL,
    email            VARCHAR(100) 	UNIQUE NOT NULL,
    contraseña       VARCHAR(50) 	NOT NULL,
    fecha_creacion   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB;

INSERT INTO productos (tipo, genero, talla, precio) VALUES
    ("Pantalon", 'F', '28', 75.00),
    ("Camisa", 'M', 'L', 120.00),
    ("Zapatillas", 'U', '42', 150.00);  
    
INSERT INTO usuarios (nombre_completo, nombre_usuario, telefono, email, contraseña) VALUES
    ('Juan Pérez', 'juanp', '987654321', 'juanp@example.com', '123456'),
    ('María López', 'marial', '956123789', 'marial@example.com', '1234567');

SELECT * FROM productos;

SELECT * FROM usuarios;

DROP DATABASE TiendaRopa; 