DELIMITER $$

DROP PROCEDURE IF EXISTS CUENTA_DC_UPDATE$$

CREATE PROCEDURE `CUENTA_DC_UPDATE`(
 IN P_id_cuenta INT(11),
 IN P_c_cuenta VARCHAR(60),
 IN P_id_empresa VARCHAR(10),
 IN P_c_estado CHAR(10)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM CTAS_DC C
	 WHERE c_cuenta = P_c_cuenta
	 and C.id_cuenta != P_id_cuenta)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE CTAS_DC
	 SET
	 c_cuenta = P_c_cuenta,
	 id_empresa = P_id_empresa,
	 c_estado = P_c_estado
 WHERE id_cuenta = P_id_cuenta;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$