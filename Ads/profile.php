<?PHP
	session_start();
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}
	
	$owner = $_GET['owner'];
	$origin = $_GET['origin'];
	$destination = $_GET['destination'];
	$depart_date = $_GET['depart_date'];
	$depart_time = $_GET['depart_time'];
	$seats_available = $_GET['seats_available'];

	$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
	$ad = pg_fetch_array(pg_query($db, "SELECT * FROM post where owner='$owner' and origin='$origin' and destination='$destination' and depart_date='$depart_date' and depart_time='$depart_time' and seats_available='$seats_available';"));

	?>

<!DOCTYPE html>  
<head>
  <title>View Advertisement</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>
	<?php
	include_once('../header.php');

	?>
	<?php
		if(isset($_POST['bidAccept'])) {
			echo "Worked";
			echo "Bidname is " . $_POST['bidname'];
			echo $owner;
			echo $destination;
			echo $origin;
			echo $depart_date;
			echo $depart_time;
			$select = pg_fetch_array(pg_query($db, "SELECT * FROM bid
	    											WHERE bidder='$_POST[bidname]' 
	    											AND owner='$owner'
	    											AND destination='$destination'
	    											AND origin='$origin'
	    											AND depart_date='$depart_date' 
	    											AND depart_time='$depart_time';"));

			echo $select['bidder'];
	    	$accept = pg_query($db, "UPDATE bid SET accepted='TRUE' 
	    											WHERE bidder='$_POST[bidname]' 
	    											AND owner='$owner'
	    											AND destination='$destination'
	    											AND origin='$origin'
	    											AND depart_date='$depart_date' 
	    											AND depart_time='$depart_time';");
	    	if(pg_affected_rows($accept) > 0) {
	    		echo "Accepted";
	    	}
	    	else {
	    		echo "Error accepting bid";
	    	}
	    }
    	else{
    		echo "Waiting";
    	}
	?>
	<div class="container">
		<h1 class="display-4"> View Advertisement </h1>
		<form action="edit.php" method="POST">
		    <input hidden name='owner' value = <?php echo $ad['owner']; ?>>
    		<input hidden name='seats_available' value = <?php echo $ad['seats_available']; ?>>
   			<input hidden name='origin' value =  <?php echo $ad['origin']; ?>>
    		<input hidden name='destination' value = <?php echo $ad['destination']; ?>>
    		<input hidden name='depart_date' value = <?php echo $ad['depart_date']; ?>>
    		<input hidden name='depart_time' value = <?php echo $ad['depart_time']; ?>>
			<button style="display:none" id="editButton" name="Edit" type="submit" class="btn btn-primary" style="margin-top:10px"> Edit
			</button>
		</form>
		<dl class="row">
			<dt class="col-sm-3">License Plate</dt>
		  <dd class="col-sm-9"> <?php echo $ad['license_plate']; ?>	</dd>
		  <dt class="col-sm-3">Driver</dt>
		  <dd class="col-sm-9"> <?php echo $ad['owner']; ?>	</dd>
		  <dt class="col-sm-3">Origin </dt>
		  <dd class="col-sm-9"> <?php echo $ad['origin']; ?>	</dd>
		  <dt class="col-sm-3">Destination </dt>
		  <dd class="col-sm-9"> <?php echo $ad['destination']; ?>	</dd>
		  <dt class="col-sm-3">Departure Date </dt>
		  <dd class="col-sm-9"> <?php echo $ad['depart_date']; ?> </dd>
		  <dt class="col-sm-3">Departure Time </dt>
		  <dd class="col-sm-9"> <?php echo $ad['depart_time']; ?> </dd>
		  <dt class="col-sm-3">Seats Available </dt>
		  <dd class="col-sm-9"> <?php echo $ad['seats_available']; ?> </dd>
		</dl>
		<form style="display:none" id="bidButton" action="../Bids/new.php" method="POST">
			<input name="customers" type="number" placeholder="seats_available needed" min="1" required />
			<div style="color:red" id="errorMessage"> </div>
			<button name="bid" type="submit" class="btn btn-primary" style="margin-top:10px">Bid</button>
		</form>
		
		<table class="table" id="bidTable" style="display:none">
			<h1 id ="bidTableTitle" style="display:none" class="display-4"> Current Bids </h1>
			<thead>
				<tr>
					<th scope="col">Username</th>
					<th scope="col">Seats Required</th>
					<th scope="col"></th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
			<?php
				$user = $_SESSION["username"];
				$results = pg_query($db, "SELECT * FROM Bid WHERE owner = '$user';");
			
				while ($row = pg_fetch_array($results)) {
					echo "
						<tr>
							<td> $row[bidder] </td>
							<td> $row[seats_desired] </td>
							<td> <form name='bidAccept' method='post' action=profile.php?license_plate=$_GET[license_plate]&owner=$_GET[owner]&seats_available=$_GET[seats_available]&origin=$_GET[origin]&destination=$_GET[destination]&depart_date=$_GET[depart_date]&depart_time=$_GET[depart_time]> 
								<input type='text' name='bidname' id='bidname' value='$row[bidder]' visibility: hidden>
								<input type='submit' name='bidAccept' id='bidAccept' value='Accept Bid'>
								</form> 
							</td>
							<td> </td>
						</tr>
					";
				}
			?>
			</tbody>
		</table>
		
		<?PHP
			
			if (strcmp($user, $owner) == 0) {
				echo "<script type='text/javascript'> 
					document.getElementById('editButton').style.display = 'inline';
					document.getElementById('bidTable').style.display = 'table';
					document.getElementById('bidTableTitle').style.display = 'inline';
				</script>";
			}
			else {
				echo "<script type='text/javascript'> 
				document.getElementById('bidButton').style.display = 'inline';
				</script>";
			}
			
			$bidder = $_SESSION["username"];
			$customers = $_POST['customers'];
				
			if ((int)$customers > (int)$seats_available) {
				echo "<script type='text/javascript'> 
					document.getElementById('errorMessage').innerHTML = 'Not enough seats_available available.';
				</script>";
			}
			
			pg_query($db, "INSERT INTO Bid(Bidder, Owner, origin, destination, depart_date, depart_time, seats_desired) VALUES('$bidder', '$owner', '$origin', '$destination', '$depart_date', '$depart_time', '$customers');"); 
		?>
</body>
</html>
