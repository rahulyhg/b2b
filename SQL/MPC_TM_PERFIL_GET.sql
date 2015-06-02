delimiter $$

DROP PROCEDURE IF EXISTS MPC_TM_PERFIL_GET$$

CREATE PROCEDURE `MPC_TM_PERFIL_GET`( IN P_PerfilId CHAR(10), IN P_Opcion CHAR(1) )
BEGIN CASE P_Opcion WHEN '1' THEN SELECT PerfilId, NombrePerfil, DescripcionPerfil, PerfilPadreId, Nivel, Estado, UsuarioCreacion, FechaCreacion, UsuarioModificacion, FechaModificacion FROM MPC_TM_PERFIL P WHERE P.PerfilId = P_PerfilId; WHEN '2' THEN SELECT PerfilId AS ID, NombrePerfil AS Descripcion FROM MPC_TM_PERFIL; WHEN '3' THEN SELECT PerfilId AS ID, NombrePerfil AS Descripcion FROM MPC_TM_PERFIL WHERE Estado = 'COD0000002'; WHEN '4' THEN SELECT PerfilId AS ID, NombrePerfil AS Descripcion FROM MPC_TM_PERFIL WHERE PerfilId != P_PerfilId; END CASE; END$$
