CREATE DATABASE IF NOT EXISTS gestion_nichos;
USE gestion_nichos;

CREATE TABLE DEPARTAMENTO (
    id_departamento INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE MUNICIPIO (
    id_municipio INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_departamento INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_departamento) REFERENCES DEPARTAMENTO(id_departamento)
);

CREATE TABLE DIRECCION (
    id_direccion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_municipio INT NOT NULL,
    descripcion VARCHAR(255),
    FOREIGN KEY (id_municipio) REFERENCES MUNICIPIO(id_municipio)
);

CREATE TABLE PERSONA (
    id_persona INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    dpi VARCHAR(13) UNIQUE
);

CREATE TABLE TIPO_USUARIO (
    id_tipo_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo_usuario VARCHAR(50) NOT NULL
);

CREATE TABLE AUTENTICACION (
    id_autenticacion INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    id_tipo_usuario INT NOT NULL,
    usuario VARCHAR(100),
    contrasenia VARCHAR(255),
    estado VARCHAR(20),
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona),
    FOREIGN KEY (id_tipo_usuario) REFERENCES TIPO_USUARIO(id_tipo_usuario)
);

CREATE TABLE CONTACTO_PERSONA (
    id_contacto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100) UNIQUE,
    id_direccion INT,
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona),
    FOREIGN KEY (id_direccion) REFERENCES DIRECCION(id_direccion)
);

CREATE TABLE AVENIDA (
    id_avenida INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_avenida VARCHAR(100) NOT NULL
);

CREATE TABLE CALLE (
    id_calle INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_calle VARCHAR(100) NOT NULL
);

CREATE TABLE UBICACION_NICHO (
    id_ubicacion_nicho INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_calle INT,
    id_avenida INT,
    descripcion VARCHAR(255),
    FOREIGN KEY (id_calle) REFERENCES CALLE(id_calle),
    FOREIGN KEY (id_avenida) REFERENCES AVENIDA(id_avenida)
);

CREATE TABLE TIPO_NICHO (
    id_tipo_nicho INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_tipo VARCHAR(50) NOT NULL
);

CREATE TABLE NICHOS (
    id_nicho INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_tipo_nicho INT,
    id_ubicacion_nicho INT,
    descripcion VARCHAR(255),
    estado VARCHAR(20),
    FOREIGN KEY (id_tipo_nicho) REFERENCES TIPO_NICHO(id_tipo_nicho),
    FOREIGN KEY (id_ubicacion_nicho) REFERENCES UBICACION_NICHO(id_ubicacion_nicho)
);

CREATE TABLE TIPOS_CAUSA_MUERTE (
    id_tipo_muerte INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_causa VARCHAR(100) NOT NULL
);

CREATE TABLE TIPO_OCUPANTE (
    id_tipo_ocupante INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL
);

CREATE TABLE OCUPANTE (
    id_ocupante INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    fecha_fallecimiento DATE,
    id_tipo_muerte INT,
    id_tipo_ocupante INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona),
    FOREIGN KEY (id_tipo_muerte) REFERENCES TIPOS_CAUSA_MUERTE(id_tipo_muerte),
    FOREIGN KEY (id_tipo_ocupante) REFERENCES TIPO_OCUPANTE(id_tipo_ocupante)
);

CREATE TABLE CONTRATO_NICHO (
    id_contrato INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario_generador INT NOT NULL,
    id_nicho INT NOT NULL,
    id_ocupante INT NOT NULL,
    id_responsable INT NOT NULL,
    fecha_inicio DATE,
    fecha_fin DATE,
    fecha_gracia DATE,
    estado_contrato VARCHAR(20),
    estado_pago VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario_generador) REFERENCES AUTENTICACION(id_autenticacion),
    FOREIGN KEY (id_nicho) REFERENCES NICHOS(id_nicho),
    FOREIGN KEY (id_ocupante) REFERENCES OCUPANTE(id_ocupante),
    FOREIGN KEY (id_responsable) REFERENCES PERSONA(id_persona)
);

CREATE TABLE BOLETA_PAGO (
    id_boleta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    total DECIMAL(10,2),
    estado VARCHAR(20),
    ruta_comprobante VARCHAR(255),
    fecha_emision DATE,
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato)
);

CREATE TABLE REGISTRO_EXHUMACIONES (
    id_exhumacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    persona_solicitante VARCHAR(100),
    id_persona_solicitante INT,
    motivo TEXT,
    fecha_exhumacion DATE,
    estado VARCHAR(20),
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato),
    FOREIGN KEY (id_persona_solicitante) REFERENCES PERSONA(id_persona)
);

CREATE TABLE AUDITORIA (
    id_auditoria INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    tipo_problema VARCHAR(100) NOT NULL,
    id_auditor INT NOT NULL,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    detalles_auditoria TEXT,
    estado VARCHAR(20),
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato),
    FOREIGN KEY (id_auditor) REFERENCES PERSONA(id_persona)
);



SELECT * FROM vista_contratos_completa;

SELECT * FROM vista_personas_completa;

SELECT * FROM vista_contratos_completa WHERE estado_contrato = 'solicitado';

SELECT * FROM vista_contratos_boletas;


SELECT * FROM departamento;
SELECT * FROM municipio;
SELECT * FROM persona;
SELECT * FROM tipo_usuario;
SELECT * FROM contacto_persona;
SELECT * FROM autenticacion;
SELECT * FROM avenida;
SELECT * FROM calle;
SELECT * FROM ubicacion_nicho;
SELECT * FROM  tipo_nicho;
SELECT * FROM nichos;
SELECT * FROM ocupante;
SELECT * FROM contrato_nicho;
SELECT * FROM boleta_pago;
SELECT * FROM tipo_ocupante;
SELECT * FROM registro_exhumaciones;


SELECT * FROM vista_personas_completa WHERE id_persona = 4;

-- CALL procesarPagoBoleta(1);

SELECT * FROM vista_contratos_completa WHERE estado_contrato = 'activo' OR estado_contrato = 'vencido';




-- Estados para la boleta de pago y contrato
-- Nichos: ocupado, disponible, exhumacion
-- Contrato: solicitado, rechazado, pago_pendiente, pago_realizado, activo, exhumacion, vencido, renovado
-- Boleta de pago: pago_pendiente, pago_realizado, pagado