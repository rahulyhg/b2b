DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOS$$

CREATE PROCEDURE `GET_SALDOS`(
    IN P_fecha_ini DATE,
    IN P_fecha_fin DATE,
    IN P_id_caja	VARCHAR(10)
)
BEGIN

    SELECT
    C.c_codigo,
    C.c_caja,
    (SELECT ifnull(SUM(importedol),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_cajabanco = C.c_codigo
     AND (N.fecha_sistema >= P_fecha_ini OR P_fecha_ini IS NULL)
     AND (N.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)) AS SaldoDol,
    (SELECT ifnull(SUM(importe),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_cajabanco = C.c_codigo
     AND (N.fecha_sistema >= P_fecha_ini OR P_fecha_ini IS NULL)
     AND (N.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)) AS SaldoSol
    FROM CAJA C
    WHERE (C.c_codigo = P_id_caja OR P_id_caja IS NULL)
    ORDER BY C.c_codigo;

END$$