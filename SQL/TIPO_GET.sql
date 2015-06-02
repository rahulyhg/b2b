DELIMITER $$

DROP PROCEDURE IF EXISTS TIPO_GET$$

CREATE PROCEDURE `TIPO_GET`(
 IN P_id_tipo_padre CHAR(10)
)
BEGIN
 SELECT
 T.id_tipo,
 T.c_tipo
 FROM TIPO T
 WHERE id_tipo_padre = P_id_tipo_padre;
 -- OR P_EmpresaId IS NULL;
END$$