DELIMITER $$

DROP PROCEDURE IF EXISTS TRANSACCION_AGR_UPDATE$$

CREATE PROCEDURE `TRANSACCION_AGR_UPDATE`(
 IN P_id_agrupado INT(11),
 IN P_descripcion VARCHAR(200)
)
BEGIN
DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(descripcion)
	 FROM TRANSACCION_AGR T
	 WHERE T.descripcion = P_descripcion
	 AND T.id_agrupado != P_id_agrupado)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción.';
 ELSE
	UPDATE TRANSACCION_AGR
	SET
	 descripcion = P_descripcion
	WHERE id_empresa = P_id_empresa;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$