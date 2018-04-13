<!DOCTYPE html>
<head>
  <title>Create New Account</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>

	<div class="container">
	<form name="display" action="new.php" method="POST" >
		<h1 class="display-4"> Create New Account </h1>
		<div class="form-group">
			<label for="first_name">First Name</label>
			<input name="first_name" type="text" class="form-control" placeholder="Please enter your legal given name" required />
			<label for="last_name">Last Name</label>
			<input name="last_name" type="text" class="form-control" placeholder="Please enter your legal family name" required />
			<label for="username">UserName</label>
			<input name="username" type="text" class="form-control" placeholder="Enter your desired username" required />
			<label for="password">Password</label>
			<input name="password" type="password" class="form-control" placeholder="Enter your desired password" required />
			<label for="mobilenumber">Mobile Number</label>
			<input name="mobilenumber" type="text" class="form-control" placeholder="Enter your mobile number" required />
			<label for="emailaddress">Email Address</label>
			<input name="emailaddress" type="email" class="form-control" placeholder="Enter your email" required />
			<label for="birthdate">Birthdate</label>
			<input name="birthdate" type="date" class="form-control" placeholder="Enter your birthdate" required />
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ownCar" name="ownCar">
        <label class="form-check-label" for="ownCar">
          I own a car.
        </label>
      </div>
      <div id = "carInfo" style="display:none">
        <label for="license_plate">License Plate</label>
  			<input name="license_plate" type="text" class="form-control" placeholder="Enter your car's license plate" />
        <label for="model">Model</label>
  			<input name="model" type="text" class="form-control" placeholder="Enter your car model e.g. Toyota, Honda, etc." />
        <label for="make">Make</label>
        <input name="make" type="text" class="form-control" placeholder="Enter your car make e.g. Corolla, Civic, etc." />
        <label for="color">Color</label>
        <input name="color" type="text" class="form-control" placeholder="Enter your car color" />
        <label for="total_seats">Seats</label>
        <input name="total_seats" type="number" class="form-control" placeholder="Enter total seats available" />
      </div>
			<p style="color:red">
				<?php

					if (isset($_POST['submit'])) {
						try {
							addBid();
						}
						catch(Exception $e) {
							echo $e->getMessage() . " Please try again.";
						}
					}

					function addBid() {

						$username = trim($_POST['username']);
						$password = trim($_POST['password']);
						$mobilenumber = trim($_POST['mobilenumber']);
						$emailaddress = trim($_POST['emailaddress']);
						$firstname = trim($_POST['first_name']);
						$lastname = trim($_POST['last_name']);
						$birthdate = trim($_POST['birthdate']);

            $license_plate = trim($_POST['license_plate']);
            $model = trim($_POST['model']);
            $make = trim($_POST['make']);
            $color = trim($_POST['color']);
            $total_seats = trim($_POST['total_seats']);
						// Connect to the database. Please change the password in the following line accordingly

						$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
						if ($db) {
							$result = pg_query($db, "SELECT * FROM profile;");
							pg_query($db, "INSERT INTO profile(first_name, last_name, username, password, mobile_number, email, birthday) VALUES('$firstname', '$lastname', '$username', '$password', '$mobilenumber', '$emailaddress', '$birthdate');");
							$result1 = pg_query($db, "SELECT * FROM profile;");

              if (pg_num_rows($result1) <= pg_num_rows($result)) {
                throw new exception("Operation failed.");
              }

              if (isset($_POST['ownCar'])) {
                $result2 = pg_query($db, "SELECT * FROM car;");
                pg_query($db, "INSERT INTO car (license_plate, total_seats, color, model, make, username) VALUES('$license_plate', '$total_seats', '$color', '$model', '$make', '$username');");
  							$result3 = pg_query($db, "SELECT * FROM car;");
                if (pg_num_rows($result3) <= pg_num_rows($result2)) {
                  throw new exception("Operation failed.");
                }
              }
							header("Location:../index.php");
						}
						else {
							throw new exception("Connection failed.");
						}
					}
				?>
			</p>
		</div>
		<button name="submit" type="submit" class="btn btn-primary">Submit</button>
		<button name="back" type="submit" class="btn btn-primary"><a href="../index" style="color:white">Back</a></button>

  </form>
	</div>

  <script>
  ownCar.addEventListener( 'change', function() {
    if(this.checked) {
        document.getElementById("carInfo").style.display="inline";
    } else {
        document.getElementById("carInfo").style.display="none";
    }
  });

  </script>

</body>
</html>
