DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_GET$$

CREATE PROCEDURE `SUBPROYECTO_GET`(
 IN P_id_sproyecto CHAR(10),
 IN P_opcion	   INT
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 S.id_sproyecto,
		 S.c_scodigo,
		 S.c_sproyecto,
		 S.id_proyecto,
		 CONCAT(P.c_codigo,' - ',P.c_proyecto) AS Proyecto,
		 S.c_estado AS Estado
		 FROM SUB_PROYECTOS S
		 LEFT JOIN PROYECTOS P ON S.id_proyecto = P.id_proyecto
		 WHERE id_sproyecto = P_id_sproyecto
		 OR P_id_sproyecto IS NULL;
	WHEN '2' THEN
		 SELECT
		 S.c_scodigo,
		 CONCAT(S.c_scodigo,' - ',S.c_sproyecto) AS SProyecto,
		 S.id_proyecto
		 FROM SUB_PROYECTOS S
		 WHERE c_estado = 'ACT'
		 ORDER BY S.c_scodigo;
	END CASE;
END$$