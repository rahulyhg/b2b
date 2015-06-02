DELIMITER $$
DROP PROCEDURE IF EXISTS GET_CANTIDAD$$

CREATE PROCEDURE `GET_CANTIDAD`(
 IN D_id_moneda int (1)
)
BEGIN

 SELECT(COUNT(id_caja) ) AS 'cantidad' FROM CAJA WHERE id_moneda = D_id_moneda;
END$$