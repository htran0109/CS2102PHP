<!DOCTYPE html>  
<head>
  <title>Search/Edit Existing Listings</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h1>Navigation</h1>
  <ul>
    <li><a>Edit Listings</a></li>
    <li><a href="create.php">Create Listing</a></li>
    <li><a href="profile.php">View Profile</a></li>
    <li><a href="viewList.php">Join a Ride</a></li>
  </ul>
  <h2>Search Listings</h2>
  <ul>
    <form name="display" action="index.php" method="POST" >
      <li>Advertisement ID:</li>
      <li><input type="text" name="adid" /></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");	
    $result = pg_query($db, "SELECT * FROM ads where ad_id = '$_POST[adid]'");		// Query template
    $row    = pg_fetch_assoc($result);		// To store the result row
    if (isset($_POST['submit'])) {
        echo "<ul><form name='update' action='index.php' method='POST' >  
    	<li>Advertisement ID:</li>  
    	<li><input type='text' name='adid_updated' value='$row[ad_id]' /></li>  
    	<li>Advertisement Name:</li>  
    	<li><input type='text' name='ad_name_updated' value='$row[name]' /></li>  
    	<li>Price (USD):</li><li><input type='text' name='price_updated' value='$row[price]' /></li>  
    	<li>Date of publication:</li>  
    	<li><input type='text' name='dop_updated' value='$row[date_of_publication]' /></li>  
      <li>Begin Location:</li>
      <li><input type='text' name='start_loc_updated' value='$row[start_loc]' /></li>
      <li>End Location:</li>
      <li><input type='text' name='end_loc_updated' value='$row[end_loc]' /></li>
    	<li><input type='submit' name='new' /></li>  
    	</form>  
    	</ul>";
    }
    if (isset($_POST['new'])) {	// Submit the update SQL command
        $result = pg_query($db, "UPDATE ads SET ad_id = '$_POST[adid_updated]',  
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
