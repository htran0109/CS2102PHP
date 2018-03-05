<!DOCTYPE html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?php session_start();
  $user = $_SESSION['User'];
?>
<head>
    <title>Registration</title>
</head>
<body>
<nav class="navbar navbar-default">
<div class="container-fluid">
  <ul class="nav navbar-nav navbar-left">
    <li><a href="http://localhost/demo/Listings/new.php">Create Listing</a></li>
    <li><a href="http://localhost/demo/Listings/index.php">View My Listings</a></li>
    <li class="active"><a href="http://localhost/demo/App/search.php">Join a Ride</a></li>
  </ul>
  <ul class="nav navbar-nav navbar-right">
    <li><a href="http://localhost/demo/Users/index.php">My Profile</a></li>
  </ul>
</div>
</nav>
  <h2>Registration</h2>
  <ul>
    <form name="display" action="http://localhost/demo/Users/profile.php" method="POST" >
        <li>UserName</li>
        <li><input type="text" name="username"></li>
        <li>Mobile Number</li>
        <li><input type="text" name="phonenumber"></li>
        <li>Email Address</li>
        <li><input type="text" name="emailaddress"></li>
        <li>Password</li>
        <li><input type="password" name="password"></li>
        <li>LicenseNumber</li>
        <li><input type="text" name="license"></li>
        <li>Available Seats</li>
        <li><input type="number" name="seats"></li>
        <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
    // Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
    if($db) {
      echo "database connected";
    }
    else {
      echo "problem with database connection";
    }

    if (isset($_POST['submit'])) { // Submit the update SQL command
        $insert = pg_query($db, "INSERT INTO Users (UserName, MobileNumber, EmailAddress, Password) 
          VALUES (  
            '$_POST[username]',
            '$_POST[phonenumber]', 
            '$_POST[emailaddress]',  
            '$_POST[password]')"
        );    

        if ($_POST['license'] != null) {
            $car = pg_query($db, "INSERT INTO Cars (LicenseNumber, AvailableSeats) 
            VALUES (  
              '$_POST[license]',
              '$_POST[seats]')"
            );

            $owns = pg_query($db, "INSERT INTO Owns (UserName, LicenseNumber) 
            VALUES (  
              '$_POST[username]',
              '$_POST[license]')"
            );
        }
        if (!$insert) {
            echo "Create failed!!";
        } else {
            echo "Create successful!";
        }
    }
    ?>  
</body>
</html>