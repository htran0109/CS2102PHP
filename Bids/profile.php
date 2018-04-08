<?PHP
	session_start();
	if (empty($_SESSION["username"])){
		echo "<script type='text/javascript'> 
		alert('You are not logged in. You will be redirected to the login page.');
		window.location.href = 'index.php';
		</script>";
	}
	
	
	//include(../App/search.php);
	$owner = $_GET['Owner'];
	$start = $_GET['Start'];
	$dest = $_GET['Dest'];
	$depdate = $_GET['depDate'];
	$deptime = $_GET['depTime'];
	$seats = $_GET['Seats'];
	
	// $owner = 'adam';
	// $start = 'start1';
	// $dest = 'end1';
	// $depdate = '2030-01-01';
	// $deptime = '01:00:00';
	// $seats = '1';
  // http://localhost/demo/Bids/profile.php?Owner='adam'Start='start1'Dest='end1'depDate='2030-01-01'depTime='01:00:00'Seats=1
  
	$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
	$bid = pg_fetch_array(pg_query($db, "SELECT * FROM bid where bidder = $_SESSION["username"] and owner='$owner' and origin='$start' and destination='$dest' and depart_date='$depdate' and depart_time='$deptime';"));
	
?>

<!DOCTYPE html>  
<head>
  <title>Bid Profile</title>
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
		<h1 class="display-4"> Bid Profile </h1>
		<dl class="row">
		  <dt class="col-sm-3">Driver</dt>
		  <dd class="col-sm-9"> <?php echo $bid['owner']; ?>	</dd>
		  <dt class="col-sm-3">Start Location </dt>
		  <dd class="col-sm-9"> <?php echo $bid['customer']; ?>	</dd>
		  <dt class="col-sm-3">Destination </dt>
		  <dd class="col-sm-9"> <?php echo $bid['seats']; ?>	</dd>
		  <dt class="col-sm-3">Departure Date </dt>
		  <dd class="col-sm-9"> <?php echo $bid['depdate']; ?> </dd>
		  <dt class="col-sm-3">Departure Time </dt>
		  <dd class="col-sm-9"> <?php echo $bid['deptime']; ?> </dd>
		</dl>
    <?PHP if ($owner != $_SESSION['username']) { 
      //passengerpage
      if (!$bid['driver_rating'] == null) {
        echo
        <form action="../Bids/profile.php" method="POST">
        <div><label>"How do you rate your driver?"</label></div>
        <div class="radio">
        <label><input type="radio" name="rate" value=1.0>1.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=2.0>2.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=3.0>3.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=4.0>4.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=5.0>5.0</label>
        </div>
          <button name="rate" type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
        </form>;
      } else {
        echo
        <form action="../Bids/profile.php" method="POST">
        <div><label>"How do you rate your driver?"</label></div>
        <div class="radio">
        <label><input type="radio" name="rate" value=1.0 disabled>1.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=2.0 disabled>2.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=3.0 disabled>3.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=4.0 disabled>4.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=5.0 disabled>5.0</label>
        </div>
          <button name="rate" type="submit" class="btn btn-primary" style="margin-top:10px" disabled>Submit</button>
        </form>
      }
      if (!$bid['accepted']) {
        echo <form action="../Ads/profile.php" method="POST"><button name="accept" type="submit" class="btn btn-primary" style="margin-top:10px">Cancel</button></form>;
      } else {
        echo <form action="../Ads/profile.php" method="POST"><button name="accept" type="submit" class="btn btn-primary" style="margin-top:10px" disabled>Accepted</button></form>;
      }
    } else {
      //driver page
      if (!$bid['passenger_rating'] == null) {
        echo
        <form action="../Bids/profile.php" method="POST">
        <div><label>"How do you rate your passenger?"</label></div>
        <div class="radio">
        <label><input type="radio" name="rate" value=1.0>1.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=2.0>2.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=3.0>3.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=4.0>4.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=5.0>5.0</label>
        </div>
          <button name="rate" type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>
        </form>;
      } else {
        echo
        <form action="../Bids/profile.php" method="POST">
        <div><label>"How do you rate your passenger?"</label></div>
        <div class="radio">
        <label><input type="radio" name="rate" value=1.0 disabled>1.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=2.0 disabled>2.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=3.0 disabled>3.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=4.0 disabled>4.0</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="rate" value=5.0 disabled>5.0</label>
        </div>
          <button name="rate" type="submit" class="btn btn-primary" style="margin-top:10px" disabled>Submit</button>
        </form>
      }
      if (!$bid['accepted']) {
        echo <form action="../Bids/profile.php" method="POST"><button name="accept" type="submit" class="btn btn-primary" style="margin-top:10px">Accept</button></form>;
      } else {
        echo <form action="../Bids/profile.php" method="POST"><button name="accept" type="submit" class="btn btn-primary" style="margin-top:10px" disabled>Accepted</button></form>;
      }
    }
    if ($_POST['accept']) {
      if ($owner != $_SESSION['username']) {
        $result = pg_query($db, "
                              DELETE FROM bid 
                              WHERE bidder = $_SESSION["username"] 
                              and owner='$owner' 
                              and origin='$start' 
                              and destination='$dest' 
                              and depart_date='$depdate' 
                              and depart_time='$deptime';"
                            );
      } else {
        $result = pg_query($db, "
                              UPDATE bid
                              SET accepted = true 
                              WHERE bidder = $_SESSION["username"] 
                              and owner='$owner' 
                              and start='$start' 
                              and dest='$dest' 
                              and depdate='$depdate' 
                              and deptime='$deptime' ;"
                            );        
      }

      if ($_POST['rate']) {
        if ($owner != $_SESSION['username']) {
          $result = pg_query($db, "
                                UPDATE bid 
                                SET driver_rating = $_POST['rate']
                                WHERE bidder = $_SESSION["username"] 
                                and owner='$owner' 
                                and origin='$start' 
                                and destination='$dest' 
                                and depart_date='$depdate' 
                                and depart_time='$deptime';"
                              );
        } else {
          $result = pg_query($db, "
                                UPDATE bid
                                SET passenger_rating = $_POST['rate']
                                WHERE bidder = $_SESSION["username"] 
                                and owner='$owner' 
                                and origin='$start' 
                                and destination='$dest' 
                                and depart_date='$depdate' 
                                and depart_time='$deptime';"
                              );        
          
      }
    } 
    ?>
</body>
</html>
