DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_PROYECTO_UPDATE$$

CREATE PROCEDURE `CONCEPTO_PROYECTO_UPDATE`(
 IN P_id_proyecto 		VARCHAR(10)
)
BEGIN
	UPDATE CONCEPTOXPROYECTO
	SET flagactivo = 0
	WHERE id_proyecto = P_id_proyecto;
END$$