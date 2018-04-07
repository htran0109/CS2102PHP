/*
DROP TABLE Profile CASCADE;
DROP TABLE OwnsCar CASCADE;
DROP TABLE UserPost CASCADE;
DROP TABLE UserBid CASCADE;
*/

CREATE TABLE Profile (
	username varchar(20),
	first_name varchar(20),
	last_name varchar(20),
	mobile_number varchar(20),
	email varchar(40),
	password varchar(20),
  	admin boolean DEFAULT FALSE ,
	PRIMARY KEY (username)
);

CREATE TABLE OwnsCar (
	license_plate varchar(10),
	total_seats int,
	color varchar(20),
	model varchar(20),
	make varchar(20),
	username varchar(20),
	FOREIGN KEY (username) REFERENCES Profile(username),
	PRIMARY KEY (license_plate)
);

CREATE TABLE UserPost (
	owner varchar(20),
	seats_available int,
	origin varchar(128),
	destination varchar(128),
	depart_date DATE,
	depart_time TIME,
	PRIMARY KEY (owner, origin, destination, depart_date, depart_time),
	FOREIGN KEY (owner) REFERENCES Profile(username)
);

CREATE TABLE UserBid (
	bidder varchar(20),
	owner varchar(20),
	origin varchar(128),
	destination varchar(128),
	depart_date DATE,
	depart_time TIME,
	seats_desired int,
	driver_rating int CHECK (0 <= driver_rating AND driver_rating <= 5),
	passenger_rating int CHECK (0 <= passenger_rating AND passenger_rating <= 5),
	accepted boolean DEFAULT FALSE,
	PRIMARY KEY (bidder, owner, origin, destination, depart_date, depart_time),
	FOREIGN KEY (bidder) REFERENCES Profile(username),
	FOREIGN KEY (owner, origin, destination, depart_date, depart_time)
	REFERENCES UserPost(owner, origin, destination, depart_date, depart_time)
);