DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_PROYECTO_INSERT$$

CREATE PROCEDURE `CONCEPTO_PROYECTO_INSERT`(
 IN P_id_proyecto 		VARCHAR(10),
 IN P_id_concepto 		VARCHAR(10)
)
BEGIN
 IF ((SELECT COUNT(id_conceptoxproyecto)
	FROM CONCEPTOXPROYECTO
	WHERE id_proyecto = P_id_proyecto
	AND id_concepto = P_id_concepto)=0)
 THEN
	INSERT INTO CONCEPTOXPROYECTO(
	id_proyecto,
	id_concepto,
	flagactivo)
	VALUES(
	P_id_proyecto,
	P_id_concepto,
	1);
 ELSE
	UPDATE CONCEPTOXPROYECTO
	SET flagactivo = 1
	WHERE id_proyecto = P_id_proyecto
	AND id_concepto = P_id_concepto;
 END IF;
END$$