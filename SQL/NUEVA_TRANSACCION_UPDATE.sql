DELIMITER $$

DROP PROCEDURE IF EXISTS NUEVA_TRANSACCION_UPDATE$$

CREATE PROCEDURE `NUEVA_TRANSACCION_UPDATE`(
 IN P_id_transaccion			INT(11),
 IN P_Tipo_transaccion			VARCHAR(15),
 IN P_rendicion				CHAR(9),
 IN P_fecha_registro			DATETIME,
 -- IN P_fecha_sistema			DATETIME,
 IN P_documento				VARCHAR(20),
 IN P_tipo_cambio			DECIMAL(10,2),
 IN P_importe				DECIMAL(10,2),
 IN P_importedol			DECIMAL(10,2),
 IN P_id_cajabanco			VARCHAR(10),
 IN P_nro_boucher			VARCHAR(25),
 IN P_id_subcentroasignacion            VARCHAR(10),
 IN P_id_centro_asignacion		VARCHAR(10),
 IN P_id_subconsepto			VARCHAR(10),
 IN P_id_concepto			VARCHAR(10),
 IN P_observacion			VARCHAR(50),
 IN P_id_empresa			VARCHAR(10),
 IN P_glosa				VARCHAR(25),
 IN P_id_cuecontable			VARCHAR(10),
 IN P_id_cuecontablecr			VARCHAR(10),
 IN P_fecha_doc				DATETIME,
 IN P_nro_doc				VARCHAR(25),
 IN P_id_cuecontablecc			VARCHAR(10),
 IN P_id_cuecontablecccr		VARCHAR(10),
 IN P_fecha_doccc			DATETIME,
 IN P_glosacc				VARCHAR(25)
)
BEGIN
 
 UPDATE NUEVA_TRANSACCION
	 SET
	 Tipo_transaccion = P_Tipo_transaccion,
	 rendicion = P_rendicion,
	 fecha_registro	= P_fecha_registro,
	 -- fecha_sistema
	 documento = P_documento,
	 importe = P_importe,
	 importedol	= P_importedol,
	 id_cajabanco = P_id_cajabanco,
	 nro_boucher = P_nro_boucher,
	 id_subcentroasignacion = P_id_subcentroasignacion,
	 id_centro_asignacion = P_id_centro_asignacion,
	 id_subconsepto = P_id_subconsepto,
	 id_concepto = P_id_concepto,
	 observacion = P_observacion,
	 id_empresa = P_id_empresa,
	 id_cuecontable = P_id_cuecontable,
	 id_cuecontablecr = P_id_cuecontablecr,
	 fecha_doc = P_fecha_doc,
	 glosa = P_glosa,
	 nro_doc = P_nro_doc,
	 id_cuecontablecc = P_id_cuecontablecc,
	 id_cuecontablecccr = P_id_cuecontablecccr,
	 fecha_doccc = P_fecha_doccc,
	 glosacc = P_glosacc
	 WHERE id_transaccion = P_id_transaccion;
END$$