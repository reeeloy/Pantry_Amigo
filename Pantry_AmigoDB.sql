CREATE DATABASE Pantry_Amigo;

USE Pantry_Amigo;

CREATE TABLE Tbl_Usuario (
    Usu_Id INT(10) NOT NULL,
    Usu_Username VARCHAR(20) NOT NULL,
    Usu_Password VARCHAR(20) NOT NULL,
    Usu_Tipo VARCHAR(30) NOT NULL,
    Usu_Correo VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (Usu_Id)
);

CREATE TABLE Tbl_Administrador (
    Admin_Id INT AUTO_INCREMENT,
    Admin_Username VARCHAR(40) NOT NULL,
    Admin_Password VARCHAR(20) NOT NULL,
    Admin_Correo VARCHAR(50) NOT NULL UNIQUE,
    Admin_Usu_Id INT(10) NOT NULL,
    PRIMARY KEY (Admin_Id),
    FOREIGN KEY (Admin_Usu_Id) REFERENCES Tbl_Usuario(Usu_Id)
);

CREATE TABLE Tbl_Fundaciones (
    Fund_Id INT(10) NOT NULL,
    Fund_Correo VARCHAR(50) NOT NULL UNIQUE,
    Fund_Username VARCHAR(40) NOT NULL,
    Fund_Direccion VARCHAR(20) NOT NULL,
    Fund_Casos_Activos INT(10) NOT NULL,
    Fund_Telefono INT(10) NOT NULL,
    Fund_Usu_Id INT(10) NOT NULL UNIQUE,
    PRIMARY KEY (Fund_Id),
    FOREIGN KEY (Fund_Usu_Id) REFERENCES Tbl_Usuario(Usu_Id)
);

CREATE TABLE Tbl_Caso_Donacion (
    Caso_Id VARCHAR(15) NOT NULL,
    Caso_Nombre_Caso VARCHAR(40) NOT NULL,
    Caso_Descripcion VARCHAR(255) NOT NULL,
    Caso_Fecha_Inicio DATE NOT NULL,
    Caso_Fecha_Fin DATE NOT NULL,
    Caso_Estado VARCHAR(20) NOT NULL,
    Caso_Fund_Id INT(10) NOT NULL,
    PRIMARY KEY (Caso_Id),
    FOREIGN KEY (Caso_Fund_Id) REFERENCES Tbl_Fundaciones(Fund_Id)
);

CREATE TABLE Tbl_Donante (
    Dona_Cedula INT(10) NOT NULL,
    Dona_Nombre VARCHAR(20) NOT NULL,
    Dona_Nombre_Recurso VARCHAR(15) NOT NULL,
    Dona_Apellido VARCHAR(40) NOT NULL,
    Dona_Correo VARCHAR(40) NOT NULL,
    Dona_Tipo_Donacion VARCHAR(40) NOT NULL,
    PRIMARY KEY (Dona_Cedula)
);

CREATE TABLE Tbl_Categorias (
    Cat_Id INT AUTO_INCREMENT,
    Cat_Nombre VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (Cat_Id)
);
CREATE TABLE Tbl_Donacion_Recursos (
    Rec_Id INT(10) NOT NULL,
    Rec_Nombre VARCHAR(15) NOT NULL,
    Rec_Cantidad INT NOT NULL CHECK (Rec_Cantidad >= 0),
    Rec_Disponibilidad VARCHAR(15) NOT NULL,
    Rec_Tipo VARCHAR(10) NOT NULL,
    Rec_Descripcion VARCHAR(30) NOT NULL,
    Rec_Caso_Id VARCHAR(15) NOT NULL,
    Rec_Dona_Cedula INT(10) NOT NULL,
    Rec_Fecha_Caducidad DATE NOT NULL,
    Rec_Cat_Nombre VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (Rec_Id),
    FOREIGN KEY (Rec_Caso_Id) REFERENCES Tbl_Caso_Donacion(Caso_Id),
    FOREIGN KEY (Rec_Dona_Cedula) REFERENCES Tbl_Donante(Dona_Cedula),
    FOREIGN KEY (Rec_Cat_Nombre) REFERENCES Tbl_Categorias(Cat_Nombre)
    );

