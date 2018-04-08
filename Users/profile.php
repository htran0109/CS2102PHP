<?PHP
	session_start();
	
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}
	$username = isset($_GET["Owner"]) ? $_GET["Owner"] : $_SESSION["username"];
	//$username = 'adam';
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
	<?php
		include_once('../header.php');
	?>
	<div class="container-fluid">
		<h1 class="display-4"> <?php if (isset($_GET["Owner"])) echo $_GET["Owner"] . "'s"; else echo "My"; ?> Profile </h1>
		<dl class="row">
		  <dt class="col-sm-3">User Name</dt>
		  <dd class="col-sm-9"> <?php echo $username; ?> </dd>
		  <dt class="col-sm-3">Mobile Number </dt>
		  <dd class="col-sm-9"> <?php echo $user['mobilenumber']; ?> </dd>
		  <dt class="col-sm-3">Email </dt>
		  <dd class="col-sm-9"> <?php echo $user['emailaddress']; ?> </dd>
		</dl>
		<?php 
		$url = "../Ads/index.php?Owner=$username";
		echo "
			<button type='submit' class='btn'>
				<a href=$url style='text-decoration:none;color:black'>See Ad Listings</a>
			</button>";
		$url = "../Bids/index.php";
		if($username == $_SESSION["username"])
			{
				echo "
			<button type='submit' class='btn'>
				<a href=$url style='text-decoration:none;color:black'>See My Bids</a>
			</button";
			}
		?>
	</div>
</body>
</html>
