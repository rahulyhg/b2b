DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_DELETE$$

CREATE PROCEDURE `PROYECTO_DELETE`(
 IN P_id_proyecto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT  COUNT(S.id_sproyecto)
	 FROM SUB_PROYECTOS S
	 WHERE S.id_proyecto = P_id_proyecto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Sub Centro de Asignación.';
 ELSEIF ((SELECT  COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N
	 WHERE N.id_centro_asignacion = P_id_proyecto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
         DELETE FROM PROYECTOS
          WHERE id_proyecto = P_id_proyecto;
         DELETE FROM CONCEPTOXPROYECTO
          WHERE id_proyecto = P_id_proyecto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$