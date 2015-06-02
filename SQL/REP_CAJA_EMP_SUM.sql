DELIMITER $$

DROP PROCEDURE IF EXISTS REP_CAJA_EMP_SUM$$

CREATE PROCEDURE `REP_CAJA_EMP_SUM`(
P_c_codigo 				INT(11),
P_id_concepto				INT(11),
P_c_caja		 		INT(11),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN

SELECT 	'Saldo Inicial' AS TITULO, 
		IFNULL(
		( 	SELECT 	ROUND(SUM(ABS(importe)),2) 
			FROM 	NUEVA_TRANSACCION
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )					
			AND 	(fecha_registro < P_fecha_inicio)
			AND 	Tipo_transaccion = 'Ingreso'
		),0)
		-
		IFNULL(
		(	SELECT 	ROUND(SUM(ABS(importe)),2) 
			FROM 	NUEVA_TRANSACCION
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )					
			AND 	(fecha_registro < P_fecha_inicio)
			AND 	Tipo_transaccion = 'Egreso' 
		),0) AS IMPORTE_SUM,
		IFNULL(
		(	SELECT 	ROUND(SUM(ABS(importedol)),2) 
			FROM 	NUEVA_TRANSACCION
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )					
			AND 	(fecha_registro < P_fecha_inicio) 
			AND 	Tipo_transaccion = 'Ingreso'
		),0)
		-
		IFNULL(
		(	SELECT 	ROUND(SUM(ABS(importedol)),2) 
			FROM 	NUEVA_TRANSACCION
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )					
			AND 	(fecha_registro < P_fecha_inicio)
			AND 	Tipo_transaccion = 'Egreso' 
		),0) AS IMPORTE_DOL_SUM

UNION

SELECT 	'Movimientos' AS TITULO, 
		IFNULL(
		(	SELECT 	ROUND(SUM(ABS(importe)),2)
			FROM 	NUEVA_TRANSACCION
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND 	(fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND 	(fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)
			AND 	Tipo_transaccion = 'Ingreso'
		),0)
		- 
		IFNULL(
		(	SELECT 	ROUND(SUM(ABS(importe)),2)
			FROM 	NUEVA_TRANSACCION
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND 	(fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND 	(fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)
			AND 	Tipo_transaccion = 'Egreso'
		),0) AS IMPORTE_SUM,
		IFNULL(
		(	SELECT 	ROUND(SUM(ABS(importedol)),2)
			FROM 	NUEVA_TRANSACCION TR
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND 	(fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND 	(fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)
			AND 	Tipo_transaccion = 'Ingreso'
		),0)
		- 
		IFNULL(
		(	SELECT 	ROUND(SUM(ABS(importedol)),2)
			FROM 	NUEVA_TRANSACCION TR
			WHERE 	(id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND 	(id_concepto = P_id_concepto OR P_id_concepto IS NULL)
			AND		(id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND 	(fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND 	(fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL) 
			AND 	Tipo_transaccion = 'Egreso'
		),0) AS IMPORTE_DOL_SUM;

END$$