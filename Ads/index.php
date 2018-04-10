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
    $user = isset($_POST["Owner"]) ? $_POST["Owner"] : $_SESSION["username"];
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
            echo "
              <form action = '../Ads/profile.php' method = 'post'>
                <a style='text-decoration:none' href="javascript:;" onclick="document.parentNode.submit();"> 
                <div class = 'container-fluid list-group-item' style='background-color:#c1badb'>  
                  <div class='row'>
                  <div class = 'col-sm' style='color:black'>License Plate: $row[license_plate]</div>
                  <div class = 'col-sm' style='color:black'>Ad Owner: $row[owner]</div>
                  <div class = 'col-sm' style='color:black'>Seats: $row[seats_available]</div>     
                  <div class = 'col-sm' style='color:black'>Begin Location: $row[origin]</div>
                  <div class = 'col-sm' style='color:black'>End Location: $row[destination]</div>
                  <div class = 'col-sm' style='color:black'>Departure Date: $row[depart_date]</div>
                  <div class = 'col-sm' style='color:black'>Departure Time: $row[depart_time]</div>
                  <input hidden name='license_plate' value = $row[license_plate]>
                  <input hidden name='owner' value = $row[owner]>
                  <input hidden name='seats_available' value = $row[seats_available]>
                  <input hidden name='origin' value =  <?php echo $row['origin']>
                  <input hidden name='destination' value = <?php echo $row['destination']>
                  <input hidden name='depart_date' value = <?php echo $row['depart_date']>
                  <input hidden name='depart_time' value = <?php echo $row['depart_time']>
                </div>
                </div>
              </a>
            </form>";
            
            $count = $count + 1;
          }
  ?>
  </body>
</html>