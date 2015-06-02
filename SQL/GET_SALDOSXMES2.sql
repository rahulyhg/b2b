DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOSXMES2$$

CREATE PROCEDURE `GET_SALDOSXMES2`(
 IN fecha INT
)
BEGIN
	SELECT
	CASE 	WHEN r.cuenta < 2000  THEN '1 CAJA BANCO'
			WHEN r.cuenta < 4000  THEN '2 CTAS CTES VARIAS'
			WHEN r.cuenta < 5000  THEN '3 PROYECTOS'
			WHEN r.cuenta < 7000  THEN '4 CTAS VARIAS'
			WHEN r.cuenta < 8000  THEN '5 PATRIMONIO'
			WHEN r.cuenta < 9000  THEN '6 INGRESO'
			WHEN r.cuenta < 10000 THEN '7 EGRESO'
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
	AND r.cuenta>7999
	AND LEFT(r.cuenta,1) != '2'
	GROUP BY r.cuenta;
END$$