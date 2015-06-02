DELIMITER $$

DROP PROCEDURE IF EXISTS EMPRESA_UPDATE$$

CREATE PROCEDURE `EMPRESA_UPDATE`(
 IN P_id_empresa 	INT(11),
 IN P_c_nomraz 		VARCHAR(60),
 IN P_c_estado 		CHAR(3)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM EMPRESAS E
	 WHERE c_nomraz = P_c_nomraz
	 AND E.id_empresa != P_id_empresa)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE EMPRESAS
	 SET
	 c_nomraz = P_c_nomraz,
	 c_estado = P_c_estado
 WHERE id_empresa = P_id_empresa;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$