CREATE TABLE Tbl_Voluntarios (
    Vol_Cedula INT(10) NOT NULL,
    Vol_Nombre VARCHAR(40) NOT NULL,
    Vol_Apellido VARCHAR(40) NOT NULL,
    Vol_Correo VARCHAR(40) NOT NULL,
    Vol_Celular INT(10) NOT NULL,
    Vol_Caso_Id VARCHAR(15) NOT NULL,
    PRIMARY KEY (Vol_Cedula),
    FOREIGN KEY (Vol_Caso_Id) REFERENCES Tbl_Caso_Donacion(Caso_Id)
);

CREATE TABLE Tbl_Horarios_Voluntarios (
    Hora_Id INT(10) NOT NULL,
    Hora_Citacion DATETIME NOT NULL,
    Hora_Localizacion VARCHAR(40) NOT NULL,
    Hora_Vol_Cedula INT(10) NOT NULL,
    PRIMARY KEY (Hora_Id),
    FOREIGN KEY (Hora_Vol_Cedula) REFERENCES Tbl_Voluntarios(Vol_Cedula)
);

CREATE TABLE Tbl_Donacion_Dinero (
    Don_Id INT(10) NOT NULL,
    Don_Monto VARCHAR(20) NOT NULL,
    Don_Fecha DATE NOT NULL,
    Don_Correo VARCHAR(40) NOT NULL,
    Don_Metodo_Pago VARCHAR(40) NOT NULL,
    Don_Dona_Cedula INT(10) NOT NULL,
    Don_Caso_Id VARCHAR(15) NOT NULL,
    PRIMARY KEY (Don_Id),
    FOREIGN KEY (Don_Caso_Id) REFERENCES Tbl_Caso_Donacion(Caso_Id),
    FOREIGN KEY (Don_Dona_Cedula) REFERENCES Tbl_Donante(Dona_Cedula)
);




/* Ejemplo de inserción de datos*/
INSERT INTO Tbl_Usuario (Usu_Id, Usu_Username, Usu_Password, Usu_Tipo, Usu_Correo) VALUES
(111, 'admin01', 'password123', 'Administrador', 'admin01@example.com'),
(222, 'admin02', 'password321', 'Administrador', 'admin02@example.com'),
(333, 'admin03', 'password987', 'Administrador', 'admin03@example.com'),
(444, 'admin04', 'password888', 'Administrador', 'admin04@example.com'),
(555, 'admin05', 'password999', 'Administrador', 'admin05@example.com'),
(666, 'admin06', 'password000', 'Administrador', 'admin06@example.com'),
(777, 'admin07', 'password111', 'Administrador', 'admin07@example.com'),
(888, 'fundacion01', 'password456', 'Fundación', 'contacto@fundacion01.org'),
(999, 'fundacion02', 'password789', 'Fundación', 'contacto@fundacion02.org'),
(101010, 'fundacion03', 'password654', 'Fundación', 'contacto@fundacion03.org'),
(111111, 'fundacion04', 'password147', 'Fundación', 'contacto@fundacion04.org'),
(121212, 'fundacion05', 'password779', 'Fundación', 'contacto@fundacion05.org'),
(131313, 'fundacion06', 'password197', 'Fundación', 'contacto@fundacion06.org'),
(141414, 'fundacion07', 'password426', 'Fundación', 'contacto@fundacion07.org');

INSERT INTO Tbl_Administrador (Admin_Id, Admin_Username, Admin_Password, Admin_Correo,Admin_Usu_Id) 
VALUES 
(001, 'admin01', 'password123', 'admin01@example.com',111),
(002, 'admin02', 'password321', 'admin02@example.com',222),
(003, 'admin03', 'password987', 'admin03@example.com',333),
(004, 'admin04', 'password888', 'admin04@example.com',444),
(005, 'admin05', 'password999','admin05@example.com',555),
(006, 'admin06', 'password000', 'admin06@example.com',666),
(007, 'admin07', 'password111', 'admin07@example.com',777);

INSERT INTO Tbl_Fundaciones (Fund_Id, Fund_Correo, Fund_Username, Fund_Direccion, Fund_Casos_Activos, Fund_Telefono, Fund_Usu_Id) 
VALUES 
(008, 'contacto@fundacion01.org' ,'fundacion01', 'Calle 123', 1, 1234567890, 888),
(009, 'contacto@fundacion02.org','fundacion02', 'Avenida 456', 2, 2345678901, 999),
(010, 'contacto@fundacion03.org','fundacion03', 'Calle 789', 2, 3456789012, 101010),
(011, 'contacto@fundacion04.org','fundacion04', 'Avenida 101', 1, 4567890123, 111111),
(012, 'contacto@fundacion05.org','fundacion05', 'Calle 205', 0, 1234567890, 121212),
(013, 'contacto@fundacion06.org','fundacion06', 'Avenida 88', 0, 2345678901, 131313),
(014, 'contacto@fundacion07.org','fundacion07', 'Carrera 114', 1, 3456789012, 141414);


