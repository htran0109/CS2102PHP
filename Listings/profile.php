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
    $user = $_SESSION["username"];
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
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-left">
      <li><a href="/demo/Listings/new.php">Create Listing</a></li>
      <li><a href="/demo/Listings/profile.php">View My Listings</a></li>
      <li class="active"><a href="/demo/App/search.php">Join a Ride</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/demo/Users/index.php">My Profile</a></li>
    </ul>
  </div>
</nav>
  <h2>My Listings:</h2>
  <?php

          $user = $_SESSION["username"];
          echo "Listings for " . "$user" . ":";
          $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");  
          $result = pg_query($db, "SELECT * FROM User_Post WHERE Owner = '$user'");    // Query template
          //$row    = pg_fetch_assoc($result);
          $count = 0;
          while ($row = pg_fetch_array($result)) { 

            if($count % 2 == 0) {
            echo "<a href='http://localhost/demo/Listings/listings.php?Owner=$row[owner]&Seats=$row[seats]&Start=$row[start]&Dest=$row[dest]&depDate=$row[depdate]&depTime=$row[deptime]'> 
              <div class = 'container' style='background-color:#d2d6db'>  
                <li>Advertisement Name: $row[owner]</li>
                <li>Seats: $row[seats]</li>     
                <li>Begin Location: $row[start]</li>
                <li>End Location: $row[dest]</li>
                <li>Departure Date: $row[depdate]</li>
                <li>Departure Time: $row[deptime]</li>
              </div>
            </a>";
            }
            else {
              echo "<a href='http://localhost/demo/Listings/listings.php?Owner=$row[owner]&Seats=$row[seats]&Start=$row[start]&Dest=$row[dest]&depDate=$row[depdate]&depTime=$row[deptime]'> 
              <div class = 'container' style='background-color:#e1e5ea'>  
                <li>Advertisement Name: $row[owner]</li>
                <li>Seats: $row[seats]</li>     
                <li>Begin Location: $row[start]</li>
                <li>End Location: $row[dest]</li>
                <li>Departure Date: $row[depdate]</li>
                <li>Departure Time: $row[deptime]</li>
              </div>
            </a>";
            }
          }
  ?>
  </body>
</html>