-- ----------------------------------------------------------------------------------------- --
--                   STORED PROCEDURES DE LA BD iprofesi_caja                                --
-- NOTAS: NO OLVIDAR PONER MAYUSCULAS EN LOS NOMBRES DE TABLAS EN CADA UNO DE LOS PROCEDURES --
-- 	  TAMPOCO QUE LOS PROCEDURE TENGAN SUS DROPS RESPECTIVOS. GUIARSE DE ESTE SCRIPT     --
-- 	  MENOS OLVIDARSE QUE NO DEBEN DE TENER " DEFINER=` `@` ` " EN NINGUN PROCEDURE      --
-- ----------------------------------------------------------------------------------------- --

DELIMITER $$

DROP PROCEDURE IF EXISTS CAJA_DELETE$$

CREATE PROCEDURE `CAJA_DELETE`(
 IN P_id_caja INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, CAJA C
	 WHERE N.id_cajabanco = C.c_codigo 
	 AND C.id_caja = P_id_caja)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Centro de Asignación.';
 ELSE
	 DELETE FROM CTAS_DC
	 WHERE c_codigo = (SELECT 1000+(SELECT C.c_codigo FROM CAJA C WHERE C.id_caja=P_id_caja));
	 
	 DELETE FROM CAJA
	 WHERE id_caja = P_id_caja;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$

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

DELIMITER $$

DROP PROCEDURE IF EXISTS CAJA_INSERT$$

