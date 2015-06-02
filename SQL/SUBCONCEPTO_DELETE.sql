DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_DELETE$$

CREATE PROCEDURE `SUBCONCEPTO_DELETE`(
 IN P_id_sconcepto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, SUB_CONCEPTOS S
	 where N.id_subconsepto = S.c_scodigo
	 and S.id_sconcepto = P_id_sconcepto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM SUB_CONCEPTOS
 WHERE id_sconcepto = P_id_sconcepto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$