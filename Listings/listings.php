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
    <form name="display" action="listings.php" method="POST" >
      <li>Owner</li>
      <!--here replace with username based on user-->
      <li><input type="text" name="username" value='$_GET[Owner]'/></li>
      <li>Seats</li>
      <li><input type="number" name="seatsNumber" value='$_GET[Seats]' /></li>
      <li>Start location</li>
      <li><input type= "text" name = "start_loc" value='$_GET[Start]'/></li>
      <li>End location</li>
      <li><input type= "text" name = "end_loc" value='$_GET[End]'/></li>
      <li>Date:</li>
      <li><input type= "text" name = "date" value='$_GET[depDate]'/></li>
      <li>Departure Time:</li>
      <li><input type= "text" name = "starttime" value='$_GET[depTime]'/></li>
      <li><input type="submit" name ="submit" /></li>
    </form>
  </ul>
  </body>
</html>