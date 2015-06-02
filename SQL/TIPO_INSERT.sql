-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$


DROP PROCEDURE IF EXISTS TIPO_INSERT$$

CREATE PROCEDURE `TIPO_INSERT`( 
-- IN P_ContratistaId INT(11),
-- IN P_TipoEmpresaId VARCHAR(10),
 IN T_id_tipo       VARCHAR(60),
 IN T_c_tipo        VARCHAR(45),
 IN T_id_tipo_padre VARCHAR(10),
 IN T_Estado        VARCHAR(10)
 -- IN P_Usuario 			VARCHAR(64),
 -- IN P_Fecha 			DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_tipo)
	 FROM tipo
	 WHERE id_tipo = T_id_tipo
	 OR c_tipo = T_c_tipo)>0)
 THEN SET P_ERROR = 'Ya existe un tipo con esa descripción o código.';
 ELSE
	 INSERT INTO tipo(
	 -- ContratistaId,
	 -- TipoEmpresaId,
	 id_tipo,
	 id_tipo_padre,
	 c_tipo,
	 Estado
	 )
	 -- UsuarioCreacion,
	-- f_creacion
		
	 VALUES(
	 -- P_ContratistaId,
	 -- P_TipoEmpresaId,
	 T_id_tipo,
	 T_id_tipo_padre ,
	 T_c_tipo,
	 T_Estado);
	 -- P_Usuario,
	-- P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$