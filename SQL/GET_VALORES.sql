DELIMITER $$

DROP PROCEDURE IF EXISTS `GET_VALORES`$$

CREATE PROCEDURE `GET_VALORES`()
BEGIN

    SELECT
    C.c_codigo,
    C.c_caja,
    (SELECT IFNULL(SUM(importedol),0) FROM NUEVA_TRANSACCION N 
    WHERE N.id_cajabanco = C.c_codigo) AS TotalDol
    FROM CAJA C
    ORDER BY C.c_codigo;

END$$
