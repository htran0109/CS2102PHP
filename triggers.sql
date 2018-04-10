/* TRIGGER: number of seats available in a post must be at most the total seats in the car minus one; WORKING */
CREATE OR REPLACE FUNCTION check_seats()
RETURNS TRIGGER AS $$
BEGIN
IF (NEW.seats_available > (
	SELECT total_seats
	FROM car C
	WHERE NEW.license_plate = C.license_plate) - 1
)
THEN RAISE EXCEPTION 'The number of seats available must be at most the total number of seats in you car minus one (for the driver).';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER check_seats
BEFORE INSERT OR UPDATE ON post
FOR EACH ROW
EXECUTE PROCEDURE check_seats();

/* TRIGGER: check that car owners are 18; WORKING */
CREATE OR REPLACE FUNCTION check_age()
RETURNS TRIGGER AS $$
BEGIN 
IF (DATE_PART('year', now()::DATE) - DATE_PART('year', (
	SELECT birthday
	FROM profile P
	WHERE P.username = NEW.username
	)::DATE) < 18
)
THEN RAISE EXCEPTION 'You cannot own a car of you are younger than 18 years old.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER check_age
BEFORE INSERT OR UPDATE ON car
FOR EACH ROW
EXECUTE PROCEDURE check_age();

/* when start times are on the same day and start time is within 4 hours of another ride; need a different trigger for update*/
CREATE OR REPLACE FUNCTION insert_post()
RETURNS TRIGGER AS $$
BEGIN 
IF EXISTS( 
	SELECT 1
	FROM post P
	WHERE P.owner = NEW.owner
	AND P.depart_date = NEW.depart_date
	AND ABS(DATE_PART('hour', NEW.depart_time - P.depart_time)) < 4
) 
THEN RAISE EXCEPTION 'Listed rides must have start times at least 4 hours apart.';
END IF;
IF ((DATE_PART('day', now() - NEW.depart_date) < 0)
	OR (DATE_PART('day', now() - NEW.depart_date) = 0)
	AND (DATE_PART('hour', now() - NEW.depart_time) < 0))
THEN RAISE EXCEPTION 'You cannot create a post whose start time has already passed.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE OR REPLACE FUNCTION update_post()
RETURNS TRIGGER AS $$
BEGIN 
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
IF ((DATE_PART('day', now() - OLD.depart_date) < 0)
	OR (DATE_PART('day', now() - OLD.depart_date) = 0)
	AND (DATE_PART('hour', now() - OLD.depart_time) < 0))
THEN RAISE EXCEPTION 'You cannot edit a post whose start time has already passed.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE TRIGGER insert_post
BEFORE INSERT ON post
FOR EACH ROW
EXECUTE PROCEDURE insert_post();

CREATE TRIGGER update_post
BEFORE UPDATE ON post
FOR EACH ROW
EXECUTE PROCEDURE update_post();

/* when start times are on the same day and start time is within 4 hours of another ride; need a different trigger for update use EXCEPT OLD*/
/* ADD TRIGGER: rating can only be made 4 hours after the trip has started; combined with bid above */
CREATE OR REPLACE FUNCTION insert_bid()
RETURNS TRIGGER AS $$
BEGIN 
IF EXISTS ( 
	SELECT 1
	FROM bid B
	WHERE B.owner = NEW.owner
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
IF ((DATE_PART('day', now() - NEW.depart_date) < 0)
	OR (DATE_PART('day', now() - NEW.depart_date) = 0)
	AND (DATE_PART('hour', now() - NEW.depart_time) < 0))
THEN RAISE EXCEPTION 'You cannot create a bid whose start time has already passed.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;

CREATE OR REPLACE FUNCTION update_bid()
RETURNS TRIGGER AS $$
BEGIN 
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
IF ((DATE_PART('day', now() - OLD.depart_date) < 0)
	OR (DATE_PART('day', now() - OLD.depart_date) = 0)
	AND (DATE_PART('hour', now() - OLD.depart_time) < 0))
THEN RAISE EXCEPTION 'You cannot edit a bid whose start time has already passed.';
END IF;
RETURN NEW;
END; $$ LANGUAGE PLPGSQL;


CREATE TRIGGER insert_bid
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE insert_bid();

CREATE TRIGGER update_bid
BEFORE UPDATE ON bid
FOR EACH ROW
EXECUTE PROCEDURE update_bid();

/*cannot bid or post rides if the time has already passed*/


