<?PHP
	session_start();
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'>
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}

	$owner = $_POST['owner'];
	$origin = $_POST['origin'];
	$destination = $_POST['destination'];
	$depart_date = $_POST['depart_date'];
	$depart_time = $_POST['depart_time'];
	$seats_available = $_POST['seats_available'];

	$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
	$ad = pg_fetch_array(pg_query($db, "SELECT * FROM post where owner='$owner' and origin='$origin' and destination='$destination' and depart_date='$depart_date' and depart_time='$depart_time' and seats_available=$seats_available;"));
	$driver_average = pg_fetch_array(pg_query($db, "SELECT owner, AVG(passenger_rating) as average FROM bid where owner = '$owner' AND driver_rating IS NOT NULL GROUP BY owner;"));
	$bid_rating = (pg_num_rows($driver_average) == 0) ? "This user has no ratings yet" : $driver_average['average'];
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
			// echo "Worked";
			// echo "Bidname is " . $_POST['bidname'];
			// echo $owner;
			// echo $destination;
			// echo $origin;
			// echo $depart_date;
			// echo $depart_time;
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
	    		//echo "Accepted";
	    	}
	    	else {
	    		//echo "Error accepting bid";
	    	}
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
		  <dt class='col-sm-3'>Driver Rating</dt>
          <dd class='col-sm-9'> <?php echo $bid_rating ?></dd>
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
		<form style="display:none" id="bidButton" action="profile.php" method="POST">
			<input name="customers" type="number" placeholder="seats_available needed" min="1" required />
			<div style="color:red" id="errorMessage"> </div>
				<?php
				echo "
			      <input hidden name='license_plate' value = $_POST[license_plate]>
                  <input hidden name='owner' value = $_POST[owner]>
                  <input hidden name='seats_available' value = $_POST[seats_available]>
                  <input hidden name='origin' value = $_POST[origin]>
                  <input hidden name='destination' value = $_POST[destination]>
                  <input hidden name='depart_date' value = $_POST[depart_date]>
                  <input hidden name='depart_time' value = $_POST[depart_time]>";
                  ?>
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
				$results = pg_query($db, "SELECT * FROM bid
	    											WHERE owner='$ad[owner]'
	    											AND destination='$ad[destination]'
	    											AND origin='$ad[origin]'
	    											AND depart_date='$ad[depart_date]'
	    											AND depart_time='$ad[depart_time]';");
				while ($row = pg_fetch_array($results)) {
					echo "
						<tr>
							<td> $row[bidder] </td>
							<td> $row[seats_desired] </td>
							<td> <form name='bidAccept' method='POST' action=profile.php>
								<input hidden name='license_plate' value = $row[license_plate]>
								<input hidden name='owner' value = $row[owner]>
								<input hidden name='seats_available' value = $row[seats_available]>
								<input hidden name='origin' value = $row[origin]>
								<input hidden name='destination' value = $row[destination]>
								<input hidden name='depart_date' value = $row[depart_date]>
								<input hidden name='depart_time' value = $row[depart_time]>
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
			if(isset($_POST['bid'])){
			if ((int)$customers > (int)$seats_available) {
				echo "<script type='text/javascript'>
					document.getElementById('errorMessage').innerHTML = 'Not enough seats_available available.';
				</script>";
			}else {

			$result = pg_query($db, "INSERT INTO Bid(Bidder, Owner, origin, destination, depart_date, depart_time, seats_desired) VALUES('$bidder', '$owner', '$origin', '$destination', '$depart_date', '$depart_time', '$customers');");
			if($result == true){
				echo "<h2>Bid Successful!</h2>";
			}
			else {
				echo "<h2 style='color:red'>Bid Unsuccessful, please check the following:</h2>
					  <p style='color:red'>You have not already bid on this listing;</br>You don't have a conflicting bid within 4 hours of this listing's departure;</br>The Listing has not already passed its departure date</p>";
			}
			}
			}
		?>
</body>
</html>
