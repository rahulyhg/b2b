DELIMITER $$

DROP PROCEDURE IF EXISTS EMPRESA_DELETE$$

CREATE PROCEDURE `EMPRESA_DELETE`(
 IN P_id_empresa INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(C.id_caja)
	 FROM CAJA C, EMPRESAS E
	 where C.id_empresa = E.c_codigo
	 and E.id_empresa = P_id_empresa)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en una Caja.';
 ELSEIF ((SELECT COUNT(C.id_cuenta)
	 FROM CTAS_DC C, EMPRESAS E
	 where C.id_empresa = E.c_codigo
	 and E.id_empresa = P_id_empresa)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en una Cuenta Central.';
 ELSEIF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, EMPRESAS E
	 where N.id_empresa = E.c_codigo
	 and E.id_empresa = P_id_empresa)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM EMPRESAS
 WHERE id_empresa = P_id_empresa;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$