INSERT INTO Tbl_Caso_Donacion (Caso_Id, Caso_Nombre_Caso, Caso_Descripcion, Caso_Fecha_Inicio, Caso_Fecha_Fin, Caso_Estado, Caso_Fund_Id) 
VALUES 
('C001', 'Educación Infantil', 'Proveer recursos educativos a niños en zonas rurales.', '2024-01-10', '2024-12-31','Activo', 8), 
('C002', 'Dia del niño', 'Campaña de regalos para niños.', '2024-02-15', '2024-11-30','Inactivo', 9),
 ('C003', 'Alimentación Escolar', 'Proveer alimentos a escuelas en zonas marginadas.', '2024-03-20', '2024-09-30','Activo', 11),
('C004', 'Reforestación Urbana', 'Proyecto de plantación de árboles en áreas urbanas.', '2024-04-01', '2024-10-31','Activo',10),
('C005', 'Vivienda Digna', 'Construcción de viviendas para familias en situación de pobreza.', '2024-05-05', '2024-12-31','Activo', 14),
('C006', 'Atención Médica', 'Proveer atención médica gratuita en zonas rurales.', '2024-06-10', '2024-12-31','Inactivo', 9),
('C007', 'Empoderamiento Juvenil', 'Programa de capacitación laboral para jóvenes.', '2024-07-15', '2024-12-31','Inactivo', 10);

INSERT INTO Tbl_Donante (Dona_Cedula, Dona_Nombre, Dona_Nombre_Recurso, Dona_Apellido, Dona_Correo, Dona_Tipo_Donacion) 
VALUES
(2001, 'Pedro', 'Libros', 'Sánchez', 'pedro.sanchez@example.com', 'Educativa'),
(2002, 'Elena', 'Vacunas', 'Fernández', 'elena.fernandez@example.com', 'Salud'),
(2003, 'Roberto', 'Comida', 'Ramírez', 'roberto.ramirez@example.com', 'Alimentación'), (2004, 'Patricia', 'Árboles', 'González', 'patricia.gonzalez@example.com', 'Medio Ambiente'),
(2005, 'Miguel', 'Material de construcción', 'Torres', 'miguel.torres@example.com', 'Vivienda'),
(2006, 'Claudia', 'Medicinas', 'Vega', 'claudia.vega@example.com', 'Salud'),
(2007, 'Sergio', 'Equipos de cómputo', 'Morales', 'sergio.morales@example.com', 'Capacitación');



INSERT INTO Tbl_Voluntarios (Vol_Cedula, Vol_Nombre, Vol_Apellido, Vol_Correo, Vol_Celular, Vol_Caso_Id) 
VALUES 
(1001, 'Juan', 'Pérez', 'juan.perez@example.com', 1234567890, 'C001'), 
(1002, 'María', 'García', 'maria.garcia@example.com', 2345678901, 'C002'),
(1003, 'Luis', 'Martínez', 'luis.martinez@example.com', 3456789012, 'C003'),
(1004, 'Ana', 'Rodríguez', 'ana.rodriguez@example.com', 4567890123, 'C004'), 
(1005, 'Carlos', 'Hernández', 'carlos.hernandez@example.com', 5678901234, 'C005'), 
(1006, 'Laura', 'López', 'laura.lopez@example.com', 6789012345, 'C006'), 
(1007, 'Jorge', 'Gómez', 'jorge.gomez@example.com', 7890123456, 'C007');





INSERT INTO Tbl_Horarios_Voluntarios (Hora_Id, Hora_Citacion, Hora_Localizacion, Hora_Vol_Cedula) 
VALUES
(01, '2024-09-01 09:00:00', 'Escuela Rural', 1001),
(02, '2024-09-02 10:00:00', 'Centro Comunitario', 1002),
(03, '2024-09-03 08:00:00', 'Comedor Escolar', 1003),
(04, '2024-09-04 07:00:00', 'Parque Central', 1004),
(05, '2024-09-05 09:30:00', 'Construcción de Viviendas', 1005),
(06, '2024-09-06 08:30:00', 'Clínica Rural', 1006),
(07, '2024-09-07 11:00:00', 'Centro Juvenil', 1007);


