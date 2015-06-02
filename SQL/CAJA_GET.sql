DELIMITER $$

DROP PROCEDURE IF EXISTS CAJA_GET$$

CREATE PROCEDURE `CAJA_GET`(
 IN P_id_caja CHAR(10),
 IN P_opcion  INT
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 C.id_caja,
		 C.c_codigo,
		 C.c_caja,
		 C.t_caja,
		 T.c_tipo,
		 C.id_moneda,
		 M.c_moneda AS Moneda,
		 C.id_empresa,
		 C.c_estado AS Estado	
		 FROM CAJA C
		 LEFT JOIN MONEDAS M ON C.id_moneda = M.id_moneda
		 LEFT JOIN EMPRESAS E ON C.id_empresa = E.c_codigo
		 LEFT JOIN TIPO T ON C.t_caja = T.id_tipo
		 WHERE id_caja = P_id_caja
		 OR P_id_caja IS NULL;
	WHEN '2' THEN
		 SELECT
		 C.c_codigo,
		 CONCAT(C.c_codigo,' - ',C.c_caja) AS Caja,
		 C.id_empresa
		 FROM CAJA C
		 WHERE c_estado = 'ACT'
		 ORDER BY C.c_codigo;
	WHEN '3' THEN
		SELECT
		T.id_tipo,
		CONCAT(T.id_tipo, ' - ',T.c_tipo) AS Tipo
		FROM TIPO T
		WHERE id_tipo_padre = 'TCJ'
		ORDER BY  T.id_tipo;
	END CASE;
END$$