CREATE PROCEDURE `CAJA_INSERT`(
 IN P_c_caja 		VARCHAR(50),
 IN P_c_codigo	 	VARCHAR(10),
 IN P_id_moneda		INT,
 IN P_id_empresa	VARCHAR(5),
 IN P_t_caja		VARCHAR(3),
-- IN P_c_cuenta		CHAR(1),
 IN P_Estado 		CHAR(3),
 IN P_Fecha 		DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_caja)
	 FROM CAJA
	 WHERE c_caja = P_c_caja
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 IF((SELECT COUNT(id_cuenta)
		 FROM CTAS_DC
		 WHERE c_codigo = (SELECT 1000+P_c_codigo))>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
	 ELSE
		 INSERT INTO CAJA(
		 c_caja,
		 c_codigo,
		 id_moneda,
		 id_empresa,
		 t_caja,
		 -- c_cuenta,
		 c_estado,
		 f_creacion)
		 VALUES(
		 P_c_caja,
		 P_c_codigo,
		 P_id_moneda,
		 P_id_empresa,
		 P_t_caja,
		 -- P_c_cuenta,
		 P_Estado,
		 P_Fecha );
		 
		 INSERT INTO CTAS_DC(
		 c_cuenta,
		 c_codigo,
		 id_empresa,
		 c_estado,
		 f_creacion)
		 VALUES(
		 P_c_caja,
		 (SELECT 1000+P_c_codigo),
		 P_id_empresa,
		 P_Estado,
		 P_Fecha );
	END IF;
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CAJA_UPDATE$$

CREATE PROCEDURE `CAJA_UPDATE`(
 IN P_id_caja 		INT(11),
 IN P_c_caja 		VARCHAR(50),
-- IN P_c_codigo	 	VARCHAR(10),
 IN P_id_moneda		INT,
-- IN P_id_empresa	VARCHAR(5),
 IN P_t_caja 		VARCHAR(3),
-- IN P_c_cuenta		VARCHAR(5),
 IN P_c_estado		CHAR(3)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM CAJA C
	 WHERE c_caja = P_c_caja
	 AND C.id_caja != P_id_caja)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 UPDATE CTAS_DC
		 SET
		 c_cuenta   = P_c_caja,
		 c_estado 	= P_c_estado
	 WHERE c_codigo = (SELECT 1000+(SELECT C.c_codigo FROM CAJA C WHERE C.id_caja=P_id_caja));
	 
	 UPDATE CAJA
		 SET
		 c_caja = P_c_caja,
		 -- c_codigo = P_c_codigo,
		 id_moneda = P_id_moneda,
		 -- id_empresa = P_id_empresa,
		 t_caja = P_t_caja,
		 -- c_cuenta = P_c_cuenta,
		 c_estado = P_c_estado
	 WHERE id_caja = P_id_caja;
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_DELETE$$

CREATE PROCEDURE `CONCEPTO_DELETE`(
 IN P_id_concepto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(S.id_sconcepto)
	 FROM SUB_CONCEPTOS S
	 WHERE S.id_concepto = P_id_concepto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Sub Concepto.';
 ELSEIF ((SELECT COUNT(C.id_conceptoxproyecto)
	 FROM CONCEPTOXPROYECTO C
	 WHERE C.id_concepto = P_id_concepto)>0)
	 THEN SET P_ERROR = 'El registro esta asignado a un Centro de Asignación.';
 ELSEIF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N
	 WHERE N.id_concepto = P_id_concepto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM CONCEPTOS
 WHERE id_concepto = P_id_concepto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_GET$$

CREATE PROCEDURE `CONCEPTO_GET`(
 IN P_ConceptoId CHAR(10),
 IN P_opcion CHAR(1)
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 C.id_concepto,
		 C.c_codigo,
		 C.c_concepto,
		 C.c_estado AS Estado
		 -- E.c_estado AS Estado
		 FROM CONCEPTOS C
		 WHERE id_concepto = P_ConceptoId
		 OR P_ConceptoId IS NULL;
	WHEN '2' THEN
		 SELECT
		 C.id_concepto,
		 CONCAT(C.c_codigo,' - ',C.c_concepto) AS Concepto
		 FROM CONCEPTOS C
		 WHERE c_estado = 'ACT'
		 ORDER BY C.c_concepto;
	END CASE;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_INSERT$$

CREATE PROCEDURE `CONCEPTO_INSERT`( 
-- IN P_ContratistaId INT(11),
-- IN P_TipoEmpresaId VARCHAR(10),
 IN P_c_concepto 	VARCHAR(30),
 IN P_c_codigo 		VARCHAR(10),
 IN P_Estado 		CHAR(3)
 -- IN P_Usuario 			VARCHAR(64),
 -- IN P_Fecha 			DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_concepto)
	 FROM CONCEPTOS
	 WHERE c_concepto = P_c_concepto
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO CONCEPTOS(
	 -- ContratistaId,
	 -- TipoEmpresaId,
	 c_concepto,
	 c_codigo,
	 c_estado)
	 -- UsuarioCreacion,
	-- f_creacion
		
	 VALUES(
	 -- P_ContratistaId,
	 -- P_TipoEmpresaId,
	 P_c_concepto,
	 P_c_codigo ,
	 P_Estado);
	 -- P_Usuario,
	-- P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_PROYECTO_GET$$

CREATE PROCEDURE `CONCEPTO_PROYECTO_GET`(
 IN P_id_proyecto CHAR(10)
)
BEGIN
 SELECT
 C.id_concepto
 FROM CONCEPTOXPROYECTO C
 WHERE C.id_proyecto = P_id_proyecto
 AND flagactivo = 1;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_PROYECTO_INSERT$$

CREATE PROCEDURE `CONCEPTO_PROYECTO_INSERT`(
 IN P_id_proyecto 		VARCHAR(10),
 IN P_id_concepto 		VARCHAR(10)
)
BEGIN
 IF ((SELECT COUNT(id_conceptoxproyecto)
	FROM CONCEPTOXPROYECTO
	WHERE id_proyecto = P_id_proyecto
	AND id_concepto = P_id_concepto)=0)
 THEN
	INSERT INTO CONCEPTOXPROYECTO(
	id_proyecto,
	id_concepto,
	flagactivo)
	VALUES(
	P_id_proyecto,
	P_id_concepto,
	1);
 ELSE
	UPDATE CONCEPTOXPROYECTO
	SET flagactivo = 1
	WHERE id_proyecto = P_id_proyecto
	AND id_concepto = P_id_concepto;
 END IF;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_PROYECTO_UPDATE$$

CREATE PROCEDURE `CONCEPTO_PROYECTO_UPDATE`(
 IN P_id_proyecto 		VARCHAR(10)
)
BEGIN
	UPDATE CONCEPTOXPROYECTO
	SET flagactivo = 0
	WHERE id_proyecto = P_id_proyecto;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS CONCEPTO_UPDATE$$

CREATE PROCEDURE `CONCEPTO_UPDATE`(
 IN P_id_concepto INT(11),
 -- IN P_TipoEmpresaId VARCHAR(10),
 IN P_c_concepto VARCHAR(30),
-- IN P_c_codigo VARCHAR(10),
 IN P_c_estado CHAR(3)
-- IN P_Estado CHAR(10),
-- IN P_UsuarioModificacion VARCHAR(64),
-- IN P_FechaModificacion DATETIME
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM CONCEPTOS C
	 WHERE (c_concepto = P_c_concepto)
	 -- and E.TipoEmpresaId = P_TipoEmpresaId
	 AND C.id_concepto != P_id_concepto)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE CONCEPTOS
	 SET
	 c_concepto = P_c_concepto,
	 c_estado = P_c_estado
	 -- Estado = P_Estado ,
	 -- UsuarioModificacion = P_UsuarioModificacion,
	 -- FechaModificacion = P_FechaModificacion
 WHERE id_concepto = P_id_concepto;
 END IF;
 SELECT P_ERROR as Mensaje; 
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_DELETE$$

CREATE PROCEDURE `CTA_CONTABLE_DELETE`(
 IN P_id_cuenta INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT  COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, CTAS_CONTABLES C
	 WHERE (N.id_cuecontable = C.c_codigo
		OR N.id_cuecontablecr = C.c_codigo)
	 AND C.id_cuenta = P_id_cuenta)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Centro de Asignación.';
 ELSE
 DELETE FROM CTAS_CONTABLES
 WHERE id_cuenta = P_id_cuenta;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_GET$$

CREATE PROCEDURE `CTA_CONTABLE_GET`(
 IN P_id_cuenta CHAR(10)
)
BEGIN
 SELECT
 C.id_cuenta,
 C.c_codigo,
 C.c_cuenta,
 C.c_estado AS Estado
 FROM CTAS_CONTABLES C
 WHERE id_cuenta = P_id_cuenta
 OR P_id_cuenta IS NULL
 ORDER BY C.c_codigo;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_INSERT$$

CREATE PROCEDURE `CTA_CONTABLE_INSERT`(
 IN P_c_cuenta 	VARCHAR(60),
 IN P_c_codigo 	VARCHAR(10),
 IN P_Estado 	CHAR(10),
 IN P_Fecha 	DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_cuenta)
	 FROM CTAS_CONTABLES
	 WHERE c_cuenta = P_c_cuenta
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO CTAS_CONTABLES(
	 c_cuenta,
	 c_codigo,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_cuenta,
	 P_c_codigo,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CTA_CONTABLE_UPDATE$$

CREATE PROCEDURE `CTA_CONTABLE_UPDATE`(
 IN P_id_cuenta INT(11),
 -- IN P_c_codigo 	VARCHAR(10),
 IN P_c_cuenta 	VARCHAR(60),
 IN P_c_estado 	CHAR(10)
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_cuenta)
	 FROM CTAS_CONTABLES
	 WHERE c_cuenta = P_c_cuenta
	 -- OR c_codigo = P_c_codigo
	 )>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE

	 UPDATE CTAS_CONTABLES
	 SET
			-- c_codigo = P_c_codigo,
			c_cuenta = P_c_cuenta,
			c_estado = P_c_estado
	 WHERE  id_cuenta = P_id_cuenta;

 END IF;
 SELECT P_ERROR AS Mensaje; END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CUENTA_DC_DELETE$$

CREATE PROCEDURE `CUENTA_DC_DELETE`(
 IN P_id_cuenta INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(P.id_proyecto)
	 FROM PROYECTOS P, CTAS_DC D
	 WHERE (P.cta_control = D.c_codigo 
		OR P.cta_ingreso = D.c_codigo)
	 AND D.id_cuenta = P_id_cuenta)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Centro de Asignación.';
 ELSEIF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, CTAS_DC D
	 WHERE (N.id_cuecontablecc = D.c_codigo 
		OR N.id_cuecontablecccr = D.c_codigo)
	 AND D.c_codigo = P_id_cuenta)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM CTAS_DC
 WHERE id_cuenta = P_id_cuenta;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$


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


DELIMITER $$

DROP PROCEDURE IF EXISTS CUENTA_DC_INSERT$$

CREATE PROCEDURE `CUENTA_DC_INSERT`(
 IN P_c_cuenta 	 VARCHAR(60),
 IN P_c_codigo 	 VARCHAR(10),
 IN P_id_empresa VARCHAR(10),
 IN P_Estado 	 CHAR(10),
 IN P_Fecha 	 DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_cuenta)
	 FROM CTAS_DC
	 WHERE c_cuenta = P_c_cuenta
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO CTAS_DC(
	 c_cuenta,
	 c_codigo,
	 id_empresa,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_cuenta,
	 P_c_codigo,
	 P_id_empresa,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS CUENTA_DC_UPDATE$$

CREATE PROCEDURE `CUENTA_DC_UPDATE`(
 IN P_id_cuenta INT(11),
 IN P_c_cuenta VARCHAR(60),
-- IN P_c_codigo VARCHAR(10),
 IN P_id_empresa VARCHAR(10),
 IN P_c_estado CHAR(10)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM CTAS_DC C
	 WHERE c_cuenta = P_c_cuenta
	 AND C.id_cuenta != P_id_cuenta)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE CTAS_DC
	 SET
	 c_cuenta = P_c_cuenta,
	 -- c_codigo = P_c_codigo,
	 id_empresa = P_id_empresa,
	 c_estado = P_c_estado
 WHERE id_cuenta = P_id_cuenta;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS EMPRESA_DELETE$$

CREATE PROCEDURE `EMPRESA_DELETE`(
 IN P_id_empresa INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(C.id_caja)
	 FROM CAJA C, EMPRESAS E
	 WHERE C.id_empresa = E.c_codigo
	 AND E.id_empresa = P_id_empresa)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en una Caja.';
 ELSEIF ((SELECT COUNT(C.id_cuenta)
	 FROM CTAS_DC C, EMPRESAS E
	 WHERE C.id_empresa = E.c_codigo
	 AND E.id_empresa = P_id_empresa)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en una Cuenta Central.';
 ELSEIF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, EMPRESAS E
	 WHERE N.id_empresa = E.c_codigo
	 AND E.id_empresa = P_id_empresa)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM EMPRESAS
 WHERE id_empresa = P_id_empresa;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$

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


DELIMITER $$

DROP PROCEDURE IF EXISTS EMPRESA_INSERT$$

CREATE PROCEDURE `EMPRESA_INSERT`(
 IN P_c_nomraz 	VARCHAR(60),
 IN P_c_codigo 	VARCHAR(10),
 IN P_Estado 	CHAR(3),
 IN P_Fecha 	DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_empresa)
	 FROM EMPRESAS
	 WHERE c_nomraz = P_c_nomraz
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO EMPRESAS(
	 c_nomraz,
	 c_codigo,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_nomraz,
	 P_c_codigo,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS EMPRESA_UPDATE$$

CREATE PROCEDURE `EMPRESA_UPDATE`(
 IN P_id_empresa 	INT(11),
 IN P_c_nomraz 		VARCHAR(60),
 IN P_c_estado 		CHAR(3)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM EMPRESAS E
	 WHERE c_nomraz = P_c_nomraz
	 AND E.id_empresa != P_id_empresa)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE EMPRESAS
	 SET
	 c_nomraz = P_c_nomraz,
	 c_estado = P_c_estado
 WHERE id_empresa = P_id_empresa;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS GET_CANTIDAD$$

CREATE PROCEDURE `GET_CANTIDAD`(
IN D_id_moneda int (1)
)
BEGIN

 SELECT(COUNT(id_caja) ) AS 'cantidad' FROM CAJA WHERE id_moneda = D_id_moneda;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_DOLARES_EN_DOLARES$$


CREATE PROCEDURE `GET_DOLARES_EN_DOLARES`(
    IN id_monema VARCHAR (1))
BEGIN
    SELECT	
    SUM(Saldodol) AS Dolares
    FROM
    (SELECT (SELECT ifnull(SUM(importedol),0) FROM nueva_transaccion N 
     WHERE N.id_cajabanco = C.c_codigo) AS Saldodol
    FROM CAJA C
    WHERE C.id_moneda = 2
    ORDER BY C.c_codigo) AS Tabla;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS GET_DOLARES_EN_SOLES$$

CREATE PROCEDURE `GET_DOLARES_EN_SOLES`(
    IN id_monema VARCHAR (1))
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

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_RENDICION$$

CREATE PROCEDURE `GET_RENDICION`(
 IN P_rendicion	VARCHAR(1)
)
BEGIN
	SELECT
		rendicion
	FROM
		NUEVA_TRANSACCION
	WHERE
		rendicion <> ''
	ORDER BY id_transaccion DESC
	LIMIT 1;
END$$

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

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOSXCAJA$$

CREATE PROCEDURE `GET_SALDOSXCAJA`(
 IN fecha INT
)
BEGIN
	SELECT
	 C.cuen_caja AS Cuenta,
	 C.c_caja AS Caja,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema < (SELECT CONCAT(fecha,'-01-01'))) AS SInicial,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-01-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-01-31'))) AS Ene,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-02-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-02-29'))) AS Feb,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-03-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-03-31'))) AS Mar,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-04-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-04-30'))) AS Abr,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-05-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-05-31'))) AS May,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-06-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-06-30'))) AS Jun,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-07-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-07-31'))) AS Jul,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-08-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-08-31'))) AS Ago,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-09-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-09-30'))) AS Sep,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-10-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-10-31'))) AS Oct,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-11-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-11-30'))) AS Nov,
	 (SELECT ifnull(sum(importedol),0) FROM NUEVA_TRANSACCION N 
	 WHERE N.id_cajabanco = C.c_codigo
	 AND N.fecha_sistema >= (SELECT CONCAT(fecha,'-12-01'))
	 AND N.fecha_sistema <= (SELECT CONCAT(fecha,'-12-31'))) AS Dic
	FROM CAJA C
	ORDER BY C.cuen_caja;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOSXMES$$

