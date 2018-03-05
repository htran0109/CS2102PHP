<!-- When the user selects a listing, they should be given this page.
	If they are the creator of the page, they should be able to edit fields and submit them to 
	UPDATE the listing-->
<!-- If they are not the creator, they should be able to bid on the listing-->
<!-- If they are an administrator, any other restrictions should be removed-->	
<!DOCTYPE html>
<head>
	<title>Listing Profile</title>
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
  <?php
  echo "
  <ul>
    <form name='display' action='listings.php' method='POST' >
      <li>Owner</li>
      <!--here replace with username based on user-->
      <li><input type='text' name='username' value=$_GET[Owner] /></li>
      <li>Seats</li>
      <li><input type='number' name='seatsNumber' value=$_GET[Seats] /></li>
      <li>Start location</li>
      <li><input type= 'text' name = 'start_loc' value=$_GET[Start] /></li>
      <li>End location</li>
      <li><input type= 'text' name = 'end_loc' value=$_GET[Dest] /></li>
      <li>Date:</li>
      <li><input type= 'text' name = 'date' value=$_GET[depDate] /></li>
      <li>Departure Time:</li>
      <li><input type= 'text' name = 'starttime' value=$_GET[depTime] /></li>
      <li><input type='submit' name ='submit' /></li>
    </form>
  </ul>"
  ?>
  </body>
</html>