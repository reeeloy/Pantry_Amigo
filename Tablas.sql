CREATE DATABASE Tbl_Pantry_Amigo

CREATE TABLE  Tbl_Usuario (
    Usu_Cedula  int (10) NOT NULL,
    Usu_Nombre Varchar (25) NOT NULL,
    Usu_Apellido Varchar (25) NOT NULL,
     PRIMARY KEY (Usu_Cedula)
);

CREATE TABLE  Tbl_Admin (
    Admin_Id  int AUTO_INCREMENT,
    Admin_Correo Varchar (40) NOT NULL,    
    PRIMARY KEY (Admin_Id)
);

CREATE TABLE Tbl_Caso_Donacion (
    Caso_Id Int AUTO_INCREMENT,
    Caso_Telefono Varchar (10) NOT NULL,
    Caso_Correo Varchar (25) NOT NULL,
    Caso_Estado Varchar (20) NOT NULL,
    Caso_Nombre_Fundacion Varchar (40) NOT NULL,
    Caso_Nombre_Caso Varchar (40) NOT NULL,
    Caso_Fecha Date NOT NULL,
    PRIMARY KEY (Caso_Id)
);

CREATE TABLE `tbl_donacion` (
    Don_Id Int AUTO_INCREMENT,
    Don_Nombre_Persona Varchar(20) NOT NULL,
    Don_Correo Varchar(20) NOT NULL,
    Don_Numero_Cuenta Varchar(20) NOT NULL,
    Don_Caso_Id Int(11) NOT NULL,  -- Debe ser Int(11) para coincidir con Caso_Id en tbl_caso_donacion
    Don_Usu_Cedula Int(10) NOT NULL,  -- Debe ser Int(10) para coincidir con Usu_Cedula en tbl_usuario
    PRIMARY KEY (Don_Id),
    FOREIGN KEY (Don_Caso_Id) REFERENCES tbl_caso_donacion(Caso_Id),
    FOREIGN KEY (Don_Usu_Cedula) REFERENCES tbl_usuario(Usu_Cedula)
);


CREATE TABLE Tbl_Informe (
    Inf_Nombre_Caso Varchar (20) NOT NULL,
    Inf_Fundacion_Nombre Varchar (20) NOT NULL,
    Inf_Monto Int (25) NOT NULL,
    Inf_Don_Id Int (10) NOT NULL,
    Inf_Admin_Id Int (10) NOT NULL,
    PRIMARY KEY (Inf_Nombre_Caso),
    FOREIGN KEY (Inf_Don_Id) REFERENCES Tbl_Donacion(Don_Id),
    FOREIGN KEY (Inf_Admin_Id) REFERENCES Tbl_Admin (Admin_Id)
);

CREATE TABLE Tbl_Recursos_Recaudados(
    Recu_Numero_Transaccion Int (10) NOT NULL,
    Recu_Fecha Date NOT NULL,
    Recu_Id_Donante Int (10) NOT NULL,
    Recu_Destino Varchar (30) NOT NULL,
    Recu_Cantidad Int (10) NOT NULL,
    Recu_Descripcion Varchar (30) NOT NULL,
    Recu_Tipo_Recurso Varchar (20) NOT NULL,
    Recu_Inf_Nombre_Caso Varchar (20) NOT NULL,
    PRIMARY KEY (Recu_Numero_Transaccion),
    FOREIGN KEY (Recu_Inf_Nombre_Caso) REFERENCES Tbl_Informe (Inf_Nombre_Caso)
    );
    
   CREATE TABLE Tbl_Confirmacion(
        Con_Correo Int (20) NOT NULL,
        Con_Monto Varchar (20) NOT NULL,
        Con_Nombre_Caso Varchar (20) NOT NULL,
        Con_Don_Id Int (10) NOT NULL,
        PRIMARY KEY (Con_Correo),
        FOREIGN KEY (Con_Don_Id) REFERENCES Tbl_Donacion (Don_Id)
    );

    CREATE TABLE Tbl_Fundaciones( 
        Fund_Id Int (10) NOT NULL,
        Fund_Direccion Varchar (20) NOT NULL,
        Fund_Nombre Varchar (10) NOT NULL,
        Fund_Descipcion Varchar (30) NOT NULL,
        Fund_Casos_Activos Varchar (10) NOT NULL,
        Fund_Telefono Int (10) NOT NULL,
        Fund_Correo Varchar (20) NOT NULL,
        Fund_Don_Id Int (10) NOT NULL,
        PRIMARY KEY (Fund_Id),
        FOREIGN KEY (Fund_Don_id) REFERENCES Tbl_Donacion (Don_Id)
    );
    
    
     CREATE TABLE Tbl_Catalogo_Recursos (
        Cat_Id Varchar (10) NOT NULL,
        Cat_Nombre Varchar (15) NOT NULL,
        Cat_Disponibilidad Varchar (15) NOT NULL,
        Cat_Tipo Varchar (10) NOT NULL,
        Cat_Descripcion Varchar (30) NOT NULL,
        Cat_Fund_Id Int (10) NOT NULL,
        PRIMARY KEY (Cat_Id),
        FOREIGN KEY Cat_Fund_Id REFERENCES Tbl_Fundaciones (Fund_Id)
    );
    
    CREATE TABLE Tbl_Lista_Participantes (
        List_Correo Varchar (20) NOT NULL,
        List_Nombre Varchar (15) NOT NULL,
        List_Apellido Varchar (15) NOT NULL,
        List_Telefono Varchar (10) NOT NULL,
        List_Direccion Varchar (20) NOT NULL,
        List_Fund_Id Int (10) NOT NULL,
        PRIMARY KEY (List_Correo),
        FOREIGN KEY (List_Fund_Id) REFERENCES Tbl_Fundaciones (Fund_Id)
    );
    
    CREATE TABLE Tbl_Horarios_Voluntarios (
        Hora_Id Int (10) NOT NULL,
        Hora_Disponibilidad Varchar (15) NOT NULL,
        Hora_Compromiso Varchar (15) NOT NULL,
        Hora_Localizacion Varchar (20) NOT NULL,
        Hora_List_Correo Varchar (20) NOT NULL,
        PRIMARY KEY (Hora_Id),
        FOREIGN KEY (Hora_List_Correo) REFERENCES Tbl_Lista_Participantes (List_Correo)
    );

    
