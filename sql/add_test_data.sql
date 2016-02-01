-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (nimi,salasana,yllapitoOikeus,lisaysPvm) VALUES ('Arttu','salasana',true,'2015-12-12');
INSERT INTO Kayttaja (nimi,salasana,yllapitoOikeus,lisaysPvm) VALUES ('Pekka','asdf123',false,'2016-02-01');

INSERT INTO RaakaAine (nimi,maara,yksikko,lisaysPvm,muokkausPvm) VALUES ('Peruna',1,1,'2011-11-11',NOW());

INSERT INTO Resepti (nimi,ohje,lahde,lisaysPvm,muokkausPvm) VALUES ('Paistetut perunat','Paista perunat rasvassa pannulla.','omasta päästä','2010-10-10','2015-12-31');

INSERT INTO KayttajaRaakaAine (kayttaja_id,raakaaine_id) VALUES (1,1);

INSERT INTO RaakaAineResepti (raakaaine_id,resepti_id) VALUES (1,1);