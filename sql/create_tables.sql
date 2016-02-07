-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Chef(
	id SERIAL PRIMARY KEY,
	username varchar(20) NOT NULL,
	password varchar(20) NOT NULL,
	is_admin boolean default false NOT NULL,
	added DATE
	updated DATE
);

CREATE TABLE Food(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	volume INTEGER NOT NULL,
	unit varchar(20) NOT NULL,
	added DATE,
	updated DATE
);

CREATE TABLE Recipe(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	food_id INTEGER REFERENCES Food(id),
	volume INTEGER,
	unit varchar(20),
	instructions varchar(1000) NOT NULL,
	source varchar(50) NOT NULL,
	portions INTEGER NOT NULL,
	added DATE,
	updated DATE
);

CREATE TABLE ChefFood(
chef.id INTEGER REFERENCES Chef(id),
food.id INTEGER REFERENCES Food(id)

);

CREATE TABLE ChefRecipe(
chef.id INTEGER REFERENCES Chef(id),
recipe.id INTEGER REFERENCES Recipe(id)

);
