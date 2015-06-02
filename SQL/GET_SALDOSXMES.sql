DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOSXMES$$

CREATE PROCEDURE `GET_SALDOSXMES`(
 IN fecha INT
)
BEGIN
	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecc = '',  id_cuecontablecccr = '';

	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecc = '2995',  id_cuecontablecccr = '2995'
	WHERE  id_empresa IN ( 'SIN','REP') ;

	UPDATE NUEVA_TRANSACCION n, CAJA c
	SET n.id_cuecontablecc = '2995', n.id_cuecontablecccr = '2995'
	WHERE n. id_empresa NOT IN ( 'SIN','REP') 
	AND n.id_cajabanco = c.c_codigo
	AND n.id_empresa = c.id_empresa;

	UPDATE NUEVA_TRANSACCION n, CTAS_DC d
	SET n.id_cuecontablecc = d.c_codigo, n.id_cuecontablecccr = '2997'
	WHERE n.id_empresa NOT IN ( 'SIN','REP')  
	AND n.tipo_transaccion = 'Egreso'
	AND n.id_cuecontablecc = '' AND  n.id_cuecontablecccr = ''
	AND n.id_empresa = d.id_empresa
	AND LEFT(d.c_codigo,1) = '2';

	UPDATE NUEVA_TRANSACCION n, CTAS_DC d
	SET n.id_cuecontablecc = '2997', n.id_cuecontablecccr = d.c_codigo
	WHERE n. id_empresa NOT IN ( 'SIN','REP') 
	AND n.tipo_transaccion = 'INgreso'
	AND n.id_cuecontablecc = '' AND  n.id_cuecontablecccr = ''
	AND n.id_empresa = d.id_empresa
	AND LEFT(d.c_codigo,1) = '2';
	/*
	SELECT * FROM NUEVA_TRANSACCION
	WHERE id_cuecontablecc = '' AND  id_cuecontablecccr ='';
	
	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecc = ''
	WHERE id_cuecontablecc = '2995'

	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecccr = ''
	WHERE id_cuecontablecccr = '2995'
	*/
	-- --- REPORTE -----
	TRUNCATE TABLE REPORTE;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT CONCAT('10',id_cajabanco), 0, ABS(importedol), fecha_registro, id_transaccion FROM NUEVA_TRANSACCION
	WHERE tipo_transaccion = 'Ingreso';

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_control, ABS(n.importedol), 0, n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'Ingreso'
	AND n.id_subconsepto IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_INgreso, ABS(n.importedol), 0, n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'INgreso'
	AND n.id_subconsepto NOT IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT CONCAT('10',id_cajabanco), ABS(importedol), 0, fecha_registro, id_transaccion FROM NUEVA_TRANSACCION
	WHERE tipo_transaccion = 'Egreso';

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_control, 0, ABS(n.importedol), n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'Egreso'
	AND n.id_subconsepto IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_INgreso, 0, ABS(n.importedol), n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'Egreso'
	AND n.id_subconsepto NOT IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT id_cuecontablecc, importedol, 0, fecha_registro, id_transaccion FROM NUEVA_TRANSACCION;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT id_cuecontablecccr, 0, importedol, fecha_registro, id_transaccion FROM NUEVA_TRANSACCION;

	/*
	UPDATE REPORTE
	SET fecha = '2011/12/31'
	WHERE fecha = '2012/01/01'
	*/

	-- SELECT SUM(debe), SUM(haber) FROM REPORTE;
	-- --------------- FIN REPORTE ---------------

	SELECT 
	CASE 	WHEN r.cuenta < 2000  THEN '1.- CAJA BANCO'
			WHEN r.cuenta < 4000  THEN '2.- CTAS CTES VARIAS'
			WHEN r.cuenta < 5000  THEN '3.- PROYECTOS'
			WHEN r.cuenta < 7000  THEN '4.- CTAS VARIAS'
			WHEN r.cuenta < 8000  THEN '5.- PATRIMONIO'
			WHEN r.cuenta < 9000  THEN '6.- INGRESO'
			WHEN r.cuenta < 10000 THEN '7.- EGRESO'
	END AS TITULO,
	r.cuenta AS Cuenta, c.c_cuenta AS Descripcion,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)=1,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)=1,r.haber,0)) AS SInicial,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)>=2,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)>=2,r.haber,0)) AS Ene,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=2,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=2,r.haber,0)) AS Feb,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=3,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=3,r.haber,0)) AS Mar,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=4,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=4,r.haber,0)) AS Abr,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=5,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=5,r.haber,0)) AS May,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=6,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=6,r.haber,0)) AS Jun,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=7,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=7,r.haber,0)) AS Jul,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=8,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=8,r.haber,0)) AS Ago,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=9,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=9,r.haber,0)) AS Sep,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=10,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=10,r.haber,0)) AS Oct,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=11,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=11,r.haber,0)) AS Nov,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)<=29,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)<=29,r.haber,0)) AS Dic,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=30,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=30,r.haber,0)) AS Ajuste,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=31,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=31,r.haber,0)) AS Cierre,
	SUM(IF(YEAR(r.fecha)=fecha,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha,r.haber,0)) AS SFinal
	FROM REPORTE r, CTAS_DC c
	WHERE r.cuenta = c.c_codigo
	AND r.cuenta<8000
	AND LEFT(r.cuenta,1) != '2'
	GROUP BY r.cuenta;
END$$