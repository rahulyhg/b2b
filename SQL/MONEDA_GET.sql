DELIMITER $$

DROP PROCEDURE IF EXISTS MONEDA_GET$$

CREATE PROCEDURE `MONEDA_GET`(
 IN P_id_moneda	CHAR(11)
)
BEGIN
 SELECT
 M.id_moneda,
 M.c_codigo,
 M.c_moneda,
 M.c_estado AS Estado
 FROM MONEDAS M
 WHERE id_moneda = P_id_moneda
 OR P_id_moneda IS NULL;
END$$
