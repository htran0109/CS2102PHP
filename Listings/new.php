<!DOCTYPE html>
<head>
	<title>Create new Listing</title>
  <style>li {list-style: none;}</style>
</head>
<body>
  <h1>Navigation</h1>
  <ul>
    <li><a href="index.php">Edit Listings</a></li>
    <li><a>Create Listing</a></li>
    <li><a href="profile.php">View Profile</a></li>
    <li><a href="viewList.php">Join a Ride</a></li>
  </ul>
  <h2>Create New Listing</h2>
  <ul>
    <form name="display" action="new.php" method="POST" >
      <li>Username</li>
      <!--here replace with username based on user-->
      <li><input type="text" name="username" /></li>
      <li>Seats</li>
      <li><input type="number" name="seatsNumber" /></li>
      <li>Start location</li>
      <li><input type= "text" name = "start_loc"/></li>
      <li>End location</li>
      <li><input type= "text" name = "end_loc"/></li>
      <li>Date:</li>
      <li><input type= "date" name = "date"/></li>
      <li>Departure Time:</li>
      <li><input type= "time" name = "starttime"/></li>
      <li><input type="submit" name ="submit" /></li>
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

        $result = pg_query($db, "INSERT INTO User_Post(Owner,Seats,Start,Dest,depDate,depTime) 
          VALUES ('ad',2,'fds','fsd','01-01-2001','01:23'
    /*'$_POST[username]',  
    '$_POST[seatsNumber]',
    '$_POST[start_loc]', 
    '$_POST[end_loc]',  
    '$_POST[date]', 
    '$_POST[starttime]'*/)");/*
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