CREATE PROCEDURE `GET_SALDOSXMES`(
 IN fecha INT
)
BEGIN
	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecc = '',  id_cuecontablecccr = '';

	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecc = '2995',  id_cuecontablecccr = '2995'
	WHERE  id_empresa IN ( 'SIN','REP') ;

	UPDATE NUEVA_TRANSACCION n, CAJA c
	SET n.id_cuecontablecc = '2995', n.id_cuecontablecccr = '2995'
	WHERE n. id_empresa NOT IN ( 'SIN','REP') 
	AND n.id_cajabanco = c.c_codigo
	AND n.id_empresa = c.id_empresa;

	UPDATE NUEVA_TRANSACCION n, CTAS_DC d
	SET n.id_cuecontablecc = d.c_codigo, n.id_cuecontablecccr = '2997'
	WHERE n.id_empresa NOT IN ( 'SIN','REP')  
	AND n.tipo_transaccion = 'Egreso'
	AND n.id_cuecontablecc = '' AND  n.id_cuecontablecccr = ''
	AND n.id_empresa = d.id_empresa
	AND LEFT(d.c_codigo,1) = '2';

	UPDATE NUEVA_TRANSACCION n, CTAS_DC d
	SET n.id_cuecontablecc = '2997', n.id_cuecontablecccr = d.c_codigo
	WHERE n. id_empresa NOT IN ( 'SIN','REP') 
	AND n.tipo_transaccion = 'INgreso'
	AND n.id_cuecontablecc = '' AND  n.id_cuecontablecccr = ''
	AND n.id_empresa = d.id_empresa
	AND LEFT(d.c_codigo,1) = '2';
	/*
	SELECT * FROM NUEVA_TRANSACCION
	WHERE id_cuecontablecc = '' AND  id_cuecontablecccr ='';
	
	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecc = ''
	WHERE id_cuecontablecc = '2995'

	UPDATE NUEVA_TRANSACCION
	SET id_cuecontablecccr = ''
	WHERE id_cuecontablecccr = '2995'
	*/
	-- --- REPORTE -----
	TRUNCATE TABLE REPORTE;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT CONCAT('10',id_cajabanco), 0, ABS(importedol), fecha_registro, id_transaccion FROM NUEVA_TRANSACCION
	WHERE tipo_transaccion = 'Ingreso';

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_control, ABS(n.importedol), 0, n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'Ingreso'
	AND n.id_subconsepto IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_INgreso, ABS(n.importedol), 0, n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'INgreso'
	AND n.id_subconsepto NOT IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT CONCAT('10',id_cajabanco), ABS(importedol), 0, fecha_registro, id_transaccion FROM NUEVA_TRANSACCION
	WHERE tipo_transaccion = 'Egreso';

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_control, 0, ABS(n.importedol), n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'Egreso'
	AND n.id_subconsepto IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT p.cta_INgreso, 0, ABS(n.importedol), n.fecha_registro, n.id_transaccion FROM NUEVA_TRANSACCION n, PROYECTOS p 
	WHERE n.tipo_transaccion = 'Egreso'
	AND n.id_subconsepto NOT IN ('INVP','INVC')
	AND p.id_proyecto = n.id_centro_ASignacion;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT id_cuecontablecc, importedol, 0, fecha_registro, id_transaccion FROM NUEVA_TRANSACCION;

	INSERT INTO REPORTE (cuenta, debe, haber, fecha, id)
	SELECT id_cuecontablecccr, 0, importedol, fecha_registro, id_transaccion FROM NUEVA_TRANSACCION;

	/*
	UPDATE REPORTE
	SET fecha = '2011/12/31'
	WHERE fecha = '2012/01/01'
	*/

	-- SELECT SUM(debe), SUM(haber) FROM REPORTE;
	-- --------------- FIN REPORTE ---------------

	SELECT 
	CASE 	WHEN r.cuenta < 2000  THEN '1.- CAJA BANCO'
			WHEN r.cuenta < 4000  THEN '2.- CTAS CTES VARIAS'
			WHEN r.cuenta < 5000  THEN '3.- PROYECTOS'
			WHEN r.cuenta < 7000  THEN '4.- CTAS VARIAS'
			WHEN r.cuenta < 8000  THEN '5.- PATRIMONIO'
			WHEN r.cuenta < 9000  THEN '6.- INGRESO'
			WHEN r.cuenta < 10000 THEN '7.- EGRESO'
	END AS TITULO,
	r.cuenta AS Cuenta, c.c_cuenta AS Descripcion,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)=1,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)=1,r.haber,0)) AS SInicial,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)>=2,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)>=2,r.haber,0)) AS Ene,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=2,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=2,r.haber,0)) AS Feb,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=3,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=3,r.haber,0)) AS Mar,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=4,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=4,r.haber,0)) AS Abr,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=5,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=5,r.haber,0)) AS May,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=6,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=6,r.haber,0)) AS Jun,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=7,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=7,r.haber,0)) AS Jul,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=8,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=8,r.haber,0)) AS Ago,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=9,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=9,r.haber,0)) AS Sep,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=10,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=10,r.haber,0)) AS Oct,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=11,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=11,r.haber,0)) AS Nov,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)<=29,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)<=29,r.haber,0)) AS Dic,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=30,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=30,r.haber,0)) AS Ajuste,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=31,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=31,r.haber,0)) AS Cierre,
	SUM(IF(YEAR(r.fecha)=fecha,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha,r.haber,0)) AS SFinal
	FROM REPORTE r, CTAS_DC c
	WHERE r.cuenta = c.c_codigo
	AND r.cuenta<8000
	AND LEFT(r.cuenta,1) != '2'
	GROUP BY r.cuenta;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SALDOSXMES2$$

CREATE PROCEDURE `GET_SALDOSXMES2`(
 IN fecha INT
)
BEGIN
	SELECT
	CASE 	WHEN r.cuenta < 2000  THEN '1 CAJA BANCO'
			WHEN r.cuenta < 4000  THEN '2 CTAS CTES VARIAS'
			WHEN r.cuenta < 5000  THEN '3 PROYECTOS'
			WHEN r.cuenta < 7000  THEN '4 CTAS VARIAS'
			WHEN r.cuenta < 8000  THEN '5 PATRIMONIO'
			WHEN r.cuenta < 9000  THEN '6 INGRESO'
			WHEN r.cuenta < 10000 THEN '7 EGRESO'
	END AS TITULO,
	r.cuenta AS Cuenta, c.c_cuenta AS Descripcion,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)=1,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)=1,r.haber,0)) AS SInicial,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)>=2,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=1 AND DAY(r.fecha)>=2,r.haber,0)) AS Ene,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=2,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=2,r.haber,0)) AS Feb,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=3,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=3,r.haber,0)) AS Mar,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=4,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=4,r.haber,0)) AS Abr,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=5,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=5,r.haber,0)) AS May,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=6,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=6,r.haber,0)) AS Jun,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=7,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=7,r.haber,0)) AS Jul,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=8,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=8,r.haber,0)) AS Ago,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=9,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=9,r.haber,0)) AS Sep,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=10,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=10,r.haber,0)) AS Oct,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=11,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=11,r.haber,0)) AS Nov,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)<=29,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)<=29,r.haber,0)) AS Dic,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=30,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=30,r.haber,0)) AS Ajuste,
	SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=31,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha AND MONTH(r.fecha)=12 AND DAY(r.fecha)=31,r.haber,0)) AS Cierre,
	SUM(IF(YEAR(r.fecha)=fecha,r.debe,0))-SUM(IF(YEAR(r.fecha)=fecha,r.haber,0)) AS SFinal
	FROM REPORTE r, CTAS_DC c
	WHERE r.cuenta = c.c_codigo
	AND r.cuenta>7999
	AND LEFT(r.cuenta,1) != '2'
	GROUP BY r.cuenta;
