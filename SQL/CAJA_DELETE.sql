DELIMITER $$

DROP PROCEDURE IF EXISTS CAJA_DELETE$$

CREATE PROCEDURE `CAJA_DELETE`(
 IN P_id_caja INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, CAJA C
	 WHERE N.id_cajabanco = C.c_codigo 
	 AND C.id_caja = P_id_caja)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Centro de Asignación.';
 ELSE
 DELETE FROM CAJA
 WHERE id_caja = P_id_caja;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$
