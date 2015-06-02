-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$
DROP PROCEDURE IF EXISTS REP_NUM_REM$$

CREATE PROCEDURE `REP_NUM_REM`(

	P_rem_inicio 			varchar(15),
	P_rem_fin 				varchar(15)
	)
BEGIN
	if (isnull(P_rem_inicio) and isnull(P_rem_fin))
then
        SELECT 	CONCAT( "Redicion", ' - ' , TR.rendicion) TITULO,	
			TR.id_transaccion, TR.fecha_sistema, 
			CD1.c_cuenta AS CUENTA_DB,
			CD2.c_cuenta AS CUENTA_CR,
			E.c_nomraz AS EMPRESA, 
			CC1.c_cuenta AS EMPRESA_DB,
			CC2.c_cuenta AS EMPRESA_CR,
			CJ.c_caja, CP.c_concepto, 
			SC.c_sconcepto, 
			TR.rendicion,
			TR.observacion,
			TR.importe AS IMPORTE,
			ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
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
	 
		where (rendicion <> '' or rendicion <> null )
		and eliminada is null
		ORDER BY TITULO;
else
       SELECT 	CONCAT( "Redicion", ' - ' , TR.rendicion) TITULO,	
			TR.id_transaccion, TR.fecha_sistema, 
			CD1.c_cuenta AS CUENTA_DB,
			CD2.c_cuenta AS CUENTA_CR,
			E.c_nomraz AS EMPRESA, 
			CC1.c_cuenta AS EMPRESA_DB,
			CC2.c_cuenta AS EMPRESA_CR,
			CJ.c_caja,
			CP.c_concepto,
			SC.c_sconcepto,
			TR.rendicion,
			TR.observacion,
			TR.importe AS IMPORTE, 
			ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
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

			(TR.rendicion between P_rem_inicio and P_rem_fin
			and TR.eliminada IS NULL 
			and (rendicion <> '' or rendicion <> null ))

-- 			AND (TR.fecha_sistema >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
	-- 		AND (TR.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)
ORDER BY TITULO;
end if;
	
END$$