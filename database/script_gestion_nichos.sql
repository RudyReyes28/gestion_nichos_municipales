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
    motivo TEXT,
    fecha_exhumacion DATE,
    estado VARCHAR(20),
    FOREIGN KEY (id_contrato) REFERENCES CONTRATO_NICHO(id_contrato)
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


CREATE VIEW vista_contratos_completa AS
SELECT 
    cn.id_contrato,
    cn.fecha_inicio,
    cn.fecha_fin,
    cn.fecha_gracia,
    cn.estado_contrato,
    cn.estado_pago,

    -- Usuario que genera el contrato
    au.usuario AS usuario_generador,
    tu.tipo_usuario,

    -- Responsable
    r.id_persona AS id_responsable,
    r.nombre AS nombre_responsable,
    r.apellido AS apellido_responsable,
    r.dpi AS dpi_responsable,

    -- Ocupante
    o.id_ocupante,
    p_ocu.nombre AS nombre_ocupante,
    p_ocu.apellido AS apellido_ocupante,
    o.fecha_fallecimiento,
    tm.nombre_causa AS causa_muerte,
    tocu.tipo AS tipo_ocupante,

    -- Nicho
    n.id_nicho,
    n.descripcion AS descripcion_nicho,
    n.estado AS estado_nicho,
    tn.nombre_tipo AS tipo_nicho,

    -- Ubicación del nicho
    ub.descripcion AS descripcion_ubicacion,
    c.nombre_calle,
    a.nombre_avenida

FROM CONTRATO_NICHO cn

-- Usuario que genera el contrato
JOIN AUTENTICACION au ON cn.id_usuario_generador = au.id_autenticacion
JOIN TIPO_USUARIO tu ON au.id_tipo_usuario = tu.id_tipo_usuario

-- Responsable del contrato
JOIN PERSONA r ON cn.id_responsable = r.id_persona

-- Ocupante del nicho
JOIN OCUPANTE o ON cn.id_ocupante = o.id_ocupante
JOIN PERSONA p_ocu ON o.id_persona = p_ocu.id_persona
LEFT JOIN TIPOS_CAUSA_MUERTE tm ON o.id_tipo_muerte = tm.id_tipo_muerte
JOIN TIPO_OCUPANTE tocu ON o.id_tipo_ocupante = tocu.id_tipo_ocupante

-- Información del nicho
JOIN NICHOS n ON cn.id_nicho = n.id_nicho
LEFT JOIN TIPO_NICHO tn ON n.id_tipo_nicho = tn.id_tipo_nicho
LEFT JOIN UBICACION_NICHO ub ON n.id_ubicacion_nicho = ub.id_ubicacion_nicho
LEFT JOIN CALLE c ON ub.id_calle = c.id_calle
LEFT JOIN AVENIDA a ON ub.id_avenida = a.id_avenida;

SELECT * FROM vista_contratos_completa;

SELECT * 
FROM vista_contratos_completa
WHERE estado_contrato = 'solicitado';



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
