DELIMITER $$ 

DROP PROCEDURE IF EXISTS CUENTA_DC_GET$$

CREATE PROCEDURE `CUENTA_DC_GET`(
 IN P_id_cuenta	CHAR(11),
 IN P_opcion CHAR(1)
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 C.id_cuenta,
		 C.c_codigo,
		 C.c_cuenta,
		 C.id_empresa,
		 E.c_nomraz AS Empresa,
		 C.c_estado AS Estado
		 FROM CTAS_DC C
		 LEFT JOIN EMPRESAS E ON E.c_codigo = C.id_empresa
		 WHERE id_cuenta = P_id_cuenta
		 OR P_id_cuenta IS NULL
		 ORDER BY C.c_codigo;
	WHEN '2' THEN
		 SELECT
		 C.c_codigo,
		 concat(C.c_codigo, ' - ', C.c_cuenta) AS Cuenta
		 FROM CTAS_DC C
		 WHERE c_estado = 'ACT';
	END CASE;
END$$