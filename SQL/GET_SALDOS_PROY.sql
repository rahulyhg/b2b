DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOS_PROY$$

CREATE PROCEDURE `GET_SALDOS_PROY`(
    IN P_fecha_ini  DATE,
    IN P_fecha_fin  DATE,
    IN P_id_proy    VARCHAR(10)
)
BEGIN

    SELECT
    P.c_codigo,
    P.c_proyecto,
    (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_centro_asignacion = P.id_proyecto
     AND (N.fecha_sistema >= P_fecha_ini OR P_fecha_ini IS NULL)
     AND (N.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)) AS SaldoDol,
    (SELECT ifnull(sum(importe),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_centro_asignacion = P.id_proyecto
     AND (N.fecha_sistema >= P_fecha_ini OR P_fecha_ini IS NULL)
     AND (N.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)) AS SaldoSol
    FROM PROYECTOS P
    WHERE (P.id_proyecto = P_id_proy OR P_id_proy IS NULL)
    ORDER BY P.c_proyecto;

END$$