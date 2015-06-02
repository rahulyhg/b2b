DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_DELETE$$

CREATE PROCEDURE `SUBPROYECTO_DELETE`(
 IN P_id_sproyecto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, SUB_PROYECTOS S
	 where N.id_subcentroasignacion = S.c_scodigo 
	 and S.id_sproyecto = P_id_sproyecto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM SUB_PROYECTOS
 WHERE id_sproyecto = P_id_sproyecto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$