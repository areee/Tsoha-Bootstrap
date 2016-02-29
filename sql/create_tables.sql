CREATE TABLE Chef(
	id SERIAL PRIMARY KEY,
	username varchar(20) UNIQUE NOT NULL,
	password varchar(20) NOT NULL,
	is_admin boolean DEFAULT false,
	added DATE NOT NULL,
	updated DATE NOT NULL
);

CREATE TABLE Food(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	volume double precision NOT NULL,
	unit varchar(20) NOT NULL,
	description varchar(100),
	chef_id integer REFERENCES Chef(id) ON DELETE CASCADE,
	added DATE NOT NULL,
	updated DATE NOT NULL
);

CREATE TABLE Recipe(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	volume double precision[],
	unit text[],
	instructions varchar(1000) NOT NULL,
	source varchar(50) NOT NULL,
	portions INTEGER NOT NULL,
	description varchar(100),
	chef_id integer REFERENCES Chef(id) ON DELETE CASCADE,
	added DATE NOT NULL,
	updated DATE NOT NULL
);

CREATE TABLE RecipeFood(
	id SERIAL PRIMARY KEY,
	recipe_id INTEGER REFERENCES Recipe(id) ON DELETE CASCADE,
	food_id INTEGER REFERENCES Food(id) ON DELETE CASCADE,
	added DATE NOT NULL,
	updated DATE NOT NULL
);
