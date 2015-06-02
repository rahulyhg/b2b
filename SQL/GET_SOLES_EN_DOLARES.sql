DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SOLES_EN_DOLARES$$

CREATE PROCEDURE `GET_SOLES_EN_DOLARES`(
    IN id_moneda VARCHAR (1))
BEGIN
    SELECT
    SUM(Saldo) AS Soles
    FROM
    (SELECT (SELECT ifnull(SUM(importe),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_cajabanco = C.c_codigo) AS Saldo
    FROM CAJA C
    WHERE C.id_moneda = 2
    ORDER BY C.c_codigo) AS Tabla;
END$$