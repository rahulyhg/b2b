DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_UPDATE$$

CREATE PROCEDURE `CTA_CONTABLE_UPDATE`(
 IN P_id_cuenta INT(11),
 IN P_c_cuenta 	VARCHAR(60),
 IN P_c_estado 	CHAR(10)
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_cuenta)
	 FROM CTAS_CONTABLES
	 WHERE c_cuenta = P_c_cuenta
	 )>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE

	 UPDATE CTAS_CONTABLES
	 SET
		c_cuenta = P_c_cuenta,
		c_estado = P_c_estado
	 WHERE  id_cuenta = P_id_cuenta;

 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$