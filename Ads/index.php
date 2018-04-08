<!-- Page to display listings of the currently active user.
  Acts similarly to a search on the user's username. All Listings 
  found here should be editable if clicked on -->
<?PHP
  session_start();
  
  if (empty($_SESSION["username"])){
    echo "<script type='text/javascript'> 
    alert('You are not logged in. You will be redirected to the login page.');
    window.location.href = '../index.php';
    </script>";
  }
  else {
    $user = isset($_GET["Owner"]) ? $_GET["Owner"] : $_SESSION["username"];
  }
?>
<!DOCTYPE html>
<head>
  <title>Listing Profile</title>
  <style>li {list-style: none;}</style>
</head>
<body>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
<head>
  <title>My Listings</title>
</head>
<body>
<?php
include_once('../header.php');
?>
  <h2>My Listings:</h2>
  <?php

          $user = $_SESSION["username"];
          $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");  
          $result = pg_query($db, "SELECT * FROM post WHERE owner = '$user';");    // Query template
          $count = 0;
          while ($row = pg_fetch_array($result)) { 
            echo "<a style='text-decoration:none' href='http://localhost/demo/Ads/profile.php?license_plate=$row[license_plate]&owner=$row[owner]&seats_available=$row[seats_available]&origin=$row[origin]&destination=$row[destination]&depart_date=$row[depart_date]&depart_time=$row[depart_time]'> 
              <div class = 'container-fluid list-group-item' style='background-color:#c1badb'>  
                <div class='row'>
				<div class = 'col-sm' style='color:black'>License Plate: $row[license_plate]</div>
                <div class = 'col-sm' style='color:black'>Ad Owner: $row[owner]</div>
                <div class = 'col-sm' style='color:black'>Seats: $row[seats_available]</div>     
                <div class = 'col-sm' style='color:black'>Begin Location: $row[origin]</div>
                <div class = 'col-sm' style='color:black'>End Location: $row[destination]</div>
                <div class = 'col-sm' style='color:black'>Departure Date: $row[depart_date]</div>
                <div class = 'col-sm' style='color:black'>Departure Time: $row[depart_time]</div>
              </div>
              </div>
            </a>";
            $count = $count + 1;
          }
  ?>
  </body>
</html>