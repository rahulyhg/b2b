DELIMITER $$

DROP PROCEDURE IF EXISTS GET_DOLARES_EN_SOLES$$

CREATE PROCEDURE `GET_DOLARES_EN_SOLES`(
    IN id_moneda VARCHAR (1))
BEGIN
    SELECT
    SUM(Saldodol) AS Dolares
    FROM
    (SELECT (SELECT ifnull(SUM(importedol),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_cajabanco = C.c_codigo) AS Saldodol
    FROM CAJA C
    WHERE C.id_moneda = 1
    ORDER BY C.c_codigo) AS Tabla;
END$$