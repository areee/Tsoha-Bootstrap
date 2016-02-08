-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Chef(
	id SERIAL PRIMARY KEY,
	username varchar(20) NOT NULL,
	password varchar(20) NOT NULL,
	is_admin boolean default false ,
	added DATE,
	updated DATE
);

CREATE TABLE Food(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	volume double precision NOT NULL,
	unit varchar(20) NOT NULL,
	added DATE,
	updated DATE
);

CREATE TABLE Recipe(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	volume double precision[],
	unit text[],
	instructions varchar(1000) NOT NULL,
	source varchar(50) NOT NULL,
	portions INTEGER NOT NULL,
	added DATE,
	updated DATE
);

CREATE TABLE ChefFood(
id SERIAL PRIMARY KEY,
chef_id INTEGER REFERENCES Chef(id),
food_id INTEGER REFERENCES Food(id)
);

CREATE TABLE ChefRecipe(
id SERIAL PRIMARY KEY,
chef_id INTEGER REFERENCES Chef(id),
recipe_id INTEGER REFERENCES Recipe(id)
);

CREATE TABLE RecipeFood(
id SERIAL PRIMARY KEY,
recipe_id INTEGER REFERENCES Recipe(id),
food_id INTEGER REFERENCES Food(id)
);
