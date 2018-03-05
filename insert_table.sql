INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES ('adam', 1000, 'adam@email.com', 'password1');

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (bob, 1001, bob@email.com, password2);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (carl, 1002, carl@email.com, password3);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (doug, 1003, doug@email.com, password4);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (ellie, 1004, ellie@email.com, password5);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (francis, 1005, francis@email.com, password6);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (george, 1006, george@email.com, password7);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (harry, 1007, harry@email.com, password8);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (irene, 1008, irene@email.com, password9);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (joe, 1009, joe@email.com, password10);

INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password)
VALUES (kate, 1010, kate@email.com, password11);

//-------------------------------------------------------------

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car1, 4);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car2, 4);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car3, 4);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car4, 4);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car5, 4);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car6, 5);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car7, 5);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car8, 5);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car9, 5);

INSERT INTO Cars(LicenseNumber, AvailableSeats)
VALUES (car10, 5);

//----------------------------------------------------------

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (adam, car1);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (bob, car2);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (carl, car3);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (doug, car4);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (ellie, car5);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (francis, car6);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (george, car7);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (harry, car8);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (irene, car9);

INSERT INTO Owns(UserName, LicenseNumber)
VALUES (joe, car10);

//-------------------------------------------------------------

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES (adam, 1, start1, end1, 2030-01-01, 01:00:00);

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES (bob, 1, start2, end2, 2030-01-01, 02:00:00);

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES (carl, 1, start3, end3, 2030-01-01, 03:00:00);

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES (doug, 1, start4, end4, 2030-01-01, 04:00:00);

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES (ellie, 2, start5, end5, 2030-01-01, 05:00:00);

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES (francis, 2, start6, end6, 2030-01-01, 06:00:00);

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES george, 2, start7, end7, 2030-01-01, 07:00:00);

INSERT INTO User_Post(Owner, Seats, Start, End, depDate, depTime)
VALUES harry, 2, start8, end8, 2030-01-01, 08:00:00);

INSERT INTO User_Post(Owner, Seats, Start, End, depDate, depTime)
VALUES irene, 2, start9, end9, 2030-01-01, 09:00:00);

INSERT INTO User_Post(Owner, Seats, Start, Dest, depDate, depTime)
VALUES joe, 2, start10, end10, 2030-01-01, 10:00:00);

//--------------------------------------------------------------

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, adam, start1, end1, 2030-01-01, 01:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, bob, start2, end2, 2030-01-01, 02:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, carl, start3, end3, 2030-01-01, 03:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, doug, start4, end4, 2030-01-01, 04:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, ellie, start5, end5, 2030-01-01, 05:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, francis, start6, end6, 2030-01-01, 06:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, george, start7, end7, 2030-01-01, 07:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, harry, start8, end8, 2030-01-01, 08:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, irene, start9, end9, 2030-01-01, 09:00:00);

INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers)
VALUES(kate, joe, start10, end10, 2030-01-01, 10:00:00);