DELIMITER $$

DROP PROCEDURE IF EXISTS CUENTA_DC_DELETE$$

CREATE PROCEDURE `CUENTA_DC_DELETE`(
 IN P_id_cuenta INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(P.id_proyecto)
	 FROM PROYECTOS P, CTAS_DC D
	 WHERE (P.cta_control = D.c_codigo 
		OR P.cta_ingreso = D.c_codigo)
	 AND D.id_cuenta = P_id_cuenta)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Centro de Asignación.';
 ELSEIF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, CTAS_DC D
	 WHERE (N.id_cuecontablecc = D.c_codigo 
		OR N.id_cuecontablecccr = D.c_codigo)
	 AND D.c_codigo = P_id_cuenta)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM CTAS_DC
 WHERE id_cuenta = P_id_cuenta;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$