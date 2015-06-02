DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_GET$$

CREATE PROCEDURE `SUBCONCEPTO_GET`(
 IN P_SConceptoId CHAR(10),
 IN P_opcion	  INT
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 C.id_sconcepto,
		 C.c_scodigo,
		 C.c_sconcepto,
		 C.id_concepto,
		 C.c_estado AS Estado,
		 P.c_concepto
		 FROM SUB_CONCEPTOS C
		 LEFT JOIN CONCEPTOS P ON C.id_concepto=P.id_concepto
		 WHERE id_sconcepto = P_SconceptoId
		 OR P_sconceptoId IS NULL;
	WHEN '2' THEN
		 SELECT
		 C.c_scodigo,
		 CONCAT(C.c_scodigo,' - ',C.c_sconcepto) AS SConcepto,
		 C.id_concepto
		 FROM SUB_CONCEPTOS C
		 WHERE c_estado = 'ACT'
		 ORDER BY C.c_scodigo;
	END CASE;
END$$