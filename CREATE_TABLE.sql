CREATE TABLE Users (
	UserName varchar(20),
	MobileNumber varchar(20),
	EmailAddress varchar(40),
	Password varchar(20),
	PRIMARY KEY (UserName)
);

CREATE TABLE Cars (
	LicenseNumber varchar(10),
	Seats int
);

CREATE TABLE Owns (
	UserName varchar(20),
	LicenseNumber varchar(10),
	PRIMARY KEY (UserName, LicenseNumber),
	FOREIGN KEY (UserName) REFERENCES Users(UserName),
	FOREIGN KEY (LicenseNumber) REFERENCES Cars(LicenseNumber)
);

CREATE TABLE User_Post (
	Owner varchar(20),
	Start varchar(128),
	End varchar(128),
	depDate DATE,
	depTime TIME
	PRIMARY KEY (Owner, Start, End, depDate, depTime),
	FOREIGN KEY (Owner) REFERENCES Users(UserName)
);

CREATE TABLE Bid (
	Bidder varchar(20),
	Owner varchar(20),
	Start varchar(128),
	End varchar(128),
	Date DATE,
	Time TIME,
	Customers int,
	PRIMARY KEY (Bidder, Owner, Start, End, Date, Time),
	FOREIGN KEY (Bidder) REFERENCES Users(UserName),
	FOREIGN KEY (Owner, Start, End, Date Time),
	REFERENCES User_Post(Owner, Start, End, Date, Time)
);