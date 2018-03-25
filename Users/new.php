<!DOCTYPE html>  
<head>
  <title>Create New Account</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
      <li><a href="http://localhost/Listings/new.php">Create Listing</a></li>
      <li><a href="http://localhost/Listings/index.php">View My Listings</a></li>
      <li><a href="http://localhost/App/search.php">Join a Ride</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="http://localhost/Users/index.php">My Profile</a></li>
	  <li><a href="#">Log Out</a></li>
    </ul>
  </div>
</nav>
	<div class="container">
	<form name="display" action="new.php" method="POST" >
		<h1 class="display-4"> Create New Account </h1>
		<div class="form-group">
			<label for="username">UserName</label>
			<input name="username" type="text" class="form-control" placeholder="Enter your desired username" required />
			<label for="password">Password</label>
			<input name="password" type="password" class="form-control" placeholder="Enter your desired password" required />
			<label for="mobilenumber">Mobile Number</label>
			<input name="mobilenumber" type="text" class="form-control" placeholder="Enter your mobile number" required />
			<label for="emailaddress">Email Address</label>
			<input name="emailaddress" type="email" class="form-control" placeholder="Enter your email" required />
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
						
						// Connect to the database. Please change the password in the following line accordingly
						
						$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");	
						if ($db) {
							
							$result = pg_query($db, "SELECT * FROM users;");
							pg_query($db, "INSERT INTO users(username, password, mobilenumber, emailaddress) VALUES('$username', '$password', '$mobilenumber', '$emailaddress');");
							$result1 = pg_query($db, "SELECT * FROM users;");
							if(pg_num_rows($result1) <= pg_num_rows($result)) {
								throw new exception("Operation failed.");
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
    	</form>
	</div>

</body>
</html>
