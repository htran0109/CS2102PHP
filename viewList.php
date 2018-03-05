<!DOCTYPE html>
<head>
  <title>Create new Listing</title>
  <style>li {list-style: none;}</style>
</head>
<body>
  <h1>Navigation</h1>
  <ul>
    <li><a href="index.php">Edit Listings</a></li>
    <li><a href="create.php">Create Listing</a></li>
    <li><a href="profile.php">View Profile</a></li>
    <li><a>Join a Ride</a></li>
  </ul>
  <h2> Join Listing:</h2>
  <ul><form name = 'search' action='http://localhost/viewList.php' method='POST'>
    <li>Find Listings By:</li>
      <li>Trip Title:</li>
      <li><input type="text" name="adname" /></li>
      <li>Advertisement start location</li>
      <li><input type= "text" name = "adstartloc"/></li>
      <li>Advertisement end location</li>
      <li><input type= "text" name = "adendloc"/></li>
      <li>Date</li>
      <li><input type= "date" name = "date"/></li>
      <li>Departure Time</li>
      <li><input type= "time" name = "starttime"/></li>
      <li>Arrival Time</li>
      <li><input type= "time" name = "endtime"/></li>
      <li><input type="submit" name="submit" /></li>
  </ul>

  <ul>
    <?php
      // Connect to the database. Please change the password in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");	
      $result = pg_query($db, 
                "SELECT * FROM ads 
                WHERE name = '$_POST[adname]' 
                AND start_loc = '$_POST[adstartloc]'　
                AND ad_endloc = '$_POST[adendloc]'
                AND departuredate = '$_POST[date]' 
                AND starttime = '$_POST[starttime]'
                AND endtime = '$_POST[endtime]' 
                ORDER BY ad_id ASC LIMIT 20");		
      if (isset($_POST['submit'])) {
        while ($row = pg_fetch_array($result)) { 
          echo "<a href='http://localhost/listing'> 
            <ul>
              <li>Advertisement ID: '$row[ad_id]' </li>   
              <li>Advertisement Name: '$row[name]'</li>    
              <li>Price (USD): '$row[price]' </li>  
              <li>Date of publication: '$row[date_of_publication]' </li>  
              <li>Begin Location: '$row[start_loc]'</li>
              <li>End Location: '$row[end_loc]'</li>
              <li>Departure Time: '$row[starttime]'</li>
              <li>Arrival Time: '$row[endtime]'</li>
            </ul>
          </a>";
        }
      ?>
  </ul>
</body>
</html>