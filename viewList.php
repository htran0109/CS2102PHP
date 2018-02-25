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
  <ul>
      <li>Find Listings By:</li>
      <li>Trip Title:</li>
      <!--here add username field based on user-->
      <li><input type="text" name="adname" /></li>
      <li>Advertisement start location</li>
      <li><input type= "text" name = "adstartloc"/></li>
      <li>Advertisement end location</li>
      <li><input type= "text" name = "adendloc"/></li>
      <li><input type="submit" name="submit" /></li>
  </ul>
</body>
</html>