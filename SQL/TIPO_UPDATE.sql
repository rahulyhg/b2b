-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

DROP PROCEDURE IF EXISTS TIPO_UPDATE$$

CREATE PROCEDURE `TIPO_UPDATE`(
	IN T_id_tipo    VARCHAR(11),
 -- IN P_c_codigo 	VARCHAR(10),
 -- IN T_id_tipo_padre 	VARCHAR(60),
	IN T_c_tipo 	VARCHAR(20),
	IN T_Estado     VARCHAR(10)
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_tipo)
	 FROM TIPO
	 WHERE c_tipo = T_c_tipo	
	 and Estado = T_Estado)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE

	 UPDATE TIPO
	 SET
		-- 	id_tipo = T_id_tipo,
		-- 	id_tipo_padre = T_id_tipo_padre,
			c_tipo= T_c_tipo,
			Estado= T_Estado
	 WHERE  id_tipo = T_id_tipo;

 END IF;
 SELECT P_ERROR AS Mensaje; 

END$$