INSERT INTO tbl_Donacion_Dinero (Don_Id,Don_Monto,Don_Fecha,Don_Correo,Don_Metodo_Pago,Don_Dona_Cedula,Don_Caso_Id) 
VALUES 
(3001, '500 USD', '2024-09-01', 'pedro.sanchez@example.com', 'Transferencia Bancaria',2001, 'C002'),
(3002, '1200 USD', '2024-09-02', 'elena.fernandez@example.com', 'PayPal', 2002 ,'C005'), 
(3003, '800 USD', '2024-09-03', 'roberto.ramirez@example.com', 'Tarjeta de Crédito', 2003 ,'C007'),
(3004, '1000 USD', '2024-09-04', 'patricia.gonzalez@example.com', 'Transferencia Bancaria', 2004 ,'C004'),
(3005, '1500 USD', '2024-09-05', 'miguel.torres@example.com', 'PayPal', 2005 ,'C004'), 
(3006, '700 USD', '2024-09-06', 'claudia.vega@example.com', 'Tarjeta de Crédito', 2006 ,'C002'), 
(3007, '950 USD', '2024-09-07', 'sergio.morales@example.com', 'Transferencia Bancaria', 2007 ,'C003');

INSERT INTO Tbl_Donacion_Recursos (Rec_Id, Rec_Nombre,Rec_Cantidad, Rec_Disponibilidad, Rec_Tipo, Rec_Descripcion,Rec_Dona_Cedula, Rec_Caso_Id) 
VALUES 
(705, 'Libros', 12,  'Disponible', 'Educación', 'Libros de texto y material educativo.',2001, 'C002'),
(818, 'Juguetes',23, 'Disponible', 'Juguetería', 'Regalos para niños.',2003 ,'C002'),
(699, 'Comida',7, 'Disponible', 'Alimentación', 'Alimentos para niños en escuelas.',2005, 'C003'),
(423, 'Árboles',3, 'Disponible', 'Medio Ambiente', 'Plantas para reforestación.',2004, 'C004'),
(672, 'Material de construcción',8, 'Disponible', 'Vivienda', 'Materiales para construir viviendas', 2007, 'C005' ),
(698, 'Medicinas',12, 'Disponible', 'Salud', 'Medicamentos para atención médica.', 2001,'C006'),
(201, 'Equipos de cómputo',2, 'Disponible', 'Capacitación', 'Computadoras para capacitación.' ,2006,'C001');


/*Procedimiento para obtener donaciones monetarias*/
DELIMITER $$
CREATE PROCEDURE ObtenerDonacionesMonetarias()
BEGIN
    SELECT 
        d.Dona_Cedula AS Cedula_Donador,
        d.Dona_Nombre AS Nombre_Donador,
        d.Dona_Apellido AS Apellido_Donador,
        dd.Don_Fecha AS Fecha_Donador,
        dd.Don_Monto AS Monto_Donado,
        dd.Don_Id AS Id_Donacion
    FROM 
        Tbl_Donante d
    INNER JOIN 
        Tbl_Donacion_Dinero dd ON d.Dona_Cedula = dd.Don_Dona_Cedula;
END$$
DELIMITER ;

/*Llamada al procedimiento*/
CALL ObtenerDonacionesMonetarias();








/*Procedimiento para obtener casos por fundación*/
DELIMITER $$
CREATE PROCEDURE ObtenerCasosPorFundacion()
BEGIN
    SELECT 
        f.Fund_Username AS NombreFundacion,
        c.Caso_Nombre_Caso AS NombreCaso,
        c.Caso_Descripcion AS DescripcionCaso,
        c.Caso_Fecha_Inicio AS FechaInicio,
        c.Caso_Fecha_Fin AS FechaFin
    FROM 
        Tbl_Caso_Donacion c
    INNER JOIN 
        Tbl_Fundaciones f ON c.Caso_Fund_Id = f.Fund_Id;
END$$
DELIMITER ;

/*Llamada al procedimiento*/
CALL ObtenerCasosPorFundacion();

/*Procedimiento para actualizar un usuario*/

