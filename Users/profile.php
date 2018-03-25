<?PHP
	session_start();
	/*
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}*/
	
	//$username = $_SESSION["username"];
	$username = 'adam';
	$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
	$user = pg_fetch_array(pg_query($db, "SELECT * FROM users where username='$username';"));
	
?>

<!DOCTYPE html>  
<head>
  <title>View Advertisement</title>
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
		<h1 class="display-4"> My Profile </h1>
		<dl class="row">
		  <dt class="col-sm-3">User Name</dt>
		  <dd class="col-sm-9"> <?php echo $username; ?> </dd>
		  <dt class="col-sm-3">Mobile Number </dt>
		  <dd class="col-sm-9"> <?php echo $user['mobilenumber']; ?> </dd>
		  <dt class="col-sm-3">Email </dt>
		  <dd class="col-sm-9"> <?php echo $user['emailaddress']; ?> </dd>
		</dl>
	</div>

</body>
</html>
