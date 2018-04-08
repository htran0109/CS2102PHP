<?PHP
	session_start();
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}
	
	$owner = $_GET['Owner'];
	$start = $_GET['Start'];
	$dest = $_GET['Dest'];
	$depdate = $_GET['depDate'];
	$deptime = $_GET['depTime'];
	$seats = $_GET['Seats'];

	$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
	$ad = pg_fetch_array(pg_query($db, "SELECT * FROM user_post where owner='$owner' and start='$start' and dest='$dest' and depdate='$depdate' and deptime='$deptime' and seats='$seats';"));
	
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
	<div class="container">
		<h1 class="display-4"> View Advertisement </h1>
		<form action="edit.php" method="POST">
		    <input hidden name='owner' value = <?php echo $ad['owner']; ?>>
    		<input hidden name='seats' value = <?php echo $ad['seats']; ?>>
   			<input hidden name='start' value =  <?php echo $ad['start']; ?>>
    		<input hidden name='dest' value = <?php echo $ad['dest']; ?>>
    		<input hidden name='depdate' value = <?php echo $ad['depdate']; ?>>
    		<input hidden name='deptime' value = <?php echo $ad['deptime']; ?>>
			<button style="display:none" id="editButton" name="Edit" type="submit" class="btn btn-primary" style="margin-top:10px"> Edit
			</button>
		</form>
		<dl class="row">
		  <dt class="col-sm-3">Driver</dt>
		  <dd class="col-sm-9"> <?php echo $ad['owner']; ?>	</dd>
		  <dt class="col-sm-3">Start Location </dt>
		  <dd class="col-sm-9"> <?php echo $ad['start']; ?>	</dd>
		  <dt class="col-sm-3">Destination </dt>
		  <dd class="col-sm-9"> <?php echo $ad['dest']; ?>	</dd>
		  <dt class="col-sm-3">Departure Date </dt>
		  <dd class="col-sm-9"> <?php echo $ad['depdate']; ?> </dd>
		  <dt class="col-sm-3">Departure Time </dt>
		  <dd class="col-sm-9"> <?php echo $ad['deptime']; ?> </dd>
		  <dt class="col-sm-3">Seats </dt>
		  <dd class="col-sm-9"> <?php echo $ad['seats']; ?> </dd>
		</dl>
		<form style="display:none" id="bidButton" action="../Bids/new.php" method="POST">
			<input name="customers" type="number" placeholder="Seats needed" min="1" required />
			<div style="color:red" id="errorMessage"> </div>
			<button name="bid" type="submit" class="btn btn-primary" style="margin-top:10px">Bid</button>
		</form>
		
		<table class="table" id="bidTable" style="display:none">
			<h1 id ="bidTableTitle" style="display:none" class="display-4"> Current Bids </h1>
			<thead>
				<tr>
					<th scope="col">Username</th>
					<th scope="col">Customers</th>
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
							<td> $row[customers] </td>
							<td> </td>
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
				
			if ((int)$customers > (int)$seats) {
				echo "<script type='text/javascript'> 
					document.getElementById('errorMessage').innerHTML = 'Not enough seats available.';
				</script>";
			}
			
			pg_query($db, "INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers) VALUES('$bidder', '$owner', '$start', '$dest', '$depdate', '$deptime', '$customers');"); 
		?>
</body>
</html>
