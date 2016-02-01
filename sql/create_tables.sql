-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja(
	id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL,
	salasana varchar(50) NOT NULL,
	yllapito-oikeus boolean default false,
	lisays-pvm DATE
);

CREATE TABLE Raaka-aine(
	id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL,
	maara INTEGER NOT NULL,
	yksikko NOT NULL,
	lisays-pvm DATE,
	muokkaus-pvm DATE
);

CREATE TABLE Resepti(
	id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL,
	ohje varchar(1000) NOT NULL,
	lahde varchar(50) NOT NULL,
	lisays-pvm DATE,
	muokkaus-pvm DATE
);

CREATE TABLE Kayttaja-Raaka-aine(
kayttaja_id INTEGER REFERENCES Kayttaja(id)
raaka-aine_id INTEGER REFERENCES Raaka-aine(id)

);

CREATE TABLE Raaka-aine-Resepti(

);