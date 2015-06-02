DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_INSERT$$

CREATE PROCEDURE `PROYECTO_INSERT`( 
 IN P_c_codigo 			VARCHAR(10),
 IN P_c_proyecto 		VARCHAR(30),
 IN P_cta_control		VARCHAR(4),
 IN P_cta_ingreso		VARCHAR(4),
 IN P_Estado 			CHAR(10),
 IN P_Fecha 			DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_proyecto)
	 FROM PROYECTOS
	 WHERE c_codigo = P_c_codigo
	 OR c_proyecto = P_c_proyecto)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esta descripción o código.';
 ELSE
	 INSERT INTO PROYECTOS(
	 c_codigo,
	 c_proyecto,
	 cta_control,
	 cta_ingreso,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_codigo,
	 P_c_proyecto,
	 P_cta_control,
	 P_cta_ingreso,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$