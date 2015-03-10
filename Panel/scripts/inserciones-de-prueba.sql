INSERT INTO `panel`.`usuario` (`usuNom`, `usuAlias`, `usuPw`, `usuSit`) VALUES ( 'Administrador', 'admin', 'abc123', '1');
INSERT INTO `panel`.`usuario` (`usuNom`, `usuAlias`, `usuPw`, `usuSit`) VALUES ( 'Enrique Prado', 'Mansun', 'abc123', '1');
INSERT INTO `panel`.`usuario` (`usuNom`, `usuAlias`, `usuPw`, `usuSit`) VALUES ( 'Amancio Ortega', 'amancio', 'abc123', '1');
INSERT INTO `panel`.`usuario` (`usuNom`, `usuAlias`, `usuPw`, `usuSit`) VALUES ( 'Bill Gates', 'bill', 'abc123', '1');
INSERT INTO `panel`.`usuario` (`usuNom`, `usuAlias`, `usuPw`, `usuSit`) VALUES ( 'Steve Jobs', 'steve', 'abc123', '1');

INSERT INTO `panel`.`usuario_rol` (`usuID`, `rolID`) VALUES ('1', '1');
INSERT INTO `panel`.`usuario_rol` (`usuID`, `rolID`) VALUES ('2', '1');
INSERT INTO `panel`.`usuario_rol` (`usuID`, `rolID`) VALUES ('3', '3');
INSERT INTO `panel`.`usuario_rol` (`usuID`, `rolID`) VALUES ('4', '2');
INSERT INTO `panel`.`usuario_rol` (`usuID`, `rolID`) VALUES ('4', '2');

INSERT INTO `panel`.`articulo` (`artDatCre`, `artTit`, `artTxt`, `artImx`, `artLayout`, `artClas`, `usuID`) VALUES ('2015-03-05', 'Alonso: Estaré al 100% en Malasia', 'Fernando Alonso lanzó por las redes sociales un juego que no es sino una forma de responder a las teorías sobre lo primero que él dijo tras despertarse de su accidente', 'img/imagen1.jpg', '2', '0', '1');
INSERT INTO `panel`.`articulo` (`artDatCre`, `artTit`, `artTxt`, `artImx`, `artLayout`, `artClas`, `usuID`) VALUES ('2015-03-04', 'Illarramendi, Lucas o Khedira, la duda de Carlo en San Mamés', 'Carlo Ancelotti no desveló quiénes compondrán el centro del campo del Real Madrid en San Mamés.', 'img/imagen2.jpg', '3', '1', '2');
INSERT INTO `panel`.`articulo` (`artDatCre`, `artTit`, `artTxt`, `artImx`, `artLayout`, `artClas`, `usuID`) VALUES ('2015-03-04', 'Patxi Izco, un detenido más por los presuntos amaños', 'Continúan las investigaciones sobre el presunto amaño del Espanyol-Osasuna y siguen las detenciones, según Diario de Navarra. Patxi Izco, Juan Pascual y Diego Maquírriain han sido detenidos tras prestar declaración.', 'img/imagen3.jpg', '1', '2', '3');
INSERT INTO `panel`.`articulo` (`artDatCre`, `artTit`, `artTxt`, `artImx`, `artLayout`, `artClas`, `usuID`) VALUES ('2015-03-04', 'El baile a Isco y Jesé con Hierro como protagonista', 'Marcelo, jugador del Real Madrid, se enfadó durante los rondos en el entrenamiento del conjunto blanco antes de viajar a Bilbao para jugar contra el Athletic.', 'img/imagen4.jpg', '1', '0', '4');

INSERT INTO `panel`.`log` (`logDatEve`, `usuID`, `logAction`, `logObserv`) VALUES ('2015-03-12 00:00:00', '1', 'Login', 'Sin Observaciones');
INSERT INTO `panel`.`log` (`logDatEve`, `usuID`, `logAction`, `logObserv`) VALUES ('2015-03-11 00:00:00', '2', 'Logout', 'Sin Observaciones');
INSERT INTO `panel`.`log` (`logDatEve`, `usuID`, `logAction`, `logObserv`) VALUES ('2015-03-10 00:00:00', '3', 'Consultar Artículo', 'Sin Observaciones');
INSERT INTO `panel`.`log` (`logDatEve`, `usuID`, `logAction`, `logObserv`) VALUES ('2015-03-09 00:00:00', '4', 'Consultar Artículo', 'Sin Observaciones');