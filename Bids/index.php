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
<script type="text/javascript">
  function submitForm(form) {
      //get the form element's document to create the input control with
      //(this way will work across windows in IE8)
      var button = form.ownerDocument.createElement('input');
      //make sure it can't be seen/disrupts layout (even momentarily)
      button.style.display = 'none';
      //make it such that it will invoke submit if clicked
      button.type = 'submit';
      //append it and click it
      form.appendChild(button).click();
      //if it was prevented, make sure we don't get a build up of buttons
      form.removeChild(button);
  }
  </script>
    
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
          $user   = $_SESSION['username'];
          $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");  
          $result = pg_query($db, "SELECT * FROM bid WHERE bidder = '$user'");    // Query template
          //$row    = pg_fetch_assoc($result);
          $bidrow= 
          "
            <form action='profile.php' method='POST'>
            <a style='text-decoration:none' href='javascript:;' onClick='submitForm(this)'> 
              <div class = 'container-fluid list-group-item' style='background-color:%s'>  
                <div class='row'>
                <div class = 'col-sm' style='color:black'>Ad %s: %s</div>
                <div class = 'col-sm' style='color:black'>Seats Reserved: %s</div>     
                <div class = 'col-sm' style='color:black'>Begin Location: %s</div>
                <div class = 'col-sm' style='color:black'>End Location: %s</div>
                <div class = 'col-sm' style='color:black'>Departure Date: %s</div>
                <div class = 'col-sm' style='color:black'>Departure Time: %s</div>
              </div>
              </div>
              <input hidden name='%s' value = %s>
              <input hidden name='seats_desired' value = %s>
              <input hidden name='origin' value = %s>
              <input hidden name='destination' value = %s>
              <input hidden name='depart_date' value = %s>
              <input hidden name='depart_time' value = %s>
            </a>
            </form>";

          while ($row = pg_fetch_array($result)) { 
            if($row['accepted'] == 't') {
            echo sprintf($bidrow, 
                            '#5cd65e',
                            'Owner',
                            $row['owner'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time'],
                            'owner',
                            $row['owner'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time']);
            
            }
            else {
            echo sprintf($bidrow, 
                            '#c1badb',
                            'Owner',
                            $row['owner'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time'],
                            'owner',
                            $row['owner'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time']);
            }
          }
  ?>
  <h2>Bids on my Ads:</h2>
  <?PHP
          
          $result = pg_query($db, "SELECT * FROM bid WHERE owner = '$user'");    // Query template
          //$row    = pg_fetch_assoc($result);
          while ($row = pg_fetch_array($result)) { 
            if($row['accepted'] == 't') {
            echo sprintf($bidrow, 
                            '#5cd65e',
                            'Bidder',
                            $row['bidder'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time'],
                            'bidder',
                            $row['bidder'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time']);
            
            }
            else {
            echo sprintf($bidrow, 
                            '#c1badb',
                            'Bidder',
                            $row['bidder'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time'],
                            'bidder',
                            $row['bidder'],
                            $row['seats_desired'],
                            $row['origin'],
                            $row['destination'],
                            $row['depart_date'],
                            $row['depart_time']);
            }
          }
    
  ?>
  </body>
</html>