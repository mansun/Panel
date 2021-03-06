DELETE FROM  ARTICULO;
DELETE FROM  LOG;
DELETE FROM  USUARIO_ROL;
DELETE FROM  ROL;
DELETE FROM  USUARIO;
DELETE FROM  TIPO_ROL;

ALTER TABLE LOG DROP FOREIGN KEY FK_LOG_USU;
ALTER TABLE ARTICULO DROP FOREIGN KEY FK_ARTICULO_USU;
ALTER TABLE USUARIO_ROL DROP FOREIGN KEY FK_USUARIO_ROL_ROL;
ALTER TABLE USUARIO_ROL DROP FOREIGN KEY FK_USUARIO_ROL_USU;
ALTER TABLE ROL DROP FOREIGN KEY FK_ROL_TIPO_ROL;

TRUNCATE TABLE ARTICULO;
TRUNCATE TABLE LOG;
TRUNCATE TABLE USUARIO_ROL;
TRUNCATE TABLE ROL;
TRUNCATE TABLE USUARIO;
TRUNCATE TABLE TIPO_ROL;

ALTER TABLE rol MODIFY rolID int(11) AUTO_INCREMENT;
ALTER TABLE usuario MODIFY usuID int(11) AUTO_INCREMENT;
ALTER TABLE log MODIFY logID int(11) AUTO_INCREMENT;
ALTER TABLE articulo MODIFY artID int(11) AUTO_INCREMENT;

--ALTER TABLE LOG ADD CONSTRAINT `FK_LOG_USU` FOREIGN KEY (`usuID`) REFERENCES `usuario` (`usuID`) ON DELETE SET NULL ON UPDATE SET NULL;
ALTER TABLE ARTICULO ADD CONSTRAINT `FK_ARTICULO_USU` FOREIGN KEY (`usuID`) REFERENCES `usuario` (`usuID`);
ALTER TABLE USUARIO_ROL ADD CONSTRAINT `FK_USUARIO_ROL_ROL` FOREIGN KEY (`rolID`) REFERENCES `rol` (`rolID`);
ALTER TABLE USUARIO_ROL ADD CONSTRAINT `FK_USUARIO_ROL_USU` FOREIGN KEY (`usuID`) REFERENCES `usuario` (`usuID`);
ALTER TABLE ROL ADD CONSTRAINT `FK_ROL_TIPO_ROL` FOREIGN KEY (`tipoRolID`) REFERENCES `tipo_rol` (`tipoRolID`);


INSERT INTO tipo_rol(tipoRolID, tipoRolNom) VALUES (1,'admin');
INSERT INTO tipo_rol(tipoRolID, tipoRolNom) VALUES (2,'lector');
INSERT INTO tipo_rol(tipoRolID, tipoRolNom) VALUES (3,'escritor');

INSERT INTO rol(rolNom, tipoRolID) VALUES ('admin', 1);
INSERT INTO rol(rolNom, tipoRolID) VALUES ('lector',2);
INSERT INTO rol(rolNom, tipoRolID) VALUES ('escritor',3);

