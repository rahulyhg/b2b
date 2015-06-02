DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_UPDATE$$

CREATE PROCEDURE `SUBPROYECTO_UPDATE`(
 IN P_id_sproyecto 	INT(11),
 IN P_c_sproyecto 	VARCHAR(30),
-- IN P_c_scodigo	 	VARCHAR(10),
 IN P_id_proyecto	INT,
-- IN P_c_cuenta		VARCHAR(5),
-- IN P_u_cuenta		CHAR(1),
 IN P_c_estado		CHAR(3)
)
BEGIN
 
 UPDATE SUB_PROYECTOS
	 SET
	 c_sproyecto = P_c_sproyecto,
	 -- c_scodigo = P_c_scodigo,
	 id_proyecto = P_id_proyecto,
	 -- c_cuenta = P_c_cuenta,
	 -- u_cuenta = P_u_cuenta,
	 c_estado = P_c_estado
	 -- UsuarioModificacion = P_UsuarioModificacion,
	 -- FechaModificacion = P_FechaModificacion
 WHERE id_sproyecto = P_id_sproyecto;
END$$