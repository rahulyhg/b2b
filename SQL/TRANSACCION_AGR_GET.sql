DELIMITER $$

DROP PROCEDURE IF EXISTS TRANSACCION_AGR_GET$$

CREATE PROCEDURE `TRANSACCION_AGR_GET`(
    IN P_id_agrupado VARCHAR(50)
)
BEGIN
IF(P_id_agrupado IS NULL)
THEN
	 SELECT
	 T.id_agrupado,
	 T.descripcion
	 FROM TRANSACCION_AGR T
	 ORDER BY T.id_agrupado;
ELSE
	 SELECT
	 T.id_agrupado,
	 T.descripcion,
	 (SELECT ifnull(sum(importe),0) FROM NUEVA_TRANSACCION_AGRUP N
	  WHERE N.num_agr = P_id_agrupado AND Tipo_transaccion = 'Ingreso') as Ingreso,
	 (SELECT ifnull(sum(importe),0) FROM NUEVA_TRANSACCION_AGRUP N
	  WHERE N.num_agr = P_id_agrupado AND Tipo_transaccion = 'Egreso') AS Egreso
	 FROM TRANSACCION_AGR T
	 WHERE T.id_agrupado = P_id_agrupado
		OR T.descripcion = P_id_agrupado
	 ORDER BY T.id_agrupado;
END IF;
END