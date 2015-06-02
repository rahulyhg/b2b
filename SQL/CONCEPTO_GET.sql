DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_GET$$

CREATE PROCEDURE `CONCEPTO_GET`(
 IN P_ConceptoId CHAR(10),
 IN P_opcion CHAR(1)
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 C.id_concepto,
		 C.c_codigo,
		 C.c_concepto,
		 C.c_estado AS Estado
		 -- E.c_estado AS Estado
		 FROM CONCEPTOS C
		 WHERE id_concepto = P_ConceptoId
		 OR P_ConceptoId IS NULL;
	WHEN '2' THEN
		 SELECT
		 C.id_concepto,
		 CONCAT(C.c_codigo,' - ',C.c_concepto) AS Concepto
		 FROM CONCEPTOS C
		 WHERE c_estado = 'ACT'
		 ORDER BY C.c_concepto;
	END CASE;
END$$