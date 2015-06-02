DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_DELETE$$

CREATE PROCEDURE `CONCEPTO_DELETE`(
 IN P_id_concepto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(S.id_sconcepto)
	 FROM SUB_CONCEPTOS S
	 WHERE S.id_concepto = P_id_concepto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Sub Concepto.';
 ELSEIF ((SELECT COUNT(C.id_conceptoxproyecto)
	 FROM CONCEPTOXPROYECTO C
	 WHERE C.id_concepto = P_id_concepto)>0)
	 THEN SET P_ERROR = 'El registro esta asignado a un Centro de Asignación.';
 ELSEIF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N
	 WHERE N.id_concepto = P_id_concepto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM CONCEPTOS
 WHERE id_concepto = P_id_concepto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$