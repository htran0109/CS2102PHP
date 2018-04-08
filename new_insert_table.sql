INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('george', 'george', 'georgeson', '11111111', 'george@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('bill', 'bill', 'billson', '20562046', 'bill@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('adam', 'adam', 'adamson', '30012981', 'adam@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('bob', 'bob', 'bobson', '39463916', 'bob@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('carl', 'carl', 'carlson', '48914851', 'carl@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('doug', 'doug', 'dougson', '58365786', 'doug@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('ellie', 'ellie', 'ellieson', '67816721', 'ellie@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('francis', 'francis', 'francisson', '77267656', 'francis@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('harry', 'harry', 'harryson', '86718591', 'harry@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('irene', 'irene', 'ireneson', '96169526', 'irene@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('joe', 'joe', 'joeson', '15620462', 'joe@gmail.com', 'foobar');

INSERT INTO profile(username, first_name, last_name, mobile_number, email, password)
VALUES ('kate', 'kate', 'kateson', '25071397', 'kate@gmail.com', 'foobar');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car1', '1', 'red', 'toyota', 'corolla', 'george');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car2', '2', 'red', 'toyota', 'corolla', 'bill');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car3', '3', 'red', 'toyota', 'corolla', 'adam');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car4', '4', 'red', 'toyota', 'corolla', 'bob');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car5', '5', 'red', 'toyota', 'corolla', 'carl');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car6', '6', 'red', 'toyota', 'corolla', 'doug');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car7', '7', 'red', 'toyota', 'corolla', 'ellie');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car8', '8', 'red', 'toyota', 'corolla', 'francis');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car9', '9', 'red', 'toyota', 'corolla', 'harry');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car10', '10', 'red', 'toyota', 'corolla', 'irene');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car11', '11', 'red', 'toyota', 'corolla', 'joe');

INSERT INTO car(license_plate, total_seats, color, model, make, username)
VALUES ('car12', '12', 'red', 'toyota', 'corolla', 'kate');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('george', '1', 'start1', 'end1', '2030-01-01', '01:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('bill', '2', 'start2', 'end2', '2030-01-02', '02:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('adam', '3', 'start3', 'end3', '2030-01-03', '03:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('bob', '4', 'start4', 'end4', '2030-01-04', '04:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('carl', '5', 'start5', 'end5', '2030-01-05', '05:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('doug', '1', 'start1', 'end1', '2030-01-01', '01:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('ellie', '2', 'start2', 'end2', '2030-01-02', '02:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('francis', '3', 'start3', 'end3', '2030-01-03', '03:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('harry', '4', 'start4', 'end4', '2030-01-04', '04:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('irene', '5', 'start5', 'end5', '2030-01-05', '05:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('joe', '1', 'start1', 'end1', '2030-01-01', '01:00:00');

INSERT INTO post(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('kate', '2', 'start2', 'end2', '2030-01-02', '02:00:00');

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'george', 'start1', 'end1', '2030-01-01', '01:00:00', '1', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'bill', 'start2', 'end2', '2030-01-02', '02:00:00', '2', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'adam', 'start3', 'end3', '2030-01-03', '03:00:00', '3', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'bob', 'start4', 'end4', '2030-01-04', '04:00:00', '4', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'carl', 'start5', 'end5', '2030-01-05', '05:00:00', '5', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'doug', 'start1', 'end1', '2030-01-01', '01:00:00', '1', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'ellie', 'start2', 'end2', '2030-01-02', '02:00:00', '2', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'francis', 'start3', 'end3', '2030-01-03', '03:00:00', '3', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'harry', 'start4', 'end4', '2030-01-04', '04:00:00', '4', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'irene', 'start5', 'end5', '2030-01-05', '05:00:00', '5', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'joe', 'start1', 'end1', '2030-01-01', '01:00:00', '1', 4, 4);

INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'kate', 'start2', 'end2', '2030-01-02', '02:00:00', '2', 4, 4);

