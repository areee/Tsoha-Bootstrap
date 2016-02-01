-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
	id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL,
	salasana varchar(50) NOT NULL,
	yllapitoOikeus boolean default false,
	lisaysPvm DATE
);

CREATE TABLE RaakaAine(
	id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL,
	maara INTEGER NOT NULL,
	yksikko INTEGER NOT NULL,
	lisaysPvm DATE,
	muokkausPvm DATE
);

CREATE TABLE Resepti(
	id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL,
	ohje varchar(1000) NOT NULL,
	lahde varchar(50) NOT NULL,
	lisaysPvm DATE,
	muokkausPvm DATE
);

CREATE TABLE KayttajaRaakaAine(
kayttaja_id INTEGER REFERENCES Kayttaja(id),
raakaaine_id INTEGER REFERENCES RaakaAine(id)

);

CREATE TABLE RaakaAineResepti(
raakaaine_id INTEGER REFERENCES RaakaAine(id),
resepti_id INTEGER REFERENCES Resepti(id)
);