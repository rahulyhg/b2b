DELIMITER $$

DROP PROCEDURE IF EXISTS REP_CAJA_EMP$$

CREATE PROCEDURE `REP_CAJA_EMP`(
P_c_codigo 					INT(11),
-- P_id_subcentroasignacion                VARCHAR(10),
P_id_concepto				INT(11),
P_c_caja					INT(11),
-- P_id_subconsepto 			VARCHAR(10),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN
        SELECT
			P.c_proyecto PROYECTO, 
			SP.c_sproyecto SPROYECTO,	
			TR.id_transaccion, TR.fecha_registro FECHA, 
			-- CD1.c_cuenta AS CUENTA_DB, CD2.c_cuenta AS CUENTA_CR, 
			E.c_nomraz AS EMPRESA, 
			-- CC1.c_cuenta AS EMPRESA_DB, CC2.c_cuenta AS EMPRESA_CR,
			concat(CJ.c_codigo,' - ',CJ.c_caja) CAJA,
			CP.c_concepto, SC.c_sconcepto, TR.observacion,
			TR.importe AS IMPORTE, TR.tipo_cambio TIPO_CAMBIO, ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
	FROM    NUEVA_TRANSACCION TR
			LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
			LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
			LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
			LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 
			LEFT JOIN CTAS_CONTABLES CC1 ON  TR.id_cuecontable=CC1.c_codigo
			LEFT JOIN CTAS_CONTABLES CC2 ON  TR.id_cuecontablecr=CC2.c_codigo
			LEFT JOIN CTAS_DC CD1 ON  TR.id_cuecontablecc=CD1.c_codigo
			LEFT JOIN CTAS_DC CD2 ON  TR.id_cuecontablecccr=CD2.c_codigo
			LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
			LEFT JOIN  CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			-- AND (TR.id_subcentroasignacion = P_id_subcentroasignacion OR P_id_subcentroasignacion IS NULL)
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND (TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL) -- X CONCEPTO
			-- AND (TR.id_subconsepto = P_id_subconsepto  OR  P_id_subconsepto IS NULL)		
			AND (TR.fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND (TR.fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)

	ORDER BY EMPRESA;
END$$