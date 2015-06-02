DELIMITER $$

DROP PROCEDURE IF EXISTS MONEDA_INSERT$$

CREATE PROCEDURE `MONEDA_INSERT`(
 IN P_c_moneda 	VARCHAR(60),
 IN P_c_codigo 	VARCHAR(10),
 IN P_Estado 	CHAR(10),
 IN P_Fecha 	DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_moneda)
	 FROM MONEDAS
	 WHERE c_moneda = P_c_moneda
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO MONEDAS(
	 c_moneda,
	 c_codigo,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_moneda,
	 P_c_codigo,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$