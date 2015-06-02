DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_X_CONCEPTO_GET$$

CREATE PROCEDURE `SUBCONCEPTO_X_CONCEPTO_GET`(
	IN P_id_concepto INT(11)
)
BEGIN
	SELECT  SC.c_scodigo AS Codigo,
			CONCAT(SC.c_scodigo,' - ',SC.c_sconcepto) AS Descripcion
	FROM 
		SUB_CONCEPTOS SC
	WHERE
		SC.id_concepto = P_id_concepto AND -- X ID DE PROYECTO
		SC.c_estado = 'ACT'
	ORDER  BY 
		Descripcion ASC;
END$$

