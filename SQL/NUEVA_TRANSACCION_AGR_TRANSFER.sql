DELIMITER $$

CREATE PROCEDURE `NUEVA_TRANSACCION_AGR_TRANSFER`(
 IN P_id_agrupado INT
)
BEGIN
DECLARE P_ERROR VARCHAR(100);
DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;

 IF ((SELECT COUNT(*) FROM NUEVA_TRANSACCION_AGRUP
		WHERE num_agr = P_id_agrupado)= 0 )
	THEN SET P_ERROR = 'No se encontraron movimientos para transferir.';
 ELSE

	INSERT INTO NUEVA_TRANSACCION(
		Tipo_transaccion,
		rendicion,
		fecha_registro,
		fecha_sistema,
		documento,
		tipo_cambio,
		importe,
		importedol,
		id_cajabanco,
		nro_boucher,
		id_subcentroasignacion,
		id_centro_asignacion,
		id_subconsepto,
		id_concepto,
		observacion,
		id_empresa,
		id_cuecontable,
		id_cuecontablecr,
		fecha_doc,
		glosa,
		nro_doc,
		id_cuecontablecc,
		id_cuecontablecccr,
		fecha_doccc,
		glosacc,
		num_agr)
	SELECT 
		Tipo_transaccion,
		rendicion,
		fecha_registro,
		fecha_sistema,
		documento,
		tipo_cambio,
		importe,
		importedol,
		id_cajabanco,
		nro_boucher,
		id_subcentroasignacion,
		id_centro_asignacion,
		id_subconsepto,
		id_concepto,
		observacion,
		id_empresa,
		id_cuecontable,
		id_cuecontablecr,
		fecha_doc,
		glosa,
		nro_doc,
		id_cuecontablecc,
		id_cuecontablecccr,
		fecha_doccc,
		glosacc,
		num_agr
	FROM NUEVA_TRANSACCION_AGRUP
	WHERE num_agr = P_id_agrupado;
	
	DELETE FROM NUEVA_TRANSACCION_AGRUP
	WHERE num_agr = P_id_agrupado;
	
	DELETE FROM TRANSACCION_AGR
	WHERE id_agrupado = P_id_agrupado;
	
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$