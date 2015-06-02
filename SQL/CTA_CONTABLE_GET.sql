DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_GET$$

CREATE PROCEDURE `CTA_CONTABLE_GET`(
 IN P_id_cuenta CHAR(10)
)
BEGIN
 SELECT
 C.id_cuenta,
 C.c_codigo,
 C.c_cuenta,
 C.c_estado AS Estado
 FROM CTAS_CONTABLES C
 WHERE id_cuenta = P_id_cuenta
 OR P_id_cuenta IS NULL
 ORDER BY C.c_codigo;
END$$