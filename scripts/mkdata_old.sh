#!/bin/bash

number=11111111
nume=1
for name in "george" "bill" "adam" "bob" "carl" "doug" "ellie" "francis" "harry" "irene" "joe" "kate"
do
        printf "INSERT INTO profile(username, first_name, last_name, mobile_number, email, password, birthday)\n"
        printf "VALUES ('${name}', '${name}', '${name}son', '${number}', '${name}@gmail.com', 'foobar' ,'1990-01-0${nume}');\n\n"
        number=$(((number+89450934)%89999999 + 10000000))
done


for name in "george" "bill" "adam" "bob" "carl" "doug" "ellie" "francis" "harry" "irene" "joe" "kate"
do
		printf "INSERT INTO car(license_plate, total_seats, color, model, make, username)\n"
		printf "VALUES ('car${nume}', '${nume}', 'red', 'toyota', 'corolla', '${name}');\n\n"
		nume=$((nume+1))
done



num=1
nume=1
for name in "george" "bill" "adam" "bob" "carl" "doug" "ellie" "francis" "harry" "irene" "joe" "kate"
do
        printf "INSERT INTO post(license_plate, owner, seats_available, origin, destination, depart_date, depart_time)\n"
        printf "VALUES ('car${nume}', '${name}', '${num}', 'start${num}', 'end${num}', '2030-01-0${num}', '0${num}:00:00');\n\n"
        num=$((num%5+1))
        nume=$((nume+1))
done


num=1
for name in "george" "bill" "adam" "bob" "carl" "doug" "ellie" "francis" "harry" "irene" "joe" "kate"
do
        printf "INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired)\n"
        printf "VALUES ('kate', '${name}', 'start${num}', 'end${num}', '2030-01-0${num}', '0${num}:00:00', '${num}');\n\n"
        num=$((num%5+1))
done