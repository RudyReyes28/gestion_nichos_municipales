USE gestion_nichos;

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

CREATE VIEW vista_personas_completa AS
SELECT 
    p.id_persona,
    p.nombre AS nombre_persona,
    p.apellido AS apellido_persona,
    p.dpi,
    
    cp.telefono,
    cp.correo,
    cp.id_direccion,
    
    d.descripcion AS direccion,
    m.nombre AS municipio,
    dep.nombre AS departamento

FROM PERSONA p
LEFT JOIN CONTACTO_PERSONA cp ON p.id_persona = cp.id_persona
LEFT JOIN DIRECCION d ON cp.id_direccion = d.id_direccion
LEFT JOIN MUNICIPIO m ON d.id_municipio = m.id_municipio
LEFT JOIN DEPARTAMENTO dep ON m.id_departamento = dep.id_departamento;


CREATE VIEW vista_contratos_boletas AS
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
    a.nombre_avenida,
    
    -- Boletas de pago
    bo.id_boleta,
    bo.total,
    bo.estado AS estado_boleta,
    bo.ruta_comprobante,
    bo.fecha_emision

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
LEFT JOIN AVENIDA a ON ub.id_avenida = a.id_avenida

-- informacion boleta
JOIN boleta_pago bo ON cn.id_contrato = bo.id_contrato;


DELIMITER $$
CREATE PROCEDURE procesarPagoBoleta(IN boleta_id INT)
BEGIN
    DECLARE contrato_id INT;
    DECLARE nicho_id INT;
    DECLARE fecha_inicio_v DATE;
    DECLARE fecha_fin_v DATE;
    DECLARE fecha_gracia_v DATE;

    -- 1. Obtener el id_contrato desde BOLETA_PAGO
    SELECT id_contrato INTO contrato_id
    FROM BOLETA_PAGO
    WHERE id_boleta = boleta_id;

    -- 2. Marcar la boleta como pagada
    UPDATE BOLETA_PAGO
    SET estado = 'pagado'
    WHERE id_boleta = boleta_id;

    -- 3. Obtener el id_nicho desde CONTRATO_NICHO
    SELECT id_nicho INTO nicho_id
    FROM CONTRATO_NICHO
    WHERE id_contrato = contrato_id;

    -- 4. Calcular fechas
    SET fecha_inicio_v = CURDATE();
    SET fecha_fin_v = DATE_ADD(fecha_inicio_v , INTERVAL 6 YEAR);
    SET fecha_gracia_v = DATE_ADD(fecha_inicio_v, INTERVAL 7 YEAR);

    -- 5. Actualizar CONTRATO_NICHO
    UPDATE CONTRATO_NICHO
    SET 
        fecha_inicio = fecha_inicio_v,
        fecha_fin = fecha_fin_v,
        fecha_gracia = fecha_gracia_v,
        estado_contrato = 'activo',
        estado_pago = 'pagado'
    WHERE id_contrato = contrato_id;

    -- 6. Actualizar estado del NICHOS
    UPDATE NICHOS
    SET estado = 'ocupado'
    WHERE id_nicho = nicho_id;

END $$
DELIMITER ;


CREATE VIEW vista_contratos_exhumacion AS
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
    a.nombre_avenida,
    
    ex.id_exhumacion,
    ex.motivo,
    ex.fecha_exhumacion,
    ex.estado AS estado_exhumacion

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
LEFT JOIN AVENIDA a ON ub.id_avenida = a.id_avenida

JOIN registro_exhumaciones ex ON cn.id_contrato = ex.id_contrato;

SELECT * FROM vista_contratos_exhumacion;

DELIMITER $$

CREATE PROCEDURE actualizarEstadoExhumacion(
    IN p_id_exhumacion INT,
    IN p_estado_exhumacion VARCHAR(20)
)
BEGIN
    DECLARE v_id_contrato INT;
    DECLARE v_id_nicho INT;

    -- 1. Actualizar el estado en REGISTRO_EXHUMACIONES
    UPDATE registro_exhumaciones
    SET estado = p_estado_exhumacion
    WHERE id_exhumacion = p_id_exhumacion;

    -- 2. Obtener id_contrato desde REGISTRO_EXHUMACIONES
    SELECT id_contrato INTO v_id_contrato
    FROM registro_exhumaciones
    WHERE id_exhumacion = p_id_exhumacion;

    -- 3. Actualizar estado_contrato a 'exhumacion' en CONTRATO_NICHO
    UPDATE contrato_nicho
    SET estado_contrato = 'exhumacion'
    WHERE id_contrato = v_id_contrato;

    -- 4. Obtener id_nicho desde CONTRATO_NICHO
    SELECT id_nicho INTO v_id_nicho
    FROM contrato_nicho
    WHERE id_contrato = v_id_contrato;

    -- 5. Actualizar estado del nicho a 'disponible'
    UPDATE nichos
    SET estado = 'disponible'
    WHERE id_nicho = v_id_nicho;
    
