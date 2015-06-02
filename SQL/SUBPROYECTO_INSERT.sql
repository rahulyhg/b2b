DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_INSERT$$

CREATE PROCEDURE `SUBPROYECTO_INSERT`( 
-- IN P_ContratistaId INT(11),
-- IN P_TipoEmpresaId VARCHAR(10),
 IN P_c_sproyecto 	VARCHAR(30),
 IN P_c_scodigo	 	VARCHAR(10),
 IN P_id_proyecto	INT,
-- IN P_c_cuenta		VARCHAR(5),
-- IN P_u_cuenta		CHAR(1),
 IN P_Estado 		CHAR(3),
 IN P_Fecha 		DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_sproyecto)
	 FROM SUB_PROYECTOS
	 WHERE c_scodigo = P_c_scodigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO SUB_PROYECTOS(
	 c_sproyecto,
	 c_scodigo,
	 id_proyecto,
	 -- c_cuenta,
	 -- u_cuenta,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_sproyecto,
	 P_c_scodigo,
	 P_id_proyecto,
	 -- P_c_cuenta,
	 -- P_u_cuenta,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$