<!DOCTYPE html>  
<?php session_start();
  $user = $_SESSION['User'];
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<head>
  <title>Profile</title>
  <style>li {list-style: none;}</style>
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
  <ul><?php
    echo "<li>UserName: </li>
    <li>Mobile Number: </li>
    <li>Email Address: </li>
    <li>Password: </li>
    <li>LicenseNumber: </li>
    <li>Available Seats: </li>"
    ?>
  </ul>
</body>
</html>