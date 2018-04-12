/*
DROP TABLE profile CASCADE;
DROP TABLE car CASCADE;
DROP TABLE post CASCADE;
DROP TABLE bid CASCADE;
*/

CREATE TABLE profile (
	username varchar(20),
	first_name varchar(20) NOT NULL,
	last_name varchar(20) NOT NULL,
	mobile_number varchar(20) NOT NULL,
	email varchar(40) NOT NULL,
	password varchar(20) NOT NULL,
	birthday DATE NOT NULL,
  	admin boolean DEFAULT FALSE,
	PRIMARY KEY (username)
);

CREATE TABLE car (
	license_plate varchar(10),
	total_seats int NOT NULL,
	color varchar(20) NOT NULL,
	model varchar(20) NOT NULL,
	make varchar(20) NOT NULL,
	username varchar(20) NOT NULL,
	FOREIGN KEY (username) REFERENCES profile(username),
	PRIMARY KEY (license_plate)
);

CREATE TABLE post (
	license_plate varchar(20) NOT NULL,
	owner varchar(20),
	seats_available int NOT NULL,
	origin varchar(128),
	destination varchar(128),
	depart_date DATE,
	depart_time TIME,
	PRIMARY KEY (owner, origin, destination, depart_date, depart_time),
	FOREIGN KEY (license_plate) REFERENCES car(license_plate),
	FOREIGN KEY (owner) REFERENCES profile(username)
);

CREATE TABLE bid (
	bidder varchar(20),
	owner varchar(20) CHECK (owner <> bidder),
	origin varchar(128),
	destination varchar(128),
	depart_date DATE,
	depart_time TIME,
	seats_desired int NOT NULL,
	driver_rating int CHECK ((0 <= driver_rating AND driver_rating <= 5) OR driver_rating IS NULL),
	passenger_rating int CHECK ((0 <= passenger_rating AND passenger_rating <= 5) OR passenger_rating IS NULL),
	accepted boolean DEFAULT FALSE,
	PRIMARY KEY (bidder, owner, origin, destination, depart_date, depart_time),
	FOREIGN KEY (bidder) REFERENCES profile(username),
	FOREIGN KEY (owner, origin, destination, depart_date, depart_time)
	REFERENCES post(owner, origin, destination, depart_date, depart_time)
);