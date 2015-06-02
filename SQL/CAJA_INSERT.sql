DELIMITER $$

DROP PROCEDURE IF EXISTS CAJA_INSERT$$

CREATE PROCEDURE `CAJA_INSERT`(
 IN P_c_caja 		VARCHAR(60),
 IN P_c_codigo	 	VARCHAR(10),
 IN P_id_moneda		INT,
 IN P_id_empresa	VARCHAR(5),
 IN P_t_caja		varchar(10),
 IN P_Estado 		CHAR(10),
 IN P_Fecha 		DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_caja)
	 FROM CAJA
	 WHERE c_caja = P_c_caja
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO CAJA(
	 c_caja,
	 c_codigo,
	 id_moneda,
	 id_empresa,
	 t_caja,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_caja,
	 P_c_codigo,
	 P_id_moneda,
	 P_id_empresa,
	 P_t_caja,
	 P_Estado,
	 P_Fecha );
 END IF;
SELECT P_ERROR AS Mensaje; 
END$$

