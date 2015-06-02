DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_DELETE$$

CREATE PROCEDURE `CTA_CONTABLE_DELETE`(
 IN P_id_cuenta INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT  COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, CTAS_CONTABLES C
	 WHERE (N.id_cuecontable = C.c_codigo
		OR N.id_cuecontablecr = C.c_codigo)
	 AND C.id_cuenta = P_id_cuenta)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Centro de Asignación.';
 ELSE
 DELETE FROM CTAS_CONTABLES
 WHERE id_cuenta = P_id_cuenta;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$