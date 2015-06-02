DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_INSERT$$

CREATE PROCEDURE `CONCEPTO_INSERT`( 
 IN P_c_concepto 	VARCHAR(60),
 IN P_c_codigo 		VARCHAR(10),
 IN P_Estado 		CHAR(10)
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_concepto)
	 FROM CONCEPTOS
	 WHERE c_concepto = P_c_concepto
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO CONCEPTOS(
	 c_concepto,
	 c_codigo,
	 c_estado)
	 VALUES(
	 P_c_concepto,
	 P_c_codigo ,
	 P_Estado);
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$