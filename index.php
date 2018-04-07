<!DOCTYPE html>  
<head>
  <title>Car Pull</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>
	<?php
	include_once('header.php');
	?>

	<div class="container">
	<form name="display" action="index.php" method="POST" >
		<h1 class="display-1"> Welcome to CarPull </h1>
		<h1 class="display-4"> Please Log In </h1>
		<div class="form-group">
			<label for="UserName">User Name</label>
			<input name="username" type="text" class="form-control" placeholder="Enter username" />
			<label for="Password">Password</label>
			<input name="password" type="password" class="form-control" placeholder="Enter password" />
			<p style="color:red">
				<?php
					if (isset($_POST['submit'])) {
						try {
							checkLogin();
							session_start();
							$_SESSION["username"] = $_POST['username'];
							header('Location:App/Search.php');
						}
						catch(Exception $e) {
							echo $e->getMessage() . " Please try again.";
						}
					}
					
					function checkLogin() {
						if (empty($_POST['username'])) {
							throw new exception("UserName is empty!");
						}
						if (empty($_POST['password'])) {
							throw new exception("Password is empty!");
						}
						
						$username = trim($_POST['username']);
						$password = trim($_POST['password']);
						
						// Connect to the database. Please change the password in the following line accordingly
						$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");	
						if ($db) {
							$result = pg_query($db, "SELECT * FROM users where username = '$username' and password = '$password';");
						
							if(pg_num_rows($result) <= 0) {
								throw new exception("Incorrect username or password.");
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
	Not a user yet? <a href = "Users/new.php"> Register here. </a>
	</div>

</body>
</html>
