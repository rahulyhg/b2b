DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_UPDATE$$

CREATE PROCEDURE `PROYECTO_UPDATE`(
 IN P_id_proyecto 	INT(11),
 IN P_c_proyecto 	VARCHAR(30),
 IN P_cta_control	VARCHAR(4),
 IN P_cta_ingreso	VARCHAR(4),
 IN P_c_estado		CHAR(10)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM PROYECTOS P
	 WHERE (c_proyecto = P_c_proyecto)
	 AND P.id_proyecto != P_id_proyecto)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE PROYECTOS
	 SET
	 c_proyecto  = P_c_proyecto,
	 cta_control = P_cta_control,
	 cta_ingreso = P_cta_ingreso,
	 c_estado    = P_c_estado
 WHERE id_proyecto = P_id_proyecto;
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$