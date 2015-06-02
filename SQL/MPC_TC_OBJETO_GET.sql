delimiter $$

DROP PROCEDURE IF EXISTS MPC_TC_OBJETO_GET$$

CREATE PROCEDURE `MPC_TC_OBJETO_GET`( IN P_PadreId CHAR(32), IN P_PadreId2 CHAR(32), IN P_Opcion CHAR(1) )
BEGIN CASE P_Opcion WHEN '1' THEN SELECT ObjetoId, CONCAT(ObjetoId, ' - ' ,Descripcion) AS Descripcion FROM MPC_TC_OBJETO O WHERE Estado = 'COD0000002' and (ObjetoPadreId = P_PadreId or ObjetoPadreId = P_PadreId2); WHEN '2' THEN SELECT ObjetoId, CONCAT(ObjetoId, ' - ' ,Descripcion) AS Descripcion FROM MPC_TC_OBJETO; WHEN '3' THEN SELECT * FROM MPC_TC_OBJETO O WHERE O.ObjetoId = P_PadreId; WHEN '4' THEN SELECT ObjetoId, CONCAT(ObjetoId, ' - ' ,Descripcion) AS Descripcion FROM MPC_TC_OBJETO WHERE ObjetoId != P_PadreId; END CASE; END$$
