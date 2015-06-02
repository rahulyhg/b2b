DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOSXCAJA$$

CREATE PROCEDURE `GET_SALDOSXCAJA`(
 IN fecha INT
)
BEGIN
	SELECT
	 C.cuen_caja AS Cuenta,
	 C.c_caja AS Caja,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema < (SELECT CONCAT(fecha,'-01-01'))) AS SInicial,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-01-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-01-31'))) AS Ene,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-02-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-02-29'))) AS Feb,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-03-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-03-31'))) AS Mar,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-04-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-04-30'))) AS Abr,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-05-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-05-31'))) AS May,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-06-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-06-30'))) AS Jun,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-07-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-07-31'))) AS Jul,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-08-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-08-31'))) AS Ago,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-09-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-09-30'))) AS Sep,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-10-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-10-31'))) AS Oct,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-11-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-11-30'))) AS Nov,
	 (SELECT ifnull(sum(importedol),0) FROM nueva_transaccion N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-12-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-12-31'))) AS Dic
	FROM caja C
	ORDER BY C.cuen_caja;
END$$