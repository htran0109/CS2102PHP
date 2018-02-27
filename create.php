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
      <li>Create New Listing</li>
      <li>Trip Title:</li>
      <!--here add username field based on user-->
      <li><input type="text" name="adname" /></li>
      <li>Start location</li>
      <li><input type= "text" name = "start_loc"/></li>
      <li>End location</li>
      <li><input type= "text" name = "end_loc"/></li>
      <li><input type="submit" name="submit" /></li>
  </ul>
  <?php
    // Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
    $result = pg_query($db, "SELECT * FROM ads where ad_id = '$_POST[adid]'");    // Query template
    $row    = pg_fetch_assoc($result);    // To store the result row
    $date   = getdate(); //get the current date. Used when new listing is created.
    if (isset($_POST['submit'])) { // Submit the update SQL command
        $result = pg_query($db, "INSERT ads SET ad_id = '$_POST[adid_updated]',  
    name = '$_POST[ad_name_updated]',price = '$_POST[price_updated]',  
    date_of_publication = '$_POST[dop_updated]', 
    start_loc = '$_POST[start_loc_updated]',
    end_loc = '$_POST[end_loc_updated]'");
        if (!$result) {
            echo "Update failed!!";
        } else {
            echo "Update successful!";
        }
    }
    ?>  
</body>
</html>