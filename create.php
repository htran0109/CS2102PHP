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
      <li>Username</li>
      <!--here replace with username based on user-->
      <li><input type="text" name="username" /></li>
      <li>Trip Title</li>
      <li><input type="text" name="adname" /></li>
      <li>Start location</li>
      <li><input type= "text" name = "start_loc"/></li>
      <li>End location</li>
      <li><input type= "text" name = "end_loc"/></li>
      <li>Price</li>
      <li><input type= "number" name = "price"/></li>
      <li><input type="submit" name="submit" /></li>
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
    $date   = getdate(); //get the current date. Used when new listing is created.
    if(!$date) {
      echo "Date isn't set";
    }
    else {
      echo "Date is set, it is " . "$date[0]";
    }
    if(isset($_POST['submit'])) {
      echo "Submit is set";
    }
    else {
      echo "Submit not set";
    }
    //if (isset($_POST['submit'])) { // Submit the update SQL command
        $result = pg_query($db, /*"INSERT INTO ads (ad_id, username, name, price, date_of_publication, start_loc, end_loc) 
          VALUES (
    '$_POST[username]'.'$date[0]',  
    '$_POST[username]',
    '$_POST[ad_name]', $_POST[price],  
    '$date[year]'.'-'.'$date[mon]'.'-'.'$date[mday]', 
    '$_POST[start_loc]',
    '$_POST[end_loc]')"*/
        "INSERT INTO ads(ad_id, name, price, date_of_publication, start_loc, end_loc)
VALUES ('101', 'Drive to Capitol', 10, '2018-2-17', 'Home', 'Capitol')");
        if (!$result) {
            echo "Create failed!!";
        } else {
            echo "Create successful!";
        }
    //}
    ?>  
</body>
</html>