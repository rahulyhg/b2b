DELIMITER $$

DROP PROCEDURE IF EXISTS MONEDA_UPDATE$$

CREATE PROCEDURE `MONEDA_UPDATE`(
 IN P_id_moneda INT(11),
 IN P_c_moneda VARCHAR(60),
 IN P_c_codigo VARCHAR(10),
 IN P_c_estado CHAR(10)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM MONEDAS M
	 WHERE (c_moneda = P_c_moneda
	 OR c_codigo = P_c_codigo)
	 -- and E.TipoEmpresaId = P_TipoEmpresaId
	 AND M.id_moneda != P_id_moneda)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE MONEDAS
	 SET
	 c_moneda = P_c_moneda,
	 c_codigo = P_c_codigo,
	 c_estado = P_c_estado
 WHERE id_moneda = P_id_moneda;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$