DROP PROCEDURE IF EXISTS UpdateUsuario;
DELIMITER $$
CREATE PROCEDURE UpdateUsuario(
    IN p_Usu_Id INT(10),
    IN p_Usu_Username VARCHAR(20),
    IN p_Usu_Password VARCHAR(20)
)
BEGIN
    UPDATE Tbl_Usuario
    SET Usu_Username = p_Usu_Username, 
        Usu_Password = p_Usu_Password
    WHERE Usu_Id = p_Usu_Id;
END$$
DELIMITER ;

/*Llamada al procedimiento*/
CALL UpdateUsuario(141414, 'fundacion0007', 'passworddd426');

/*Procedimiento para insertar un donante*/
DELIMITER $$
CREATE PROCEDURE InsertarDonante(
    IN p_Dona_Cedula INT,
    IN p_Dona_Nombre VARCHAR(20),
    IN p_Dona_Nombre_Recurso VARCHAR(15),
    IN p_Dona_Apellido VARCHAR(40),
    IN p_Dona_Correo VARCHAR(40),
    IN p_Dona_Tipo_Donacion VARCHAR(40)
)
BEGIN
    INSERT INTO Tbl_Donante (
        Dona_Cedula,
        Dona_Nombre,
        Dona_Nombre_Recurso, 
        Dona_Apellido,
        Dona_Correo,
        Dona_Tipo_Donacion
    ) 
    VALUES (
        p_Dona_Cedula,
        p_Dona_Nombre,
        p_Dona_Nombre_Recurso,
        p_Dona_Apellido,
        p_Dona_Correo,
        p_Dona_Tipo_Donacion
    );
END$$
DELIMITER ;

/*Llamada al procedimiento*/
CALL InsertarDonante(1234567890, 'Nicolas', 'Salazar', 'Arroz', 'nicolassalazar@correoejemplo.com', 'Alimentos');

/*Procedimiento para eliminar un donante*/
DELIMITER $$
CREATE PROCEDURE EliminarDonante(
    IN donante_cedula INT
)
BEGIN
    DELETE FROM Tbl_Donante 
    WHERE Dona_Cedula = donante_cedula;
END$$
DELIMITER ;

/*Vista de casos por fundación*/
CREATE VIEW View_Casos AS
SELECT 
    c.Caso_Id, 
    c.Caso_Nombre_Caso AS Caso_Nombre, 
    c.Caso_Estado, 
    f.Fund_Id, 
    f.Fund_Username
FROM 
    Tbl_Caso_Donacion c
JOIN 
    Tbl_Fundaciones f ON c.Caso_Fund_Id = f.Fund_Id;

/*Mostrar vistas en la base de datos*/
SHOW FULL TABLES WHERE table_type = 'VIEW';


/*Vista de voluntarios*/

CREATE OR REPLACE VIEW Voluntarios_cedula_nombre_apellido AS
SELECT
 Vol_Cedula,    
 Vol_Nombre,
 Vol_Apellido
FROM Tbl_Voluntarios
    
/*TRIGGERS*/
    
CREATE TABLE Audi_Caso_Donacion (
    id_Audi Int AUTO_INCREMENT,
    Caso_Id_Audi Varchar (15) NOT NULL,
    Caso_Nombre_Caso_Anterior Varchar (40) NOT NULL,
    Caso_Descripcion_Anterior Varchar (255) NOT NULL,
    Caso_Fecha_Inicio_Anterior date NOT NULL,
    Caso_Fecha_Fin_Anterior Date NOT NULL,
    Caso_Estado_Anterior Date NOT NULL,
    Caso_Nombre_Caso_Nuevo Varchar (40) NOT NULL,
    Caso_Descripcion_Nuevo Varchar (255) NOT NULL,
    Caso_Fecha_Inicio_Nuevo date NOT NULL,
    Caso_Fecha_Fin_Nuevo Date NOT NULL,
    Caso_Estado_Nuevo Date NOT NULL,
    Audi_Fecha_Modificacion Datetime,
    Audi_Usuario Varchar (10) NOT NULL,
    Audi_Accion Varchar (45) NOT NULL,
    PRIMARY KEY (Id_Audi)
);


