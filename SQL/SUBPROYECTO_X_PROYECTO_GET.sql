DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_X_PROYECTO_GET$$

CREATE PROCEDURE `SUBPROYECTO_X_PROYECTO_GET`(
	IN P_id_proyecto VARCHAR(10)
)
BEGIN
	SELECT  P.c_scodigo AS Codigo,
		CONCAT(P.c_scodigo,' - ',
		P.c_sproyecto) AS Descripcion
	FROM 
		SUB_PROYECTOS P
	WHERE
		P.id_proyecto = P_id_proyecto AND -- X ID DE PROYECTO
		P.c_estado = 'ACT'
	ORDER  BY 
		Descripcion ASC;
END$$

