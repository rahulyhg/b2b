-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
	DELIMITER $$

        DROP PROCEDURE IF EXISTS REP_CON_INI$$

	CREATE PROCEDURE `REP_CON_INI`(
	P_id_proyecto			INT(11),
	P_id_concepto			INT(11),
	P_c_caja		 		INT(11),
	P_fecha_inicio 				DATETIME,
	P_fecha_fin 				DATETIME
	)
	BEGIN			
			SELECT 	
				TR.id_transaccion AS Codigo,
				TR.fecha_registro AS Fecha,
				CJ.c_caja 		  AS Caja,
				P.c_codigo		  AS C_Asignacion,
				SP.c_scodigo	  AS SC_Asignacion,
				CP.c_concepto     AS Concepto,
				SC.c_sconcepto	  AS Subconcepto,
				E.c_codigo 		  AS Empresa,
				TR.nro_boucher	  AS Cheque,
				TR.importe AS IMPORTE, 
				TR.tipo_cambio AS TIPO_CAMBIO, 
				ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
		FROM    NUEVA_TRANSACCION TR
				LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
				LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
				LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
				LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 

				LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
				LEFT JOIN  CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
		WHERE  
				TR.eliminada IS NULL 
				AND (TR.id_centro_asignacion = P_id_proyecto OR P_id_proyecto IS NULL )				
				AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) 
				AND (TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
				AND (TR.fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
				AND (TR.fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)

		ORDER BY Codigo;


	END$$