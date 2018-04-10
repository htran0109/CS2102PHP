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
						$birthdate = $_POST['birthdate'];
						// Connect to the database. Please change the password in the following line accordingly

						$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");	
						if ($db) {
							
							$result = pg_query($db, "SELECT * FROM profile;");
							pg_query($db, "INSERT INTO profile(first_name, last_name, username, password, mobile_number, email, birthday) VALUES('$firstname', '$lastname', '$username', '$password', '$mobilenumber', '$emailaddress', '$birthdate');");
							$result1 = pg_query($db, "SELECT * FROM profile;");
							if(pg_num_rows($result1) <= pg_num_rows($result)) {
								throw new exception("Operation failed.");

							}
							else {
								header("Location:../index");
							}
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

</body>
</html>
