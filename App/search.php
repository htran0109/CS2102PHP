<?php session_start();
  $user = $_SESSION['User'];
?>
<!DOCTYPE html>
<head>
  <title>Search Listing</title>
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
  <h2> Join Listing:</h2>
  <ul><form name = 'search' action='http://localhost/App.search.php' method='POST'>
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
      <li><input type= "time" name = "starttime"/></li>
      <li>Required Seats:</li>
      <li><input type= "number" name = "seats"/></li>
      <li><input type="submit" name="submit" /></li>
  </ul>

  <ul>
    <?php
      // Connect to the database. Please change the password in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");	
      if ($db){
        $result = pg_query($db, 
                  "SELECT * FROM User_Post 
                  WHERE Owner = '$_POST[adname]' 
                  OR Seats >= '$_POST[seats]'
                  OR Start = '$_POST[adstartloc]'
                  OR End = '$_POST[adendloc]'
                  OR depDate = '$_POST[date]'
                  OR depTime = '$_POST[starttime]'
                  ORDER BY ad_id ASC LIMIT 20");		
        if (isset($_POST['submit'])) {
          while ($row = pg_fetch_array($result)) { 
            echo "<a href='http://localhost/listing.php'> 
              <ul>   
                <li>Advertisement Name: '$row[Owner]'</li>
                <li>Seats: '$row[Seats]'<\li>     
                <li>Begin Location: '$row[Start]'</li>
                <li>End Location: '$row[End]'</li>
                <li>Departure Date: '$row[depDate]'</li>
                <li>Departure Time: '$row[depTime]'</li>
              </ul>
            </a>";
          }
        } 
      } else {
        echo "Connection failed";
      }
      ?>
  </ul>
</body>
</html>