END $$

DELIMITER ;



CREATE OR REPLACE VIEW vista_ocupantes_completa AS
SELECT 
    o.id_ocupante,
    
    -- Datos de la persona
    p.id_persona,
    p.nombre AS nombre_persona,
    p.apellido AS apellido_persona,
    p.dpi,
    
    -- Contacto de la persona
    cp.id_contacto,
    cp.telefono,
    cp.correo,
    
    -- Dirección de la persona
    d.id_direccion,
    d.descripcion AS descripcion_direccion,
    
    -- Ubicación (municipio, departamento)
    m.id_municipio,
    m.nombre AS nombre_municipio,
    dept.id_departamento,
    dept.nombre AS nombre_departamento,
    
    -- Datos del ocupante
    o.fecha_fallecimiento,
    
    -- Tipo de muerte
    tcm.id_tipo_muerte,
    tcm.nombre_causa AS causa_muerte,
    
    -- Tipo de ocupante
    tocu.id_tipo_ocupante,
    tocu.tipo AS tipo_ocupante
    
FROM 
    OCUPANTE o
    INNER JOIN PERSONA p ON o.id_persona = p.id_persona
    LEFT JOIN CONTACTO_PERSONA cp ON p.id_persona = cp.id_persona
    LEFT JOIN DIRECCION d ON cp.id_direccion = d.id_direccion
    LEFT JOIN MUNICIPIO m ON d.id_municipio = m.id_municipio
    LEFT JOIN DEPARTAMENTO dept ON m.id_departamento = dept.id_departamento
    LEFT JOIN TIPOS_CAUSA_MUERTE tcm ON o.id_tipo_muerte = tcm.id_tipo_muerte
    INNER JOIN TIPO_OCUPANTE tocu ON o.id_tipo_ocupante = tocu.id_tipo_ocupante;


CREATE OR REPLACE VIEW vista_responsables_completa AS
SELECT DISTINCT
    p.id_persona,
    p.nombre AS nombre_persona,
    p.apellido AS apellido_persona,
    p.dpi,
    
    cp.id_contacto,
    cp.telefono,
    cp.correo,
    
    d.id_direccion,
    d.descripcion AS descripcion_direccion,
    
    m.id_municipio,
    m.nombre AS nombre_municipio,
    
    dept.id_departamento,
    dept.nombre AS nombre_departamento
    
FROM 
    CONTRATO_NICHO cn
    INNER JOIN PERSONA p ON cn.id_responsable = p.id_persona
    LEFT JOIN CONTACTO_PERSONA cp ON p.id_persona = cp.id_persona
    LEFT JOIN DIRECCION d ON cp.id_direccion = d.id_direccion
    LEFT JOIN MUNICIPIO m ON d.id_municipio = m.id_municipio
    LEFT JOIN DEPARTAMENTO dept ON m.id_departamento = dept.id_departamento;


CREATE OR REPLACE VIEW vista_usuarios_autenticados AS
SELECT 
    a.id_autenticacion,
    a.usuario AS nombre_usuario,
    a.contrasenia,
    a.estado AS estado_usuario,
    
    p.id_persona,
    p.nombre AS nombre_persona,
    p.apellido AS apellido_persona,
    p.dpi,
    
    tu.id_tipo_usuario,
    tu.tipo_usuario,
    
    cp.id_contacto,
    cp.telefono,
    cp.correo,
    
    d.id_direccion,
    d.descripcion AS descripcion_direccion,
    
    m.id_municipio,
    m.nombre AS nombre_municipio,
    
    dept.id_departamento,
    dept.nombre AS nombre_departamento

FROM 
    AUTENTICACION a
    INNER JOIN PERSONA p ON a.id_persona = p.id_persona
    INNER JOIN TIPO_USUARIO tu ON a.id_tipo_usuario = tu.id_tipo_usuario
    LEFT JOIN CONTACTO_PERSONA cp ON p.id_persona = cp.id_persona
    LEFT JOIN DIRECCION d ON cp.id_direccion = d.id_direccion
    LEFT JOIN MUNICIPIO m ON d.id_municipio = m.id_municipio
    LEFT JOIN DEPARTAMENTO dept ON m.id_departamento = dept.id_departamento;
    
SELECT * FROM vista_usuarios_autenticados;