<?PHP
	session_start();
	
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}
	$user = $_SESSION["username"];
	$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
?>

<!DOCTYPE html>  
<head>
  <title>Create New Advertisement</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>

<?php
include_once('../header.php');
?>
	<div class="container">
	<form id="form" action="new.php" method="POST" >
		<h1 class="display-4"> Create New Advertisement </h1>
		<div class="form-group">
			<label for="start">Starting Location</label>
			<input name="start" type="text" class="form-control" placeholder="Enter your starting location" required />
			<label for="dest">Destination</label>
			<input name="dest" type="text" class="form-control" placeholder="Enter your destination" required />
			<label for="depdate">Departure Date</label>
			<input name="depdate" type="date" class="form-control" placeholder="Enter your departure date" required />
			<label for="deptime">Departure Time</label>
			<input name="deptime" type="time" class="form-control" placeholder="Time" required />
			<label for="seats">Number of Seats</label>
			<input name="seats" type="number" class="form-control" placeholder="Enter the maximum number of seats available" required />
			<label for="car">Car</label>
			<select class="custom-select" name="car" form="form">
				<?php 
					$carResults = pg_query($db, "Select * from car where username='$user';");
					 while ($row = pg_fetch_array($carResults)) {
						 echo "
							<option value=$row[license_plate]> 
							$row[license_plate] - $row[model] $row[make]
							</option>
						 ";
					 }
					
				?>
			</select>
			
			<p style="color:red">
				<?php
					
					if (isset($_POST['submit'])) {
						try {
							addBid();
							header("Location:index.php");
						}
						catch(Exception $e) {
							echo $e->getMessage() . " Please try again.";
						}
					}
					
					function addBid() {
						
						$car = trim($_POST['car']);
						$owner = $_SESSION['username'];
						$start = trim($_POST['start']);
						$dest = trim($_POST['dest']);
						$depdate = trim($_POST['depdate']);
						$deptime = trim($_POST['deptime']);
						$seats = trim($_POST['seats']);
						
						// Connect to the database. Please change the password in the following line accordingly
						$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
						$result = pg_query($db, "SELECT * FROM post;");
						pg_query($db, "INSERT INTO post(license_plate, owner, seats_available, origin, destination, depart_date, depart_time) VALUES('$car', '$owner', $seats, '$start', '$dest', '$depdate', '$deptime');");
						$result1 = pg_query($db, "SELECT * FROM post;");
						if(pg_num_rows($result1) <= pg_num_rows($result)) {
							throw new exception("Operation failed.");
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