DROP TRIGGER IF EXISTS Donacion_recursos_Update;
CREATE TRIGGER Donacion_recursos_Update
BEFORE UPDATE ON tbl_caso_donacion
FOR EACH ROW
INSERT INTO audi_caso_donacion (
    Caso_Id_Audi,
    Caso_Nombre_Caso_Anterior,
    Caso_Descripcion_Anterior,
    Caso_Fecha_Inicio_Anterior,
    Caso_Fecha_Fin_Anterior,
    Caso_Estado_Anterior,
    Caso_Nombre_Caso_Nuevo,
    Caso_Descripcion_Nuevo,
    Caso_Fecha_Inicio_Nuevo,
    Caso_Fecha_Fin_Nuevo,
    Caso_Estado_Nuevo,
    Audi_Fecha_Modificacion,
    Audi_Usuario,
    Audi_Accion
)
VALUES (
    NEW.Caso_Id,
    OLD.Caso_Nombre_Caso,
    OLD.Caso_Descripcion,
    OLD.Caso_Fecha_Inicio,
    OLD.Caso_Fecha_Fin,
    OLD.Caso_Estado,
    NEW.Caso_Nombre_Caso,
    NEW.Caso_Descripcion,
    NEW.Caso_Fecha_Inicio,
    NEW.Caso_Fecha_Fin,
    NEW.Caso_Estado,
    NOW(),
    CURRENT_USER(),
    'Actualizacion'
);

UPDATE tbl_caso_donacion SET Caso_Nombre_Caso = '	
Educación Infantil y niño', Caso_Descripcion = 'Proveer recursos educativos a niños en zonas rural'
WHERE Caso_Id = 'C007'

SELECT * FROM audi_caso_donacion;


CREATE TABLE Audi_Donante (
    Id_Audi Int AUTO_INCREMENT,
    Dona_Cedula_Audi Int (10) NOT NULL,
    Dona_Nombre_Anterior Varchar (20) NOT NULL,
    Dona_Nombre_Recurso_Anterior Varchar (15) NOT NULL,
    Dona_Apellido_Anterior Varchar (40) NOT NULL,
    Dona_Correo_Anterior Varchar (40) NOT NULL,
    Dona_Tipo_Donacion_Anterior Varchar (40) NOT NULL,
    Dona_Nombre_Nuevo Varchar (20) NOT NULL,
    Dona_Nombre_Recurso_Nuevo Varchar (15) NOT NULL,
    Dona_Apellido_Nuevo Varchar (40) NOT NULL,
    Dona_Correo_Nuevo Varchar (40) NOT NULL,
    Dona_Tipo_Donacion_Nuevo Varchar (40) NOT NULL,
    Audi_Fecha_Modificacion Datetime,
    Audi_Usuario Varchar (10) NOT NULL,
    Audi_Accion Varchar (45) NOT NULL,
    PRIMARY KEY (Id_Audi)
    );


DELIMITER //

CREATE TRIGGER after_donante_delete
AFTER DELETE ON tbl_donante
FOR EACH ROW
BEGIN
    INSERT INTO audi_donante (
        Dona_Cedula_Audi,
        Dona_Nombre_Anterior,
        Dona_Nombre_Recurso_Anterior,
        Dona_Apellido_Anterior,
        Dona_Correo_Anterior,
        Dona_Tipo_Donacion_Anterior,
        Audi_Fecha_Modificacion,
        Audi_Usuario,
        Audi_Accion) 
    VALUES (
        old.Dona_Cedula,
        old.Dona_Nombre,
        old.Dona_Nombre_Recurso,
        old.Dona_Apellido,
        old.Dona_Correo,
        old.Dona_Tipo_Donacion,
        NOW(),
        CURRENT_USER(),
        'Eliminacion'
    );
END //

DELIMITER ;

DELETE FROM tbl_donante 
WHERE Dona_Cedula = 1234567890

SELECT *FROM audi_donante

    
/*INDEX*/

INDICE PARA  buscar casos y su estado

CREATE INDEX index_estado
ON tbl_caso_donacion(Caso_Nombre_Caso , Caso_Estado);


SHOW INDEXES IN tbl_caso_donacion

INDICE para metodo de pago

CREATE INDEX index_Metodo_Pago
ON tbl_donacion_dinero(Don_Metodo_Pago,Don_Id, Don_Monto);


SHOW INDEXES IN Tbl_Donacion_Dinero

EXPLAIN SELECT *
FROM Tbl_Donacion_Dinero
WHERE Don_Metodo_Pago = 'Tarjeta de Crédito';


