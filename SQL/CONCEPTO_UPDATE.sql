DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_UPDATE$$

CREATE PROCEDURE `CONCEPTO_UPDATE`(
 IN P_id_concepto INT(11),
 IN P_c_concepto VARCHAR(60),
 IN P_c_estado CHAR(10)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM CONCEPTOS C
	 WHERE (c_concepto = P_c_concepto)
	 AND C.id_concepto != P_id_concepto)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE CONCEPTOS
	 SET
	 c_concepto = P_c_concepto,
	 c_estado = P_c_estado
 WHERE id_concepto = P_id_concepto;
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$