<!DOCTYPE html>
<head>
	<title>Create new Listing</title>
  <style>li {list-style: none;}</style>
</head>
<body>
<nav class="navbar navbar-default">
<div class="container-fluid">
  <ul class="nav navbar-nav navbar-left">
    <li><a href="http://localhost/Listings/new.php">Create Listing</a></li>
    <li><a href="http://localhost/Listings/index.php">View My Listings</a></li>
    <li class="active"><a href="http://localhost/App/search.php">Join a Ride</a></li>
  </ul>
  <ul class="nav navbar-nav navbar-right">
    <li><a href="http://localhost/Users/index.php">My Profile</a></li>
  </ul>
</div>
</nav>
  <h2>Create New Listing</h2>
  <ul>
    <form name="display" action="create.php" method="POST" >
      <li>Find Listings By:</li>
      <li>Trip Title:</li>
      <li><input type="text" name="adname" /></li>
      <li>Depart From:</li>
      <li><input type= "text" name = "adstartloc"/></li>
      <li>Going to:</li>
      <li><input type= "text" name = "adendloc"/></li>
      <li>Date:</li>
      <li><input type= "date" name = "date"/></li>
      <li>Departure Time:</li>
      <li><input type= "time" name = "deptime"/></li>
      <li>Required Seats:</li>
      <li><input type= "number" name = "seats"/></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
    // Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
    //$row    = pg_fetch_assoc($result);    // To store the result row
    if($db) {
      echo "database connected";
    }
    else {
      echo "problem with database connection";
    }

    if (isset($_POST['submit'])) { // Submit the update SQL command
      $date   = getdate(); //get the current date. Used when new listing is created.
      $year = $date['year']; //define date constants to parse for later
      $mon = $date['mon'];
      $day = $date['mday'];
      $datStr = $date['0'];
      $adId = $_POST[username] . $datStr;
      $fullDate = $year.'-'.$mon.'-'.$day;
      echo $adId;
      echo $fullDate;
        $result = pg_query($db, "INSERT INTO ads (ad_id, username, name, price, date_of_publication, start_loc, end_loc) 
          VALUES (
    '$adId',  
    '$_POST[username]',
    '$_POST[adname]', 
    '$_POST[price]',  
    '$fullDate', 
    '$_POST[start_loc]',
    '$_POST[end_loc]')");/*
        "INSERT INTO ads(ad_id, name, price, date_of_publication, start_loc, end_loc)
VALUES ('102', 'Drive to Capitol', 10, '2018-2-17', 'Home', 'Capitol')");*/
        if (!$result) {
            echo "Create failed!!";
        } else {
            echo "Create successful!";
        }
    }
    ?>  
</body>
</html>