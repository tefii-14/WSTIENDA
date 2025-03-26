CREATE DATABASE TiendaRopa;
USE TiendaRopa;

CREATE TABLE productos (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    tipo    VARCHAR(40)     NOT NULL,
    genero  CHAR(1)         NOT NULL CHECK (genero IN ('M', 'F', 'U')),
    talla   VARCHAR(10)     NOT NULL,
    precio  DECIMAL(10,2)   NOT NULL
) ENGINE=INNODB;

INSERT INTO productos (tipo, genero, talla, precio) VALUES
    ("Pantalon", 'F', '28', 75.00),
    ("Camisa", 'M', 'L', 120.00),
    ("Zapatillas", 'U', '42', 150.00);  

SELECT * FROM productos;

DROP DATABASE TiendaRopa; 