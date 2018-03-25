<?PHP
	session_start();
	/*
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}
	
	
	include(./App/search.php);
	$owner = trim($_POST['owner']);
	$start = trim($_POST['start']);
	$dest = trim($_POST['dest']);
	$depdate = trim($_POST['depdate']);
	$deptime = trim($_POST['deptime']);
	$seats = trim($_POST['seats']);
	*/
	$owner = 'adam';
	$start = 'start1';
	$dest = 'end1';
	$depdate = '2030-01-01';
	$deptime = '01:00:00';
	$seats = '12';
	
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
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<ul class="nav navbar-nav navbar-left">
		  <li><a href="/demo/Listings/new.php">Create Listing</a></li>
		  <li><a href="/demo/Listings/index.php">View My Listings</a></li>
		  <li><a href="/demo/App/search.php">Join a Ride</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
		  <li><a href="/demo/Users/index.php">My Profile</a></li>
		  <li><a href="#">Log Out</a></li>
		</ul>
	  </div>
	</nav>
	<div class="container">
		<h1 class="display-4"> View Advertisement </h1>
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
		<form action="bid.php" method="POST">
			<input name="customers" type="number" placeholder="Seats needed" min="1" required />
			<div style="color:red" id="errorMessage"> </div>
			<button name="bid" type="submit" class="btn btn-primary" style="margin-top:10px">Bid</button>
		</form>
		<form action="../Listings/edit.php" method="POST">
		    <input visibility: hidden name='owner' value = <?php echo $ad['owner']; ?>>
    		<input visibility: hidden name='seats' value = <?php echo $ad['seats']; ?>>
   			<input visibility: hidden name='start' value =  <?php echo $ad['start']; ?>>
    		<input visibility: hidden name='dest' value = <?php echo $ad['dest']; ?>>
    		<input visibility: hidden name='depdate' value = <?php echo $ad['depdate']; ?>>
    		<input visibility: hidden name='deptime' value = <?php echo $ad['deptime']; ?>>
			<button name="Edit" type="submit" class="btn btn-primary" style="margin-top:10px">Edit</button>
		</form>
	</div>

</body>
</html>
