INSERT INTO Chef (username,password,is_admin,added,updated) VALUES
('areee','salasana',TRUE,'2015-12-12','2016-02-01');

INSERT INTO Chef (username,password,is_admin,added,updated) VALUES
('maisku','en_muista',FALSE,'2015-12-01','2016-02-01');

INSERT INTO Chef (username,password,is_admin,added,updated) VALUES
('ajajaa','dabadaa',FALSE,NOW(),NOW());

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Peruna',3,'kilogrammaa','suomalainen harjattu',1,'2011-11-11',NOW());

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Rasvaton
maito',10,'litraa','Kotimaista-merkkistä',1,'2012-12-29','2016-01-01');

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Kasvirasvalevite',0.4,'kilogrammaa','sitä
halvinta',2,'2014-05-14','2016-01-31');

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Meijerivoi',0.5,'kilogrammaa','Pirkka',3,'2015-06-19','2016-02-02');

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Hunaja',0.35,'kilogrammaa','suomalainen
laadukas',1,'2015-06-19','2016-02-02');

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Suklaajäätelö',1,'litraa','Pingviini 1L/509g Suklaa kermajäätelö
kotipakkaus',2,NOW(),NOW());

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Kaakaojauhe',0.2,'kilogrammaa','Fazer Cacao 200g kaakaojauhe',2,NOW(),NOW());

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Vaniljasokeri',0.09,'kilogrammaa','Meira Vaniljasokeri 85g
tölkki',2,NOW(),NOW());

INSERT INTO Food (name,volume,unit,description,chef_id,added,updated) VALUES
('Kevytmaito',1,'litraa','Kotimaista 1l kevytmaito',2,NOW(),NOW());

INSERT INTO Recipe (name,instructions,source,portions,description,chef_id,added,updated) VALUES
('Suklaapirtelö',E'Paloittele jäätelö ja siivilöi kaakaojauhe sen päälle.
  Sekoita kaikki ainekset tasaiseksi teho- tai sauvasekoittimella.
  Tarjoa pirtelö korkeista laseista.','Pikku kokki keittiössä -kirja',4,'Helpolla
hyvää!',2,'2016-02-29','2016-02-29');

INSERT INTO Recipe
(name,instructions,source,portions,description,chef_id,added,updated) VALUES
('Paistetut perunat','Paista perunat rasvassa pannulla. Nauti!','oma
pää',1,'Maistuva',1,NOW(),NOW());

INSERT INTO RecipeFood (recipe_id,food_id,volume,unit,added,updated) VALUES
(1,6,0.5,'litraa','2010-12-12','2015-12-29');

INSERT INTO RecipeFood (recipe_id,food_id,volume,unit,added,updated) VALUES
(1,7,0.1,'litraa','2010-12-12','2015-12-29');

INSERT INTO RecipeFood (recipe_id,food_id,volume,unit,added,updated) VALUES
(1,8,0.005,'litraa','2010-12-12','2015-12-29');

INSERT INTO RecipeFood (recipe_id,food_id,volume,unit,added,updated) VALUES
(1,9,0.5,'litraa','2010-12-12','2015-12-29');

INSERT INTO RecipeFood (recipe_id,food_id,volume,unit,added,updated) VALUES
(2,1,0.5,'kilogrammaa',NOW(),NOW());

INSERT INTO RecipeFood (recipe_id,food_id,volume,unit,added,updated) VALUES
(2,3,0.005,'kilogrammaa',NOW(),NOW());
