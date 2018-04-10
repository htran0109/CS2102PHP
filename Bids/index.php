<!-- Page to display bids of the currently active user.
     Should display whether the bids are accepted or not,
     and clicking should move to the bid profile page -->
<?PHP
  session_start();
  
  if (empty($_SESSION["username"])){
    echo "<script type='text/javascript'> 
    alert('You are not logged in. You will be redirected to the login page.');
    window.location.href = '../index.php';
    </script>";
  }
  else {
    $user = $_SESSION["username"];
  }
?>
<!DOCTYPE html>
<head>
  <title>Bid Profile</title>
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

  <h2>My Bids:</h2>
  <?php

          $user = $_SESSION["username"];
          $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");  
          $result = pg_query($db, "SELECT * FROM bid WHERE bidder = '$user'");    // Query template
          //$row    = pg_fetch_assoc($result);
          
          while ($row = pg_fetch_array($result)) { 
            if($row['accepted'] == 't') {
            echo "<a style='text-decoration:none' href='http://localhost/demo/Bids/profile.php?Owner=$row[owner]&Seats=$row[seats_desired]&Start=$row[origin]&Dest=$row[destination]&depDate=$row[depart_date]&depTime=$row[depart_time]'> 
              <div class = 'container-fluid list-group-item' style='background-color:#5cd65e'>  
                <div class='row'>
                <div class = 'col-sm' style='color:black'>Ad Owner: $row[owner]</div>
                <div class = 'col-sm' style='color:black'>Seats Reserved: $row[seats_desired]</div>     
                <div class = 'col-sm' style='color:black'>Begin Location: $row[origin]</div>
                <div class = 'col-sm' style='color:black'>End Location: $row[destination]</div>
                <div class = 'col-sm' style='color:black'>Departure Date: $row[depart_date]</div>
                <div class = 'col-sm' style='color:black'>Departure Time: $row[depart_time]</div>
              </div>
              </div>
            </a>";
            
            }
            else {
              echo "<a style='text-decoration:none' href='http://localhost/demo/Bids/profile.php?Owner=$row[owner]&Seats=$row[seats_desired]&Start=$row[origin]&Dest=$row[destination]&depDate=$row[depart_date]&depTime=$row[depart_time]'> 
              <div class = 'container-fluid list-group-item' style='background-color:#c1badb'>  
                <div class='row'>
                <div class = 'col-sm' style='color:black'>Ad Owner: $row[owner]</div>
                <div class = 'col-sm' style='color:black'>Seats Reserved: $row[seats_desired]</div>     
                <div class = 'col-sm' style='color:black'>Begin Location: $row[origin]</div>
                <div class = 'col-sm' style='color:black'>End Location: $row[destination]</div>
                <div class = 'col-sm' style='color:black'>Departure Date: $row[depart_date]</div>
                <div class = 'col-sm' style='color:black'>Departure Time: $row[depart_time]</div>
              </div>
              </div>
            </a>";
            
            }
          }
  ?>
  </body>
</html>