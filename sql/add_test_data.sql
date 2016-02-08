-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Chef (username,password,is_admin,added,updated) VALUES ('areee','salasana',true,'2015-12-12','2016-02-01');
INSERT INTO Chef (username,password,is_admin,added,updated) VALUES ('asdf','asdf123',false,'2015-12-01','2016-02-01');

INSERT INTO Food (name,volume,unit,added,updated) VALUES ('Kiinteä harjattu peruna',3,'kg','2011-11-11',NOW());
INSERT INTO Food (name,volume,unit,added,updated) VALUES ('Rasvaton maito',10,'l','2012-12-29','2016-01-01');
INSERT INTO Food (name,volume,unit,added,updated) VALUES ('Kasvirasvalevite',0.4,'kg','2014-05-14','2016-01-31');
INSERT INTO Food (name,volume,unit,added,updated) VALUES ('Meijerivoi',0.5,'kg','2015-06-19','2016-02-02');
INSERT INTO Food (name,volume,unit,added,updated) VALUES ('Suomalainen hunaja',0.35,'kg','2015-06-19','2016-02-02');

INSERT INTO Recipe (name,food_id,volume,unit,instructions,source,portions,added,updated) VALUES ('Paistetut perunat','{1,3}','{1,200}','{kg,g}','Kuumenna margariini paistinpannulla.\nLisää pilkotut perunat.\n Paista 10 min miedolla lämmöllä.','omasta päästä',1,'2010-10-10',NOW());
INSERT INTO Recipe (name,food_id,volume,unit,instructions,source,portions,added,updated) VALUES ('Hunajamaito','{2,5}','{0.2,1}','{l,rkl}','Lämmitä maito kuumaksi mikroaaltouunissa.\nLisää hunaja.\nAnna jäähtyä hetki. \nNauti!','vanhemmat',1,'2007-08-10',NOW());

INSERT INTO ChefFood (chef.id,food.id) VALUES (1,1);
INSERT INTO ChefFood (chef.id,food.id) VALUES (1,2);
INSERT INTO ChefFood (chef.id,food.id) VALUES (1,3);
INSERT INTO ChefFood (chef.id,food.id) VALUES (1,5);
INSERT INTO ChefFood (chef.id,food.id) VALUES (2,4);

INSERT INTO ChefRecipe (chef.id,recipe.id) VALUES (1,1);
INSERT INTO ChefRecipe (chef.id,recipe.id) VALUES (1,2);
