DELIMITER $$

DROP PROCEDURE IF EXISTS NUEVA_TRANSACCION_GET$$

CREATE PROCEDURE `NUEVA_TRANSACCION_GET`(
 IN P_id_transaccion    CHAR(10),
 IN P_opcion            INT,
 IN P_fecha_ini		DATE,
 IN P_fecha_fin		DATE
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		SELECT 
		N.id_transaccion,
		N.tipo_transaccion,
		CONCAT(C.id_caja,' - ',C.c_caja) AS Caja,
		CONCAT(P.id_proyecto,' - ',P.c_proyecto) AS Proyecto,
		C2.c_concepto AS Concepto,
		N.importe,
		N.importedol,
		N.fecha_registro,
		N.fecha_sistema
		FROM NUEVA_TRANSACCION N
		LEFT JOIN CAJA C ON N.id_cajabanco = C.id_caja
		LEFT JOIN CONCEPTOS C2 ON N.id_concepto = C2.id_concepto
		LEFT JOIN PROYECTOS P ON N.id_centro_asignacion = P.id_proyecto
		WHERE N.eliminada IS NULL
		AND (N.fecha_sistema >= P_fecha_ini OR P_fecha_ini IS NULL)
		AND (N.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)
		ORDER BY id_transaccion DESC;
	WHEN '2' THEN
		SELECT 
		N.id_transaccion,
		N.Tipo_transaccion,
		N.rendicion,
		N.fecha_registro,
		N.fecha_sistema,
		N.documento,
		N.tipo_cambio,
		N.importe,
		N.importedol,
		N.id_cajabanco,
		N.nro_boucher,
		N.id_subcentroasignacion,
		N.id_centro_asignacion,
		N.id_subconsepto,
		N.id_concepto,
		N.observacion,
		N.id_empresa,
		N.id_cuecontable,
		N.id_cuecontablecr,
		N.fecha_doc,
		N.glosa,
		N.nro_doc,
		N.id_cuecontablecc,
		N.id_cuecontablecccr,
		N.fecha_doccc,
		N.glosacc
		FROM NUEVA_TRANSACCION N
		WHERE N.id_transaccion = P_id_transaccion;
	END CASE;
END$$