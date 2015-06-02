DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_INSERT$$

CREATE PROCEDURE `CTA_CONTABLE_INSERT`(
 IN P_c_cuenta 	VARCHAR(60),
 IN P_c_codigo 	VARCHAR(10),
 IN P_Estado 	CHAR(10),
 IN P_Fecha 	DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_cuenta)
	 FROM CTAS_CONTABLES
	 WHERE c_cuenta = P_c_cuenta
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO CTAS_CONTABLES(
	 c_cuenta,
	 c_codigo,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_cuenta,
	 P_c_codigo,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR as Mensaje; 
END$$