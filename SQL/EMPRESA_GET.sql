DELIMITER $$

DROP PROCEDURE IF EXISTS EMPRESA_GET$$

CREATE PROCEDURE `EMPRESA_GET`(
 IN P_EmpresaId CHAR(10),
 IN P_opcion CHAR(1)
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 E.id_empresa,
		 E.c_codigo,
		 E.c_nomraz,
		 E.c_estado AS Estado
		 FROM EMPRESAS E
		 WHERE id_empresa = P_EmpresaId
		 OR P_EmpresaId IS NULL;
	WHEN '2' THEN
		 SELECT
		 E.c_codigo,
		 concat(E.c_codigo, ' - ', E.c_nomraz) AS Empresa
		 FROM EMPRESAS E
		 WHERE c_estado = 'ACT';
	END CASE;
END$$