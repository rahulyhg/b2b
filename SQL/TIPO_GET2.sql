-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$


DROP PROCEDURE IF EXISTS TIPO_GET2$$
CREATE PROCEDURE `TIPO_GET2`(
 IN T_id_tipo CHAR(10),
 IN T_opcion CHAR(1)
)
BEGIN
		CASE T_opcion
		WHEN '1' THEN
		 SELECT
		 T.id_tipo,
		 T.id_tipo_padre,
		 T.c_tipo,
		 T.estado
		 FROM TIPO T 
		 WHERE id_tipo = T_id_tipo
		 OR T_id_tipo IS NULL
		order by T.id_tipo_padre;
		 WHEN '2' THEN
		 SELECT
		 T.id_tipo,
		 concat(T.id_tipo, ' - ', T.c_tipo) AS Padre
		 FROM TIPO T
		 WHERE id_tipo_padre is null or id_tipo_padre=''
		 ORDER BY T.c_tipo;
		END CASE;
 END$$