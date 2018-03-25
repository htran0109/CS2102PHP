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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<head>
  <title>Search Listing</title>
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
  <h2> Join Listing:</h2>
  <ul><form name = 'search' action='http://localhost/demo/App/search.php' method='POST'>
    <li>Find Listings By:</li>
      <li>Owner:</li>
      <li><input type="text" name="adname" /></li>
      <li>Depart From:</li>
      <li><input type= "text" name = "adstartloc"/></li>
      <li>Going to:</li>
      <li><input type= "text" name = "adendloc"/></li>
      <li>Date:</li>
      <li><input type= "text" name = "date" placeholder="YYYY-MM-DD"/></li>
      <li>Departure Time:</li>
      <li><input type= "text" name = "starttime" placeholder = "HH:MM:SS"/></li>
      <li>Required Seats:</li>
      <li><input type= "number" name = "seats"/></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>

    <?php
      // Connect to the database. Please change the password in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");	
      if ($db){
        echo $_POST[adname];
        echo $_POST[seats];
        echo $_POST[adstartloc];
        echo $_POST[adendloc];
        echo $_POST[date];
        echo $_POST[starttime];
        $result = pg_query($db, 
                  "SELECT * FROM User_Post 
                  WHERE Owner = '$_POST[adname]' 
                  /*OR Seats >= $_POST[seats]*/
                  OR Start = '$_POST[adstartloc]'
                  OR Dest = '$_POST[adendloc]'
                  /*OR depDate = '$_POST[date]'
                  OR depTime = '$_POST[starttime]'*/
                  ORDER BY Owner ASC LIMIT 20");		
        if (isset($_POST['submit'])) {
          if($result) {
            echo "Select Found";
            //echo '$result';
          }
          else {
            echo "Select not found";
          }
          while ($row = pg_fetch_array($result)) { 
            echo $row["owner"];

            echo "<a href='http://localhost/demo/Listings/profile.php?Owner=$row[owner]&Seats=$row[seats]&Start=$row[start]&Dest=$row[dest]&depDate=$row[depdate]&depTime=$row[deptime]'> 
              <ul>   
                <li>Advertisement Name: $row[owner]</li>
                <li>Seats: $row[seats]</li>     
                <li>Begin Location: $row[start]</li>
                <li>End Location: $row[dest]</li>
                <li>Departure Date: $row[depdate]</li>
                <li>Departure Time: $row[deptime]</li>
              </ul>
            </a>";
          }
        } 
      } else {
        echo "Connection failed";
      }
      ?>
</body>
</html>