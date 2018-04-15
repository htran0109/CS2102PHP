<?PHP
	session_start();
	
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}
	$username = isset($_POST["Owner"]) ? $_POST["Owner"] : $_SESSION["username"];
	$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
	$user = pg_fetch_array(pg_query($db, "SELECT * FROM profile where username='$username';"));
	
?>

<!DOCTYPE html>  
<head>
  <title>View Profile</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>
	<?php
		include_once('../header.php');
	?>
	<div class="container-fluid">
		<h1 class="display-4"> <?php if (isset($_POST["Owner"])) echo $_POST["Owner"] . "'s"; else echo "My"; ?> Profile </h1>
		<dl class="row">
		  <dt class="col-sm-3">User Name</dt>
		  <dd class="col-sm-9"> <?php echo $username; ?> </dd>
		  <dt class="col-sm-3">Real Name</dt>
		  <dd class="col-sm-9"> <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> </dd>
		  <dt class="col-sm-3">Mobile Number </dt>
		  <dd class="col-sm-9"> <?php echo $user['mobile_number']; ?> </dd>
		  <dt class="col-sm-3">Email</dt>
		  <dd class="col-sm-9"> <?php echo $user['email']; ?> </dd>
		  <dt class="col-sm-3">Date of Birth</dt>
		  <dd class="col-sm-9"> <?php echo $user['birthday']; ?> </dd>
		  <dt class="col-sm-3">Registered Cars</dt>
		  <select class="custom-select" name="car" form="form">
					<?php
					$carResults = pg_query($db, "Select * from car where username='$_SESSION[username]';");
					while ($row = pg_fetch_array($carResults)) {
						echo "
						<option value=$row[license_plate]>
						$row[license_plate] - $row[model] $row[make]
						</option>
						";
					}

					?>
				</select>
		</dl>
		<?php 
		$url = "../Ads/index.php?Owner=$username";
		echo "<div class='mr-1' style='float:left'>
			<form action='$url'>
			<input type='submit' class='btn'
				value='See Ad Listings'/>
			</form></div>";
		$url = "../Bids/index.php";
		if($username == $_SESSION["username"])
			{
				echo "
			<div class='mr-1' style='float:left'>
			<form action='$url'>
			<input type='submit' class='btn'
				value='See Bids'/>
			</form></div>";
			}
		$url = "../Users/edit.php";
		if($username == $_SESSION["username"])
			{
				echo "
			<div style='float:left'>
			<form action='$url'>
			<input type='submit' class='btn'
				value='Edit Page'/>
			</form></div>";
			}
		?>
	</div>
</body>
</html>
