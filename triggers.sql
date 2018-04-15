/*
DROP TRIGGER check_age ON car;
DROP TRIGGER insert_post ON post;
DROP TRIGGER update_post ON post;
DROP TRIGGER insert_bid ON bid;
DROP TRIGGER update_bid ON bid;
*/


/* TRIGGER: INSERT OR UPDATE ON car; WORKING
	- car owners must be at least 18 years old */
CREATE OR REPLACE FUNCTION check_age()
RETURNS TRIGGER AS $$
BEGIN 
IF (DATE_PART('year', now()::DATE) - DATE_PART('year', (
	SELECT birthday
	FROM profile P
	WHERE P.username = NEW.username
	)::DATE) <= 18
	AND DATE_PART('month', now()::DATE) - DATE_PART('month', (
	SELECT birthday
	FROM profile P
	WHERE P.username = NEW.username
	)::DATE) < 0
)
THEN RAISE EXCEPTION 'You cannot own a car of you are younger than 18 years old.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER check_age
BEFORE INSERT OR UPDATE ON car
FOR EACH ROW
EXECUTE PROCEDURE check_age();

/* TRIGGER: INSERT ON post
	- posts must have start times at least 4 hours apart
	- posts cannot be created if their start time has already passed 
	- seats_available can be at most total_seats - 1 */
CREATE OR REPLACE FUNCTION insert_post()
RETURNS TRIGGER AS $$
BEGIN 
IF ((DATE_PART('day', now() - NEW.depart_date) > 0)
	OR (DATE_PART('day', now() - NEW.depart_date) = 0)
	AND (DATE_PART('hour', now() - NEW.depart_time) > 0))
THEN RAISE EXCEPTION 'You cannot create a post whose start time has already passed.';
END IF;
IF EXISTS( 
	SELECT 1
	FROM post P
	WHERE P.owner = NEW.owner
	AND P.depart_date = NEW.depart_date
	AND ABS(DATE_PART('hour', NEW.depart_time - P.depart_time)) < 4
) 
THEN RAISE EXCEPTION 'Listed rides must have start times at least 4 hours apart.';
END IF;
IF (NEW.seats_available > (
	SELECT total_seats
	FROM car C
	WHERE NEW.license_plate = C.license_plate) - 1
)
THEN RAISE EXCEPTION 'The number of seats available must be at most the total number of seats in you car minus one (for the driver).';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER insert_post
BEFORE INSERT ON post
FOR EACH ROW
EXECUTE PROCEDURE insert_post();

/*TRIGGER: UPDATE ON post
	- posts must have start times at least 4 hours apart
	- posts cannot be updated if their start time has already passed
	- seats_available can be at most total_seats - 1 */
CREATE OR REPLACE FUNCTION update_post()
RETURNS TRIGGER AS $$
BEGIN 
IF ((DATE_PART('day', now() - OLD.depart_date) > 0)
	OR (DATE_PART('day', now() - OLD.depart_date) = 0)
	AND (DATE_PART('hour', now() - OLD.depart_time) > 0))
THEN RAISE EXCEPTION 'You cannot edit a post whose start time has already passed.';
END IF;
IF EXISTS( 
	SELECT *
	FROM post P
	WHERE P.owner = NEW.owner
	AND P.depart_date = NEW.depart_date
	AND ABS(DATE_PART('hour', NEW.depart_time - P.depart_time)) < 4
	EXCEPT 
	SELECT *
	FROM post P
	WHERE P.owner = OLD.owner
	AND P.depart_time = OLD.depart_time
	AND P.depart_date = OLD.depart_date
) 
THEN RAISE EXCEPTION 'Listed rides must have start times at least 4 hours apart.';
END IF;
IF (NEW.seats_available > (
	SELECT total_seats
	FROM car C
	WHERE NEW.license_plate = C.license_plate) - 1
)
THEN RAISE EXCEPTION 'The number of seats available must be at most the total number of seats in you car minus one (for the driver).';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER update_post
BEFORE UPDATE ON post
FOR EACH ROW
EXECUTE PROCEDURE update_post();

/*TRIGGER: INSERT ON bid
	- bids must have start times at least 4 hours apart
	- bids cannot be created if their start time has already passed 
	- bids cannot have reviews until 4 hours after the start time*/
CREATE OR REPLACE FUNCTION insert_bid()
RETURNS TRIGGER AS $$
BEGIN 
IF ((DATE_PART('day', now() - NEW.depart_date) > 0)
	OR (DATE_PART('day', now() - NEW.depart_date) = 0)
	AND (DATE_PART('hour', now() - NEW.depart_time) > 0))
THEN RAISE EXCEPTION 'You cannot create a bid whose start time has already passed.';
END IF;
IF EXISTS ( 
	SELECT 1
	FROM bid B
	WHERE B.bidder = NEW.bidder
	AND B.depart_date = NEW.depart_date
	AND ABS(DATE_PART('hour', NEW.depart_time - B.depart_time)) < 4
)
THEN RAISE EXCEPTION 'Bids cannot have start times within 4 hours of each other.';
END IF;
IF (NEW.passenger_rating IS NOT NULL
	AND NEW.driver_rating IS NOT NULL 
	AND (DATE_PART('day', now() - NEW.depart_date) < 0)
	OR (DATE_PART('day', now() - NEW.depart_date) = 0)
	AND (DATE_PART('hour', now() - NEW.depart_time) < 4))
THEN RAISE EXCEPTION 'You cannot leave a review until 4 hours after the start of a ride.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER insert_bid
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE insert_bid();

/*TRIGGER: UPDATE ON bid
	- bids must have start times at least 4 hours apart
	- bids cannot be edited if their start time has already passed 
	- bids cannot have reviews until 4 hours after the start time*/
CREATE OR REPLACE FUNCTION update_bid()
RETURNS TRIGGER AS $$
BEGIN 
IF (NEW.bidder IS NOT NULL
	OR NEW.owner IS NOT NULL
	OR NEW.origin IS NOT NULL
	OR NEW.destination IS NOT NULL
	OR NEW.depart_date IS NOT NULL
	OR NEW.depart_time IS NOT NULL
	OR NEW.seats_desired IS NOT NULL
	AND (DATE_PART('day', now() - OLD.depart_date) > 0)
	OR (DATE_PART('day', now() - OLD.depart_date) = 0)
	AND (DATE_PART('hour', now() - OLD.depart_time) > 0))
THEN RAISE EXCEPTION 'You cannot edit a bid whose start time has already passed (except to give a rating).';
END IF;
IF EXISTS ( 
	SELECT 1
	FROM bid B
	WHERE B.owner = NEW.owner
	AND B.depart_date = NEW.depart_date
	AND ABS(DATE_PART('hour', NEW.depart_time - B.depart_time)) < 4
	EXCEPT 
	SELECT *
	FROM bid B
	WHERE B.owner = OLD.owner
	AND B.depart_time = OLD.depart_time
	AND B.depart_date = OLD.depart_date
)
THEN RAISE EXCEPTION 'Bids cannot have start times within 4 hours of each other.';
END IF;
IF (NEW.passenger_rating IS NOT NULL
	AND NEW.driver_rating IS NOT NULL 
	AND (DATE_PART('day', now() - OLD.depart_date) < 0)
	OR (DATE_PART('day', now() - OLD.depart_date) = 0)
	AND (DATE_PART('hour', now() - OLD.depart_time) < 4))
THEN RAISE EXCEPTION 'You cannot leave a review until 4 hours after the start of a ride.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER update_bid
BEFORE UPDATE ON bid
FOR EACH ROW
EXECUTE PROCEDURE update_bid();


