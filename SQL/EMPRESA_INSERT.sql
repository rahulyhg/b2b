DELIMITER $$

DROP PROCEDURE IF EXISTS EMPRESA_INSERT$$

CREATE PROCEDURE `EMPRESA_INSERT`(
 IN P_c_nomraz 	VARCHAR(60),
 IN P_c_codigo 	VARCHAR(10),
 IN P_Estado 	CHAR(3),
 IN P_Fecha 	DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_empresa)
	 FROM EMPRESAS
	 WHERE c_nomraz = P_c_nomraz
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO EMPRESAS(
	 c_nomraz,
	 c_codigo,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_nomraz,
	 P_c_codigo,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$