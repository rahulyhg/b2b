DELIMITER $$

CREATE PROCEDURE `CAJA_UPDATE`(
 IN P_id_caja 		INT(11),
 IN P_c_caja 		VARCHAR(60),
 IN P_id_moneda		INT,
 IN P_id_empresa	VARCHAR(5),
 IN P_t_caja 		VARCHAR(3),
 IN P_c_estado		CHAR(10)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM CAJA C
	 WHERE c_caja = P_c_caja
	 AND C.id_caja != P_id_caja)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE CAJA
	 SET
	 c_caja = P_c_caja,
	 
	 id_moneda = P_id_moneda,
	 id_empresa = P_id_empresa,
	 t_caja = P_t_caja,
	 
	 c_estado = P_c_estado
 WHERE id_caja = P_id_caja;
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$

