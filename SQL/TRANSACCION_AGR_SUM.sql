DELIMITER $$

DROP PROCEDURE IF EXISTS TRANSACCION_AGR_SUM$$

CREATE PROCEDURE `TRANSACCION_AGR_SUM`(
	IN P_id_agrupado INT
)
BEGIN
	SELECT 'Ingresos' AS TITULO, ifnull(sum(importe),0) AS SUMA
	  FROM NUEVA_TRANSACCION_AGRUP N
	  WHERE N.num_agr = P_id_agrupado AND Tipo_transaccion = 'Ingreso'
	UNION
	SELECT 'Egresos' AS TITULO, ifnull(sum(importe),0) AS SUMA
	  FROM NUEVA_TRANSACCION_AGRUP N
	  WHERE N.num_agr = P_id_agrupado AND Tipo_transaccion = 'Egreso';
END$$