INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('george', '1111111111', 'george@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('bill', '1111112343', 'bill@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('adam', '1111113575', 'adam@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('bob', '1111114807', 'bob@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('carl', '1111116039', 'carl@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('doug', '1111117271', 'doug@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('ellie', '1111118503', 'ellie@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('francis', '1111119735', 'francis@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('harry', '1111120967', 'harry@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('irene', '1111122199', 'irene@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('joe', '1111123431', 'joe@gmail.com', 'foobar');

INSERT INTO USERS(username, mobile_number, email, password)
VALUES ('kate', '1111124663', 'kate@gmail.com', 'foobar');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car1', '1', 'red', 'toyota', 'corolla', 'george');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car2', '2', 'red', 'toyota', 'corolla', 'bill');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car3', '3', 'red', 'toyota', 'corolla', 'adam');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car4', '4', 'red', 'toyota', 'corolla', 'bob');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car5', '5', 'red', 'toyota', 'corolla', 'carl');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car6', '6', 'red', 'toyota', 'corolla', 'doug');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car7', '7', 'red', 'toyota', 'corolla', 'ellie');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car8', '8', 'red', 'toyota', 'corolla', 'francis');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car9', '9', 'red', 'toyota', 'corolla', 'harry');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car10', '10', 'red', 'toyota', 'corolla', 'irene');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car11', '11', 'red', 'toyota', 'corolla', 'joe');

INSERT INTO OWNSCAR(license_plate, total_seats, color, model, make, username)
VALUES ('car12', '12', 'red', 'toyota', 'corolla', 'kate');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('george', '1', 'start1', 'end1', '2030-01-01', '01:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('bill', '2', 'start2', 'end2', '2030-01-02', '02:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('adam', '3', 'start3', 'end3', '2030-01-03', '03:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('bob', '4', 'start4', 'end4', '2030-01-04', '04:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('carl', '5', 'start5', 'end5', '2030-01-05', '05:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('doug', '1', 'start1', 'end1', '2030-01-01', '01:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('ellie', '2', 'start2', 'end2', '2030-01-02', '02:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('francis', '3', 'start3', 'end3', '2030-01-03', '03:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('harry', '4', 'start4', 'end4', '2030-01-04', '04:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('irene', '5', 'start5', 'end5', '2030-01-05', '05:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('joe', '1', 'start1', 'end1', '2030-01-01', '01:00:00');

INSERT INTO USERPOST(owner, seats_available, origin, destination, depart_date, depart_time)
VALUES ('kate', '2', 'start2', 'end2', '2030-01-02', '02:00:00');

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'george', 'start1', 'end1', '2030-01-01', '01:00:00', '1', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'bill', 'start2', 'end2', '2030-01-02', '02:00:00', '2', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'adam', 'start3', 'end3', '2030-01-03', '03:00:00', '3', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'bob', 'start4', 'end4', '2030-01-04', '04:00:00', '4', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'carl', 'start5', 'end5', '2030-01-05', '05:00:00', '5', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'doug', 'start1', 'end1', '2030-01-01', '01:00:00', '1', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'ellie', 'start2', 'end2', '2030-01-02', '02:00:00', '2', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'francis', 'start3', 'end3', '2030-01-03', '03:00:00', '3', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'harry', 'start4', 'end4', '2030-01-04', '04:00:00', '4', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'irene', 'start5', 'end5', '2030-01-05', '05:00:00', '5', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'joe', 'start1', 'end1', '2030-01-01', '01:00:00', '1', 4, 4);

INSERT INTO USERBID(bidder, owner, origin, destination, depart_date, depart_time, seats_desired, driver_rating, passenger_rating)
VALUES ('kate', 'kate', 'start2', 'end2', '2030-01-02', '02:00:00', '2', 4, 4);

