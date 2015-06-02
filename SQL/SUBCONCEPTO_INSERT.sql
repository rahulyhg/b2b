DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_INSERT$$

CREATE PROCEDURE `SUBCONCEPTO_INSERT`( 
-- IN P_ContratistaId INT(11),
-- IN P_TipoEmpresaId VARCHAR(10),
 IN P_c_sconcepto 		VARCHAR(30),
 IN P_c_scodigo 		VARCHAR(10),
 IN P_c_id_concepto		VARCHAR(10),
 IN P_Estado 			CHAR(3)
 -- IN P_Usuario 			VARCHAR(64),
 -- IN P_Fecha 			DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_sconcepto)
	 FROM SUB_CONCEPTOS
	 WHERE c_scodigo = P_c_scodigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con ese código.';
 ELSE
	 INSERT INTO SUB_CONCEPTOS(
	 -- ContratistaId,
	 -- TipoEmpresaId,
	 c_sconcepto,
	 c_scodigo,
	 id_concepto,
	 c_estado)
	 -- UsuarioCreacion,
	 -- f_creacion
	 VALUES(
	 -- P_ContratistaId,
	 -- P_TipoEmpresaId,
	 P_c_sconcepto,
	 P_c_scodigo,
	 P_c_id_concepto,
	 P_Estado);
	 -- P_Usuario,
	 -- P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$