END$$

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
    (SELECT ifnull(SUM(importedol),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_centro_asignacion = P.id_proyecto
     AND (N.fecha_sistema >= P_fecha_ini OR P_fecha_ini IS NULL)
     AND (N.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)) AS SaldoDol,
    (SELECT ifnull(SUM(importe),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_centro_asignacion = P.id_proyecto
     AND (N.fecha_sistema >= P_fecha_ini OR P_fecha_ini IS NULL)
     AND (N.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)) AS SaldoSol
    FROM PROYECTOS P
    WHERE (P.id_proyecto = P_id_proy OR P_id_proy IS NULL)
    ORDER BY P.c_proyecto;

END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SOLES_EN_DOLARES$$

CREATE PROCEDURE `GET_SOLES_EN_DOLARES`(
    IN id_monema VARCHAR (1))
BEGIN
    SELECT
    SUM(Saldo) AS Soles
    FROM
    (SELECT (SELECT ifnull(SUM(importe),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_cajabanco = C.c_codigo) AS Saldo
    FROM caja C
    WHERE C.id_moneda = 2
    ORDER BY C.c_codigo) AS Tabla;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_SOLES_EN_SOLES$$

CREATE PROCEDURE `GET_SOLES_EN_SOLES`(
    IN id_monema VARCHAR(1))
BEGIN
    SELECT
    SUM(Saldo) AS Soles
    FROM
    (SELECT (SELECT ifnull(SUM(importe),0) FROM NUEVA_TRANSACCION N 
     WHERE N.id_cajabanco = C.c_codigo) AS Saldo
    FROM caja C
    WHERE C.id_moneda = 1
    ORDER BY C.c_codigo) AS Tabla;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS GET_TOTAL$$

CREATE PROCEDURE `GET_TOTAL`()

BEGIN

    SELECT
    SUM(importe) AS valortotal FROM
    NUEVA_TRANSACCION;

END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS GET_ULTIMA_FECHA$$

CREATE PROCEDURE `GET_ULTIMA_FECHA`(
 IN P_rendicion	VARCHAR(1)
)
BEGIN
	SELECT
		fecha_sistema
	FROM
		NUEVA_TRANSACCION
	WHERE eliminada IS NULL
	ORDER BY fecha_sistema DESC
	LIMIT 1;
END$$


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

DELIMITER $$

DROP PROCEDURE IF EXISTS MONEDA_INSERT$$

CREATE PROCEDURE `MONEDA_INSERT`(
 IN P_c_moneda 	VARCHAR(60),
 IN P_c_codigo 	VARCHAR(10),
 IN P_Estado 	CHAR(10),
 IN P_Fecha 	DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_moneda)
	 FROM MONEDAS
	 WHERE c_moneda = P_c_moneda
	 OR c_codigo = P_c_codigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO MONEDAS(
	 c_moneda,
	 c_codigo,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_moneda,
	 P_c_codigo,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS MONEDA_UPDATE$$

CREATE PROCEDURE `MONEDA_UPDATE`(
 IN P_id_moneda INT(11),
 IN P_c_moneda VARCHAR(60),
 IN P_c_codigo VARCHAR(10),
 IN P_c_estado CHAR(10)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM MONEDAS M
	 WHERE (c_moneda = P_c_moneda
	 OR c_codigo = P_c_codigo)
	 -- and E.TipoEmpresaId = P_TipoEmpresaId
	 AND M.id_moneda != P_id_moneda)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
 UPDATE MONEDAS
	 SET
	 c_moneda = P_c_moneda,
	 c_codigo = P_c_codigo,
	 c_estado = P_c_estado
 WHERE id_moneda = P_id_moneda;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS MPC_TC_CONFIGURACION_ACCESO_GET$$

CREATE PROCEDURE `MPC_TC_CONFIGURACION_ACCESO_GET`( IN P_Perfil VARCHAR(10), IN P_App VARCHAR(32), IN P_Clase VARCHAR(32), IN P_Funcion VARCHAR(32), IN P_Opcion CHAR(1) )
BEGIN CASE P_Opcion WHEN 'M' THEN SELECT CA.FuncionId FROM MPC_TC_CONFIGURACION_ACCESO CA INNER JOIN MPC_TC_OBJETO O ON CA.ClaseId = O.ObjetoId WHERE CA.PerfilId = P_Perfil AND CA.AplicacionId = P_App AND O.ObjetoPadreId = 'menu' AND CA.FlagActivo = 'S' ORDER BY CA.FuncionId ASC; WHEN 'C' THEN SELECT CA.FuncionId FROM MPC_TC_CONFIGURACION_ACCESO CA INNER JOIN MPC_TC_OBJETO O ON CA.ClaseId = O.ObjetoId WHERE CA.PerfilId = P_Perfil AND CA.AplicacionId = P_App AND CA.ClaseId = P_Clase AND CA.FuncionId = P_Funcion AND O.ObjetoPadreId = 'class' AND CA.FlagActivo = 'S'; END CASE; END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS MPC_TC_CONFIGURACION_ACCESO_GET2$$

CREATE PROCEDURE `MPC_TC_CONFIGURACION_ACCESO_GET2`( IN P_ConfigId CHAR(96) )
BEGIN SELECT CA.PerfilId, CA.AplicacionId, CA.ClaseId, CA.FuncionId, CA.Codigo, CA.FlagActivo FROM MPC_TC_CONFIGURACION_ACCESO CA WHERE P_ConfigId = CONCAT(CA.PerfilId, CA.AplicacionId, CA.ClaseId, CA.FuncionId); END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS MPC_TC_OBJETO_GET$$

CREATE PROCEDURE `MPC_TC_OBJETO_GET`( IN P_PadreId CHAR(32), IN P_PadreId2 CHAR(32), IN P_Opcion CHAR(1) )
BEGIN CASE P_Opcion WHEN '1' THEN SELECT ObjetoId, CONCAT(ObjetoId, ' - ' ,Descripcion) AS Descripcion FROM MPC_TC_OBJETO O WHERE Estado = 'COD0000002' and (ObjetoPadreId = P_PadreId or ObjetoPadreId = P_PadreId2); WHEN '2' THEN SELECT ObjetoId, CONCAT(ObjetoId, ' - ' ,Descripcion) AS Descripcion FROM MPC_TC_OBJETO; WHEN '3' THEN SELECT * FROM MPC_TC_OBJETO O WHERE O.ObjetoId = P_PadreId; WHEN '4' THEN SELECT ObjetoId, CONCAT(ObjetoId, ' - ' ,Descripcion) AS Descripcion FROM MPC_TC_OBJETO WHERE ObjetoId != P_PadreId; END CASE; END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS MPC_TM_PERFIL_GET$$

CREATE PROCEDURE `MPC_TM_PERFIL_GET`( IN P_PerfilId CHAR(10), IN P_Opcion CHAR(1) )
BEGIN CASE P_Opcion WHEN '1' THEN SELECT PerfilId, NombrePerfil, DescripcionPerfil, PerfilPadreId, Nivel, Estado, UsuarioCreacion, FechaCreacion, UsuarioModificacion, FechaModificacion FROM MPC_TM_PERFIL P WHERE P.PerfilId = P_PerfilId; WHEN '2' THEN SELECT PerfilId AS ID, NombrePerfil AS Descripcion FROM MPC_TM_PERFIL; WHEN '3' THEN SELECT PerfilId AS ID, NombrePerfil AS Descripcion FROM MPC_TM_PERFIL WHERE Estado = 'COD0000002'; WHEN '4' THEN SELECT PerfilId AS ID, NombrePerfil AS Descripcion FROM MPC_TM_PERFIL WHERE PerfilId != P_PerfilId; END CASE; END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS MPC_TM_USUARIO_VALID$$

CREATE PROCEDURE `MPC_TM_USUARIO_VALID`(
 IN P_UsuarioId VARCHAR(64),
 IN P_Password VARCHAR(64),
 IN P_Opcion CHAR(1)
 )
BEGIN
 CASE
 P_Opcion WHEN '1'
 THEN SELECT
 PE.PerfilId,
 U.UsuarioId,
 U.UsuarioNombre

 FROM MPC_TM_PERFIL PE
 INNER JOIN MPC_TC_USUARIO_PERFIL UP
 ON PE.PerfilId = UP.PerfilId
 INNER JOIN MPC_TM_USUARIO U
 ON UP.UsuarioId = U.UsuarioId

 WHERE U.UsuarioId = P_UsuarioId
 AND U.Password = P_Password
 AND U.Estado = 'COD0000002'

 AND PE.Estado = 'COD0000002'
 AND UP.Estado = 'COD0000002';
 END CASE;
 END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS NUEVA_TRANSACCION_DELETE$$

CREATE PROCEDURE `NUEVA_TRANSACCION_DELETE`(
 IN P_id_transaccion INT(11)
)
BEGIN
 UPDATE NUEVA_TRANSACCION
	 SET
	 eliminada = 1
 WHERE id_transaccion = P_id_transaccion;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS NUEVA_TRANSACCION_GET$$

CREATE PROCEDURE `NUEVA_TRANSACCION_GET`(
 IN P_id_transaccion 	CHAR(10),
 IN P_opcion            INT,
 IN P_fecha_ini		DATE,
 IN P_fecha_fin		DATE
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		SELECT 
		N.id_transaccion,
		N.tipo_transaccion,
		CONCAT(C.id_caja,' - ',C.c_caja) AS Caja,
		CONCAT(P.id_proyecto,' - ',P.c_proyecto) AS Proyecto,
		C2.c_concepto AS Concepto,
		N.importe,
		N.importedol,
		N.fecha_registro,
		N.fecha_sistema
		FROM NUEVA_TRANSACCION N
		LEFT JOIN CAJA C ON N.id_cajabanco = C.id_caja
		LEFT JOIN CONCEPTOS C2 ON N.id_concepto = C2.id_concepto
		LEFT JOIN PROYECTOS P ON N.id_centro_asignacion = P.id_proyecto
		WHERE N.eliminada IS NULL
		AND (N.fecha_registro >= P_fecha_ini OR P_fecha_ini IS NULL)
		AND (N.fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)
		ORDER BY id_transaccion DESC;
		-- limit 100;
	WHEN '2' THEN
		SELECT 
		N.id_transaccion,
		N.Tipo_transaccion,
		N.rendicion,
		N.fecha_registro,
		N.fecha_sistema,
		N.documento,
		N.tipo_cambio,
		N.importe,
		N.importedol,
		N.id_cajabanco,
		N.nro_boucher,
		N.id_subcentroasignacion,
		N.id_centro_asignacion,
		N.id_subconsepto,
		N.id_concepto,
		N.observacion,
		N.id_empresa,
		N.id_cuecontable,
		N.id_cuecontablecr,
		N.fecha_doc,
		N.glosa,
		N.nro_doc,
		N.id_cuecontablecc,
		N.id_cuecontablecccr,
		N.fecha_doccc,
		N.glosacc
		FROM NUEVA_TRANSACCION N
		WHERE N.id_transaccion = P_id_transaccion;
	END CASE;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS NUEVA_TRANSACCION_INSERT$$

CREATE PROCEDURE `NUEVA_TRANSACCION_INSERT`( 
 IN P_Tipo_transaccion			VARCHAR(15),
 IN P_rendicion				CHAR(9),
 IN P_fecha_registro			DATETIME,
 IN P_fecha_sistema			DATETIME,
 IN P_documento				VARCHAR(20),
 IN P_tipo_cambio			DECIMAL(10,2),
 IN P_importe				DECIMAL(10,2),
 IN P_importedol			DECIMAL(10,2),
 IN P_id_cajabanco			VARCHAR(10),
 IN P_nro_boucher			VARCHAR(25),
 IN P_id_subcentroasignacion            VARCHAR(10),
 IN P_id_centro_asignacion		VARCHAR(10),
 IN P_id_subconsepto			VARCHAR(10),
 IN P_id_concepto			VARCHAR(10),
 IN P_observacion			VARCHAR(50),
 IN P_id_empresa			VARCHAR(10),
 IN P_glosa				VARCHAR(25),
 IN P_id_cuecontable			VARCHAR(10),
 IN P_id_cuecontablecr			VARCHAR(10),
 IN P_fecha_doc				DATETIME,
 IN P_nro_doc				VARCHAR(25),
 IN P_id_cuecontablecc			VARCHAR(10),
 IN P_id_cuecontablecccr		VARCHAR(10),
 IN P_fecha_doccc			DATETIME,
 IN P_glosacc				VARCHAR(25)
)
BEGIN 
	INSERT INTO NUEVA_TRANSACCION(
	Tipo_transaccion,
	rendicion,
	fecha_registro,
	fecha_sistema,
	documento,
	tipo_cambio,
	importe,
	importedol,
	id_cajabanco,
	nro_boucher,
	id_subcentroasignacion,
	id_centro_asignacion,
	id_subconsepto,
	id_concepto,
	observacion,
	id_empresa,
	id_cuecontable,
	id_cuecontablecr,
	fecha_doc,
	glosa,
	nro_doc,
	id_cuecontablecc,
	id_cuecontablecccr,
	fecha_doccc,
	glosacc)
	VALUES(
	P_Tipo_transaccion,
	P_rendicion,
	P_fecha_registro,
	P_fecha_sistema,
	P_documento,
	P_tipo_cambio,
	P_importe,
	P_importedol,
	P_id_cajabanco,
	P_nro_boucher,
	P_id_subcentroasignacion,
	P_id_centro_asignacion,
	P_id_subconsepto,
	P_id_concepto,
	P_observacion,
	P_id_empresa,
	P_id_cuecontable,
	P_id_cuecontablecr,
	P_fecha_doc,
	P_glosa,
	P_nro_doc,
	P_id_cuecontablecc,
	P_id_cuecontablecccr,
	P_fecha_doccc,
	P_glosacc);
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS NUEVA_TRANSACCION_UPDATE$$

CREATE PROCEDURE `NUEVA_TRANSACCION_UPDATE`(
 IN P_id_transaccion			INT(11),
 IN P_Tipo_transaccion			VARCHAR(15),
 IN P_rendicion				CHAR(9),
 IN P_fecha_registro			DATETIME,
 -- IN P_fecha_sistema			DATETIME,
 IN P_documento				VARCHAR(20),
 IN P_tipo_cambio			DECIMAL(10,2),
 IN P_importe				DECIMAL(10,2),
 IN P_importedol			DECIMAL(10,2),
 IN P_id_cajabanco			VARCHAR(10),
 IN P_nro_boucher			VARCHAR(25),
 IN P_id_subcentroasignacion            VARCHAR(10),
 IN P_id_centro_asignacion		VARCHAR(10),
 IN P_id_subconsepto			VARCHAR(10),
 IN P_id_concepto			VARCHAR(10),
 IN P_observacion			VARCHAR(50),
 IN P_id_empresa			VARCHAR(10),
 IN P_glosa				VARCHAR(25),
 IN P_id_cuecontable			VARCHAR(10),
 IN P_id_cuecontablecr			VARCHAR(10),
 IN P_fecha_doc				DATETIME,
 IN P_nro_doc				VARCHAR(25),
 IN P_id_cuecontablecc			VARCHAR(10),
 IN P_id_cuecontablecccr		VARCHAR(10),
 IN P_fecha_doccc			DATETIME,
 IN P_glosacc				VARCHAR(25)
)
BEGIN
 
 UPDATE NUEVA_TRANSACCION
	 SET
	 Tipo_transaccion = P_Tipo_transaccion,
	 rendicion = P_rendicion,
	 fecha_registro	= P_fecha_registro,
	 -- fecha_sistema
	 documento = P_documento,
	 importe = P_importe,
	 importedol	= P_importedol,
	 id_cajabanco = P_id_cajabanco,
	 nro_boucher = P_nro_boucher,
	 id_subcentroasignacion = P_id_subcentroasignacion,
	 id_centro_asignacion = P_id_centro_asignacion,
	 id_subconsepto = P_id_subconsepto,
	 id_concepto = P_id_concepto,
	 observacion = P_observacion,
	 id_empresa = P_id_empresa,
	 id_cuecontable = P_id_cuecontable,
	 id_cuecontablecr = P_id_cuecontablecr,
	 fecha_doc = P_fecha_doc,
	 glosa = P_glosa,
	 nro_doc = P_nro_doc,
	 id_cuecontablecc = P_id_cuecontablecc,
	 id_cuecontablecccr = P_id_cuecontablecccr,
	 fecha_doccc = P_fecha_doccc,
	 glosacc = P_glosacc
	 WHERE id_transaccion = P_id_transaccion;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_DELETE$$

CREATE PROCEDURE `PROYECTO_DELETE`(
 IN P_id_proyecto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT  COUNT(S.id_sproyecto)
	 FROM SUB_PROYECTOS S
	 WHERE S.id_proyecto = P_id_proyecto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Sub Centro de Asignación.';
 ELSEIF ((SELECT  COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N
	 WHERE N.id_centro_asignacion = P_id_proyecto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
         DELETE FROM CTAS_DC
	 WHERE c_codigo = (SELECT cta_control FROM PROYECTOS P WHERE P.id_proyecto = P_id_proyecto)
               OR c_codigo = (SELECT cta_ingreso FROM PROYECTOS P WHERE P.id_proyecto = P_id_proyecto);
	 DELETE FROM PROYECTOS
         WHERE id_proyecto = P_id_proyecto;
         DELETE FROM CONCEPTOXPROYECTO
         WHERE id_proyecto = P_id_proyecto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_GET$$

CREATE PROCEDURE `PROYECTO_GET`(
 IN P_ProyectoId CHAR(10),
 IN P_opcion	   INT
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 P.id_proyecto,
		 P.c_codigo,
		 P.c_proyecto,
		 P.cta_control,
		 C1.c_cuenta AS desc_control,
		 P.cta_ingreso,
		 C2.c_cuenta AS desc_ingreso,
		 C1.id_empresa,
		 P.c_estado AS Estado
		 FROM PROYECTOS P
		 LEFT JOIN CTAS_DC C1 ON C1.c_codigo = P.cta_control
		 LEFT JOIN CTAS_DC C2 ON C2.c_codigo = P.cta_ingreso
		 WHERE id_proyecto = P_ProyectoId
		 OR P_ProyectoId IS NULL;
	WHEN '2' THEN
		 SELECT
		 P.id_proyecto,
		 concat(P.c_codigo,' - ',P.c_proyecto) AS Proyecto
		 FROM PROYECTOS P
		 WHERE c_estado = 'ACT'
		 ORDER BY P.c_codigo;
	END CASE;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_INSERT$$

CREATE PROCEDURE `PROYECTO_INSERT`( 
 IN P_c_codigo 			VARCHAR(10),
 IN P_c_proyecto 		VARCHAR(30),
 IN P_cta_control		VARCHAR(4),
 IN P_desc_control		VARCHAR(60),
 IN P_cta_ingreso		VARCHAR(4),
 IN P_desc_ingreso		VARCHAR(60),
 IN P_id_empresa 		VARCHAR(10),
 IN P_Estado 			CHAR(3),
 IN P_Fecha 			DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_proyecto)
	 FROM PROYECTOS
	 WHERE c_codigo = P_c_codigo
	 OR c_proyecto = P_c_proyecto)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esta descripción o código.';
 ELSE
	IF((SELECT COUNT(c_codigo)
		FROM CTAS_DC
		WHERE c_codigo = P_cta_control)>0)
	THEN SET P_ERROR = 'Ya existe un registro con este número de cuenta.';
	ELSE
		 INSERT INTO PROYECTOS(
		 c_codigo,
		 c_proyecto,
		 cta_control,
		 cta_ingreso,
		 c_estado,
		 f_creacion)
		 VALUES(
		 P_c_codigo,
		 P_c_proyecto,
		 P_cta_control,
		 P_cta_ingreso,
		 P_Estado,
		 P_Fecha );
		 INSERT INTO CTAS_DC(
		 c_cuenta,
		 c_codigo,
		 id_empresa,
		 c_estado,
		 f_creacion)
		 VALUES(
		 P_desc_control,
		 P_cta_control,
		 P_id_empresa,
		 P_Estado,
		 P_Fecha );
		 INSERT INTO CTAS_DC(
		 c_cuenta,
		 c_codigo,
		 id_empresa,
		 c_estado,
		 f_creacion)
		 VALUES(
		 P_desc_ingreso,
		 P_cta_ingreso,
		 P_id_empresa,
		 P_Estado,
		 P_Fecha );
	END IF;
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS PROYECTO_UPDATE$$

CREATE PROCEDURE `PROYECTO_UPDATE`(
 IN P_id_proyecto 	INT(11),
 IN P_c_proyecto 	VARCHAR(30),
 IN P_desc_control	VARCHAR(60),
 IN P_desc_ingreso	VARCHAR(60),
 IN P_c_estado		CHAR(3)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SET P_ERROR = 'Ya existe';
 IF ((SELECT COUNT(*)
	 FROM PROYECTOS P
	 WHERE (c_proyecto = P_c_proyecto)
	 AND P.id_proyecto != P_id_proyecto)>0)
	 THEN SET P_ERROR = 'Ya existe un registro con esa descripción.';
 ELSE
	 UPDATE CTAS_DC
		 SET
		 c_cuenta   = P_desc_control,
		 c_estado 	= P_c_estado
	 WHERE c_codigo = (SELECT cta_control FROM PROYECTOS P WHERE P.id_proyecto = P_id_proyecto);
	 UPDATE CTAS_DC
		 SET
		 c_cuenta   = P_desc_ingreso,
		 c_estado 	= P_c_estado
	 WHERE c_codigo = (SELECT cta_ingreso FROM PROYECTOS P WHERE P.id_proyecto = P_id_proyecto);
	 UPDATE PROYECTOS
		 SET
		 c_proyecto  = P_c_proyecto,
		 c_estado 	 = P_c_estado
	 WHERE id_proyecto = P_id_proyecto;
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS REP_CAJA_EMP$$

CREATE PROCEDURE `REP_CAJA_EMP`(
P_c_codigo 					INT(11),
-- P_id_subcentroasignacion                VARCHAR(10),
P_id_concepto				INT(11),
P_c_caja					INT(11),
-- P_id_subconsepto 			VARCHAR(10),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN
        SELECT
			P.c_proyecto PROYECTO, 
			SP.c_sproyecto SPROYECTO,	
			TR.id_transaccion, TR.fecha_registro FECHA, 
			-- CD1.c_cuenta AS CUENTA_DB, CD2.c_cuenta AS CUENTA_CR, 
			E.c_nomraz AS EMPRESA, 
			-- CC1.c_cuenta AS EMPRESA_DB, CC2.c_cuenta AS EMPRESA_CR,
			concat(CJ.c_codigo,' - ',CJ.c_caja) CAJA,
			CP.c_concepto, SC.c_sconcepto, TR.observacion,
			TR.importe AS IMPORTE, TR.tipo_cambio TIPO_CAMBIO, ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
	FROM    NUEVA_TRANSACCION TR
			LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
			LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
			LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
			LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 
			LEFT JOIN CTAS_CONTABLES CC1 ON  TR.id_cuecontable=CC1.c_codigo
			LEFT JOIN CTAS_CONTABLES CC2 ON  TR.id_cuecontablecr=CC2.c_codigo
			LEFT JOIN CTAS_DC CD1 ON  TR.id_cuecontablecc=CD1.c_codigo
			LEFT JOIN CTAS_DC CD2 ON  TR.id_cuecontablecccr=CD2.c_codigo
			LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
			LEFT JOIN  CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			-- AND (TR.id_subcentroasignacion = P_id_subcentroasignacion OR P_id_subcentroasignacion IS NULL)
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND (TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL) -- X CONCEPTO
			-- AND (TR.id_subconsepto = P_id_subconsepto  OR  P_id_subconsepto IS NULL)		
			AND (TR.fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND (TR.fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)

	ORDER BY EMPRESA;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS REP_CAJA_EMP_SUM$$

CREATE PROCEDURE `REP_CAJA_EMP_SUM`(
P_c_codigo 					INT(11),
-- P_id_subcentroasignacion    VARCHAR(10),
P_id_concepto				INT(11),
-- P_id_subconsepto 			VARCHAR(10),
P_c_caja		 			INT(11),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN
	SELECT 	'Saldo Inicial' AS TITULO, IFNULL(SUM(TR.importe),0) AS IMPORTE_SUM, IFNULL(SUM(ROUND((TR.importe/TR.tipo_cambio),2)),0) AS IMPORTE_DOL_SUM
	FROM    NUEVA_TRANSACCION TR
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			-- AND (TR.id_subcentroasignacion = P_id_subcentroasignacion OR P_id_subcentroasignacion IS NULL)
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			-- AND (TR.id_subconsepto = P_id_subconsepto  OR  P_id_subconsepto IS NULL)		
			AND (TR.fecha_sistema < P_fecha_inicio)
	UNION
	SELECT 	'Movimientos' AS TITULO, IFNULL(SUM(TR.importe),0) AS IMPORTE_SUM, IFNULL(SUM(ROUND((TR.importe/TR.tipo_cambio),2)),0) AS IMPORTE_DOL_SUM
	FROM    NUEVA_TRANSACCION TR
	WHERE  
			TR.eliminada IS NULL
			AND (TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )
			-- AND (TR.id_subcentroasignacion = P_id_subcentroasignacion OR P_id_subcentroasignacion IS NULL)
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			-- AND (TR.id_subconsepto = P_id_subconsepto  OR  P_id_subconsepto IS NULL)
			AND (TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )
			AND (TR.fecha_sistema >= P_fecha_inicio OR P_fecha_inicio IS NULL)
			AND (TR.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL);
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS REP_MOV$$

CREATE PROCEDURE `REP_MOV`(
P_c_codigo 				INT(11),
P_id_subcentroasignacion                VARCHAR(10),
P_id_concepto				INT(11),
P_id_subconsepto 			VARCHAR(10),
P_c_caja		 		INT(11),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN
    SELECT 	CONCAT( P.c_proyecto, ' - ' , SP.c_sproyecto) TITULO,	
			TR.id_transaccion, TR.fecha_sistema, 
			CD1.c_cuenta AS CUENTA_DB, CD2.c_cuenta AS CUENTA_CR, E.c_nomraz AS EMPRESA, 
			CC1.c_cuenta AS EMPRESA_DB, CC2.c_cuenta AS EMPRESA_CR,
			CJ.c_caja, CP.c_concepto, SC.c_sconcepto, TR.rendicion, TR.observacion,
			TR.importe AS IMPORTE, ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
	FROM    NUEVA_TRANSACCION TR
			LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
			LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
			LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
			LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 
			LEFT JOIN CTAS_CONTABLES CC1 ON  TR.id_cuecontable=CC1.c_codigo
			LEFT JOIN CTAS_CONTABLES CC2 ON  TR.id_cuecontablecr=CC2.c_codigo
			LEFT JOIN CTAS_DC CD1 ON  TR.id_cuecontablecc=CD1.c_codigo
			LEFT JOIN CTAS_DC CD2 ON  TR.id_cuecontablecccr=CD2.c_codigo
			LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
			LEFT JOIN CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
	WHERE  
			TR.eliminada IS NULL 
			AND (TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND (TR.id_subcentroasignacion = P_id_subcentroasignacion OR P_id_subcentroasignacion IS NULL)
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND (TR.id_subconsepto = P_id_subconsepto  OR  P_id_subconsepto IS NULL)		
                        AND (TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND (TR.fecha_sistema >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND (TR.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL)

	ORDER BY TITULO;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS REP_MOV_REG$$

CREATE PROCEDURE `REP_MOV_REG`(
P_c_codigo 				INT(11),
-- P_id_subcentroasignacion             VARCHAR(10),
P_id_concepto				INT(11),
-- P_id_subconsepto 			VARCHAR(10),
P_c_caja		 		INT(11),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN
    SELECT 	CONCAT( P.c_proyecto, ' - ' , SP.c_sproyecto) AS TITULO,	
			TR.id_transaccion, TR.fecha_registro AS FECHA, 
			E.c_nomraz AS EMPRESA, 
			CJ.c_caja, CP.c_concepto, SC.c_sconcepto, TR.observacion,
			TR.importe AS IMPORTE, TR.tipo_cambio TIPO_CAMBIO, ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
	FROM    NUEVA_TRANSACCION TR
			LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
			LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
			LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
			LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 
			LEFT JOIN CTAS_CONTABLES CC1 ON  TR.id_cuecontable=CC1.c_codigo
			LEFT JOIN CTAS_CONTABLES CC2 ON  TR.id_cuecontablecr=CC2.c_codigo
			LEFT JOIN CTAS_DC CD1 ON  TR.id_cuecontablecc=CD1.c_codigo
			LEFT JOIN CTAS_DC CD2 ON  TR.id_cuecontablecccr=CD2.c_codigo
			LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
			LEFT JOIN  CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND	(TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND (TR.fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND (TR.fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)

	ORDER BY TITULO;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_DELETE$$

CREATE PROCEDURE `SUBCONCEPTO_DELETE`(
 IN P_id_sconcepto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, SUB_CONCEPTOS S
	 WHERE N.id_subconsepto = S.c_scodigo
	 AND S.id_sconcepto = P_id_sconcepto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM SUB_CONCEPTOS
 WHERE id_sconcepto = P_id_sconcepto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_GET$$

CREATE PROCEDURE `SUBCONCEPTO_GET`(
 IN P_SConceptoId CHAR(10),
 IN P_opcion	  INT
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 C.id_sconcepto,
		 C.c_scodigo,
		 C.c_sconcepto,
		 C.id_concepto,
		 C.c_estado AS Estado,
		 P.c_concepto
		 FROM SUB_CONCEPTOS C
		 LEFT JOIN CONCEPTOS P ON C.id_concepto=P.id_concepto
		 WHERE id_sconcepto = P_SconceptoId
		 OR P_sconceptoId IS NULL;
	WHEN '2' THEN
		 SELECT
		 C.c_scodigo,
		 CONCAT(C.c_scodigo,' - ',C.c_sconcepto) AS SConcepto,
		 C.id_concepto
		 FROM SUB_CONCEPTOS C
		 WHERE c_estado = 'ACT'
		 ORDER BY C.c_scodigo;
	END CASE;
END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_INSERT$$

CREATE PROCEDURE `SUBCONCEPTO_INSERT`( 
-- IN P_ContratistaId INT(11),
-- IN P_TipoEmpresaId VARCHAR(10),
 IN P_c_sconcepto 		VARCHAR(30),
 IN P_c_scodigo 		VARCHAR(10),
 IN P_c_id_concepto		VARCHAR(10),
 IN P_Estado 			CHAR(3)
 -- IN P_Usuario 			VARCHAR(64),
 -- IN P_Fecha 			DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_sconcepto)
	 FROM SUB_CONCEPTOS
	 WHERE c_scodigo = P_c_scodigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con ese código.';
 ELSE
	 INSERT INTO SUB_CONCEPTOS(
	 -- ContratistaId,
	 -- TipoEmpresaId,
	 c_sconcepto,
	 c_scodigo,
	 id_concepto,
	 c_estado)
	 -- UsuarioCreacion,
	 -- f_creacion
	 VALUES(
	 -- P_ContratistaId,
	 -- P_TipoEmpresaId,
	 P_c_sconcepto,
	 P_c_scodigo,
	 P_c_id_concepto,
	 P_Estado);
	 -- P_Usuario,
	 -- P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_UPDATE$$

CREATE PROCEDURE `SUBCONCEPTO_UPDATE`(
 IN P_id_sconcepto 	INT(11),
 IN P_c_sconcepto 	VARCHAR(30),
-- IN P_c_scodigo VARCHAR(10),
 IN P_c_id_concepto     VARCHAR(10),	
 IN P_Estado 		CHAR(3)
-- IN P_UsuarioModificacion VARCHAR(64),
-- IN P_FechaModificacion DATETIME
)
BEGIN
 UPDATE SUB_CONCEPTOS
	 SET
	 c_sconcepto = P_c_sconcepto,
	 -- c_scodigo = P_c_scodigo,
	 id_concepto = P_c_id_concepto,
	 c_estado = P_Estado 
	 -- UsuarioModificacion = P_UsuarioModificacion,
	 -- FechaModificacion = P_FechaModificacion
 WHERE id_sconcepto = P_id_sconcepto;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS SUBCONCEPTO_X_CONCEPTO_GET$$

CREATE PROCEDURE `SUBCONCEPTO_X_CONCEPTO_GET`(
	IN P_id_concepto INT(11)
)
BEGIN
	SELECT  SC.c_scodigo AS Codigo,
			CONCAT(SC.c_scodigo,' - ',SC.c_sconcepto) AS Descripcion
	FROM 
		SUB_CONCEPTOS SC
	WHERE
		SC.id_concepto = P_id_concepto AND -- X ID DE PROYECTO
		SC.c_estado = 'ACT'
	ORDER  BY 
		Descripcion ASC;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_DELETE$$

CREATE PROCEDURE `SUBPROYECTO_DELETE`(
 IN P_id_sproyecto INT(11)
)
BEGIN
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(N.id_transaccion)
	 FROM NUEVA_TRANSACCION N, SUB_PROYECTOS S
	 where N.id_subcentroasignacion = S.c_scodigo 
	 and S.id_sproyecto = P_id_sproyecto)>0)
	 THEN SET P_ERROR = 'El registro esta siendo usado en un Movimiento.';
 ELSE
 DELETE FROM SUB_PROYECTOS
 WHERE id_sproyecto = P_id_sproyecto;
 END IF;
 SELECT P_ERROR AS Mensaje;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_GET$$

CREATE PROCEDURE `SUBPROYECTO_GET`(
 IN P_id_sproyecto CHAR(10),
 IN P_opcion	   INT
)
BEGIN
	CASE P_opcion
	WHEN '1' THEN
		 SELECT
		 S.id_sproyecto,
		 S.c_scodigo,
		 S.c_sproyecto,
		 S.id_proyecto,
		 CONCAT(P.c_codigo,' - ',P.c_proyecto) AS Proyecto,
		 S.c_estado AS Estado
		 FROM SUB_PROYECTOS S
		 LEFT JOIN PROYECTOS P ON S.id_proyecto = P.id_proyecto
		 WHERE id_sproyecto = P_id_sproyecto
		 OR P_id_sproyecto IS NULL;
	WHEN '2' THEN
		 SELECT
		 S.c_scodigo,
		 CONCAT(S.c_scodigo,' - ',S.c_sproyecto) AS SProyecto,
		 S.id_proyecto
		 FROM SUB_PROYECTOS S
		 WHERE c_estado = 'ACT'
		 ORDER BY S.c_scodigo;
	END CASE;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_INSERT$$

CREATE PROCEDURE `SUBPROYECTO_INSERT`( 
-- IN P_ContratistaId INT(11),
-- IN P_TipoEmpresaId VARCHAR(10),
 IN P_c_sproyecto 	VARCHAR(30),
 IN P_c_scodigo	 	VARCHAR(10),
 IN P_id_proyecto	INT,
-- IN P_c_cuenta		VARCHAR(5),
-- IN P_u_cuenta		CHAR(1),
 IN P_Estado 		CHAR(3),
 IN P_Fecha 		DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_sproyecto)
	 FROM SUB_PROYECTOS
	 WHERE c_scodigo = P_c_scodigo)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE
	 INSERT INTO SUB_PROYECTOS(
	 c_sproyecto,
	 c_scodigo,
	 id_proyecto,
	 -- c_cuenta,
	 -- u_cuenta,
	 c_estado,
	 f_creacion)
	 VALUES(
	 P_c_sproyecto,
	 P_c_scodigo,
	 P_id_proyecto,
	 -- P_c_cuenta,
	 -- P_u_cuenta,
	 P_Estado,
	 P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_UPDATE$$

CREATE PROCEDURE `SUBPROYECTO_UPDATE`(
 IN P_id_sproyecto 	INT(11),
 IN P_c_sproyecto 	VARCHAR(30),
-- IN P_c_scodigo	 	VARCHAR(10),
 IN P_id_proyecto	INT,
-- IN P_c_cuenta		VARCHAR(5),
-- IN P_u_cuenta		CHAR(1),
 IN P_c_estado		CHAR(3)
)
BEGIN
 
 UPDATE SUB_PROYECTOS
	 SET
	 c_sproyecto = P_c_sproyecto,
	 -- c_scodigo = P_c_scodigo,
	 id_proyecto = P_id_proyecto,
	 -- c_cuenta = P_c_cuenta,
	 -- u_cuenta = P_u_cuenta,
	 c_estado = P_c_estado
	 -- UsuarioModificacion = P_UsuarioModificacion,
	 -- FechaModificacion = P_FechaModificacion
 WHERE id_sproyecto = P_id_sproyecto;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS SUBPROYECTO_X_PROYECTO_GET$$

CREATE PROCEDURE `SUBPROYECTO_X_PROYECTO_GET`(
	IN P_id_proyecto VARCHAR(10)
)
BEGIN
	SELECT  P.c_scodigo AS Codigo,
		CONCAT(P.c_scodigo,' - ',
		P.c_sproyecto) AS Descripcion
	FROM 
		SUB_PROYECTOS P
	WHERE
		P.id_proyecto = P_id_proyecto AND -- X ID DE PROYECTO
		P.c_estado = 'ACT'
	ORDER  BY 
		Descripcion ASC;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS TIPO_GET$$

CREATE PROCEDURE `TIPO_GET`(
 IN P_id_tipo_padre CHAR(10)
)
BEGIN
 SELECT
 T.id_tipo,
 T.c_tipo
 FROM TIPO T
 WHERE id_tipo_padre = P_id_tipo_padre;
 -- OR P_EmpresaId IS NULL;
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS TIPO_GET2$$
CREATE PROCEDURE `TIPO_GET2`(
 IN T_id_tipo CHAR(10),
 IN T_opcion CHAR(1)
)
BEGIN
		CASE T_opcion
		WHEN '1' THEN
		 SELECT
		 T.id_tipo,
		 T.id_tipo_padre,
		 T.c_tipo,
		 T.estado
		 FROM TIPO T 
		 WHERE id_tipo = T_id_tipo
		 OR T_id_tipo IS NULL
		ORDER BY T.id_tipo_padre;
		 WHEN '2' THEN
		 SELECT
		 T.id_tipo,
		 concat(T.id_tipo, ' - ', T.c_tipo) AS Padre
		 FROM TIPO T
		 WHERE id_tipo_padre IS NULL OR id_tipo_padre=''
		 ORDER BY T.c_tipo;
		END CASE;
 END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS TIPO_INSERT$$

CREATE PROCEDURE `TIPO_INSERT`( 
-- IN P_ContratistaId INT(11),
-- IN P_TipoEmpresaId VARCHAR(10),
 IN T_id_tipo       VARCHAR(60),
 IN T_c_tipo        VARCHAR(45),
 IN T_id_tipo_padre VARCHAR(10),
 IN T_Estado        VARCHAR(10)
 -- IN P_Usuario 			VARCHAR(64),
 -- IN P_Fecha 			DATETIME 
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_tipo)
	 FROM tipo
	 WHERE id_tipo = T_id_tipo
	 OR c_tipo = T_c_tipo)>0)
 THEN SET P_ERROR = 'Ya existe un tipo con esa descripción o código.';
 ELSE
	 INSERT INTO TIPO(
	 -- ContratistaId,
	 -- TipoEmpresaId,
	 id_tipo,
	 id_tipo_padre,
	 c_tipo,
	 Estado
	 )
	 -- UsuarioCreacion,
	-- f_creacion
		
	 VALUES(
	 -- P_ContratistaId,
	 -- P_TipoEmpresaId,
	 T_id_tipo,
	 T_id_tipo_padre ,
	 T_c_tipo,
	 T_Estado);
	 -- P_Usuario,
	-- P_Fecha );
 END IF;
 SELECT P_ERROR AS Mensaje; 
END$$


DELIMITER $$

DROP PROCEDURE IF EXISTS TIPO_UPDATE$$

CREATE PROCEDURE `TIPO_UPDATE`(
	IN T_id_tipo    VARCHAR(11),
 -- IN P_c_codigo 	VARCHAR(10),
 -- IN T_id_tipo_padre 	VARCHAR(60),
	IN T_c_tipo 	VARCHAR(20),
	IN T_Estado     VARCHAR(10)
)
BEGIN 
 DECLARE P_ERROR VARCHAR(100);
 DECLARE CONTINUE HANDLER FOR SQLSTATE '23000'
 SELECT P_ERROR;
 IF ((SELECT COUNT(id_tipo)
	 FROM TIPO
	 WHERE c_tipo = T_c_tipo	
	 AND Estado = T_Estado)>0)
 THEN SET P_ERROR = 'Ya existe un registro con esa descripción o código.';
 ELSE

	 UPDATE TIPO
	 SET
		-- 	id_tipo = T_id_tipo,
		-- 	id_tipo_padre = T_id_tipo_padre,
			c_tipo= T_c_tipo,
			Estado= T_Estado
	 WHERE  id_tipo = T_id_tipo;

 END IF;
 SELECT P_ERROR AS Mensaje; 

END$$

-- NUEVOS PROCEDURES PARA VENTANA SALDOS EN LOS REPORTES REP_MOV Y REP_MOV_REG AÑADIDOS EL 06-08-13

DELIMITER $$

DROP PROCEDURE IF EXISTS REP_MOV_SUM$$

CREATE PROCEDURE `REP_MOV_SUM`(
P_c_codigo 				INT(11),
P_id_subcentroasignacion                VARCHAR(10),
P_id_concepto				INT(11),
P_id_subconsepto 			VARCHAR(10),
P_c_caja		 		INT(11),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN
	SELECT 	'Saldo Inicial' AS TITULO, IFNULL(SUM(TR.importe),0) AS IMPORTE_SUM, IFNULL(SUM(TR.importedol),0) AS IMPORTE_DOL_SUM
	FROM    NUEVA_TRANSACCION TR
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND (TR.id_subcentroasignacion = P_id_subcentroasignacion OR P_id_subcentroasignacion IS NULL)
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND (TR.id_subconsepto = P_id_subconsepto  OR  P_id_subconsepto IS NULL)	
			AND	(TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )					
			AND (TR.fecha_sistema < P_fecha_inicio)
	UNION
	SELECT 	'Movimientos' AS TITULO, IFNULL(SUM(TR.importe),0) AS IMPORTE_SUM, IFNULL(SUM(TR.importedol),0) AS IMPORTE_DOL_SUM
	FROM    NUEVA_TRANSACCION TR
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND (TR.id_subcentroasignacion = P_id_subcentroasignacion OR P_id_subcentroasignacion IS NULL)
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND (TR.id_subconsepto = P_id_subconsepto  OR  P_id_subconsepto IS NULL)		
			AND	(TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND (TR.fecha_sistema >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND (TR.fecha_sistema <= P_fecha_fin OR P_fecha_fin IS NULL);
END$$

DELIMITER $$

        DROP PROCEDURE IF EXISTS REP_CON_INI$$

	CREATE PROCEDURE `REP_CON_INI`(
	P_id_proyecto			INT(11),
	P_id_concepto			INT(11),
	P_c_caja		 		INT(11),
	P_fecha_inicio 				DATETIME,
	P_fecha_fin 				DATETIME
	)
	BEGIN			
			SELECT 	
				TR.id_transaccion AS Codigo,
				TR.fecha_registro AS Fecha,
				CJ.c_caja 		  AS Caja,
				P.c_codigo		  AS C_Asignacion,
				SP.c_scodigo	  AS SC_Asignacion,
				CP.c_concepto     AS Concepto,
				SC.c_sconcepto	  AS Subconcepto,
				E.c_codigo 		  AS Empresa,
				TR.nro_boucher	  AS Cheque,
				TR.importe AS IMPORTE, 
				TR.tipo_cambio AS TIPO_CAMBIO, 
				ROUND((TR.importe/TR.tipo_cambio),2) AS IMPORTE_DOL
		FROM    NUEVA_TRANSACCION TR
				LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
				LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
				LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
				LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 

				LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
				LEFT JOIN  CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
		WHERE  
				TR.eliminada IS NULL 
				AND (TR.id_centro_asignacion = P_id_proyecto OR P_id_proyecto IS NULL )				
				AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) 
				AND (TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
				AND (TR.fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
				AND (TR.fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL)

		ORDER BY Codigo;


	END$$

DELIMITER $$

DROP PROCEDURE IF EXISTS REP_MOV_REG_SUM$$

CREATE PROCEDURE `REP_MOV_REG_SUM`(
P_c_codigo 				INT(11),
P_id_concepto				INT(11),
P_c_caja		 		INT(11),
P_fecha_inicio 				DATETIME,
P_fecha_fin 				DATETIME
)
BEGIN
	SELECT 	'Saldo Inicial' AS TITULO, IFNULL(SUM(TR.importe),0) AS IMPORTE_SUM, IFNULL(SUM(ROUND((TR.importe/TR.tipo_cambio),2)),0) AS IMPORTE_DOL_SUM
	FROM    NUEVA_TRANSACCION TR
			LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
			LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
			LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
			LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 
			LEFT JOIN CTAS_CONTABLES CC1 ON  TR.id_cuecontable=CC1.c_codigo
			LEFT JOIN CTAS_CONTABLES CC2 ON  TR.id_cuecontablecr=CC2.c_codigo
			LEFT JOIN CTAS_DC CD1 ON  TR.id_cuecontablecc=CD1.c_codigo
			LEFT JOIN CTAS_DC CD2 ON  TR.id_cuecontablecccr=CD2.c_codigo
			LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
			LEFT JOIN  CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND (TR.fecha_registro < P_fecha_inicio)
	UNION
	SELECT 	'Movimientos' AS TITULO, SUM(TR.importe) AS IMPORTE_SUM, SUM(ROUND((TR.importe/TR.tipo_cambio),2)) AS IMPORTE_DOL_SUM
	FROM    NUEVA_TRANSACCION TR
			LEFT JOIN PROYECTOS P ON TR.id_centro_asignacion=P.id_proyecto
			LEFT JOIN SUB_PROYECTOS SP ON TR.id_subcentroasignacion=SP.c_scodigo 
			LEFT JOIN CONCEPTOS CP ON TR.id_concepto=CP.id_concepto
			LEFT JOIN SUB_CONCEPTOS SC ON TR.id_subconsepto=SC.c_scodigo 
			LEFT JOIN CTAS_CONTABLES CC1 ON  TR.id_cuecontable=CC1.c_codigo
			LEFT JOIN CTAS_CONTABLES CC2 ON  TR.id_cuecontablecr=CC2.c_codigo
			LEFT JOIN CTAS_DC CD1 ON  TR.id_cuecontablecc=CD1.c_codigo
			LEFT JOIN CTAS_DC CD2 ON  TR.id_cuecontablecccr=CD2.c_codigo
			LEFT JOIN EMPRESAS E ON TR.id_empresa = E.c_codigo
			LEFT JOIN  CAJA CJ ON TR.id_cajabanco = CJ.c_codigo
	WHERE  
			TR.eliminada IS NULL 
			AND	(TR.id_centro_asignacion = P_c_codigo OR P_c_codigo IS NULL )				
			AND (TR.id_concepto = P_id_concepto OR P_id_concepto IS NULL) -- X CONCEPTO
			AND	(TR.id_cajabanco = P_c_caja OR P_c_caja IS NULL )				
			AND (TR.fecha_registro >= P_fecha_inicio OR P_fecha_inicio IS NULL)	
			AND (TR.fecha_registro <= P_fecha_fin OR P_fecha_fin IS NULL);
END$$

