DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_UPDATE$$

CREATE PROCEDURE `SUBCONCEPTO_UPDATE`(
 IN P_id_sconcepto 	INT(11),
 IN P_c_sconcepto 	VARCHAR(30),
-- IN P_c_scodigo VARCHAR(10),
 IN P_c_id_concepto     VARCHAR(10),	
 IN P_Estado 		CHAR(3)
-- IN P_UsuarioModificacion VARCHAR(64),
-- IN P_FechaModificacion DATETIME
)
BEGIN
 UPDATE SUB_CONCEPTOS
	 SET
	 c_sconcepto = P_c_sconcepto,
	 -- c_scodigo = P_c_scodigo,
	 id_concepto = P_c_id_concepto,
	 c_estado = P_Estado 
	 -- UsuarioModificacion = P_UsuarioModificacion,
	 -- FechaModificacion = P_FechaModificacion
 WHERE id_sconcepto = P_id_sconcepto;
END$$