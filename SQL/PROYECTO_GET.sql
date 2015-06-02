DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_GET$$

CREATE PROCEDURE `PROYECTO_GET`(
 IN P_ProyectoId CHAR(10),
 IN P_opcion	   INT
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 P.id_proyecto,
		 P.c_codigo,
		 P.c_proyecto,
		 P.cta_control,
		 P.cta_ingreso,
		 P.c_estado AS Estado
		 FROM PROYECTOS P
		 WHERE id_proyecto = P_ProyectoId
		 OR P_ProyectoId IS NULL;
	WHEN '2' THEN
		 SELECT
		 P.id_proyecto,
		 concat(P.c_codigo,' - ',P.c_proyecto) AS Proyecto
		 FROM PROYECTOS P
		 WHERE c_estado = 'ACT'
		 ORDER BY P.c_codigo;
	END CASE;
END$$