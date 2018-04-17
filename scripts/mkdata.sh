#!/bin/bash

phone=11111111
num=1
for name in "alpha" "bravo" "charlie" "delta" "echo" "foxtrot" "golf" "hotel" "india" "juliet" "kilo"
do
        for name1 in "alpha" "bravo" "charlie" "delta" "echo" "foxtrot" "golf" "hotel" "india" "juliet" "kilo"
        do
        if [ "${name}" == "${name1}" ]; then
                continue
        fi
        first="${first}INSERT INTO profile(username, first_name, last_name, mobile_number, email, password, birthday)\n"
        first="${first}VALUES ('${name}${name1}', '${name}', '${name1}son', '${phone}', '${name}${name1}@gmail.com', 'foobar' ,'$((1950 + ${phone}%50))-01-$((10+${phone}%19))');\n\n"
        
        
        second="${second}INSERT INTO car(license_plate, total_seats, color, model, make, username)\n"
        second="${second}VALUES ('car${num}', '$((4 + ${phone}%3))', 'red', 'toyota', '${name1}', '${name}${name1}');\n\n"
        
        
        third="${third}INSERT INTO post(license_plate, owner, seats_available, origin, destination, depart_date, depart_time)\n"
        third="${third}VALUES ('car${num}', '${name}${name1}', '$((${phone}%4))', 'start${num}', 'end${num}', '$((2019 + ${phone}%10))-01-$((11+${phone}%18))', '0$((${phone}%10)):00:00');\n\n"

        fourth="${fourth}INSERT INTO bid(bidder, owner, origin, destination, depart_date, depart_time, seats_desired)\n"
        fourth="${fourth}VALUES ('${name1}${name}', '${name}${name1}', 'start${num}', 'end${num}', '$((2019 + ${phone}%10))-01-$((11+${phone}%18))', '0$((${phone}%10)):00:00', '$((1 + ${phone}%4))');\n\n"
        phone=$(((phone+89450934)%89999999 + 10000000))
        num=$((num+1))
        done
done

printf "${first}"
printf "${second}"
printf "${third}"
printf "${fourth}"