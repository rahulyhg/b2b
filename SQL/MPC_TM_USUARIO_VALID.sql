delimiter $$

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