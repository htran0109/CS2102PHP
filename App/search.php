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
    $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
    if ($db){ //fetch current user
      $result = pg_query($db, "SELECT * FROM users where username = '$user'");
      $row = pg_fetch_array($result);
      $admin = $row["admin"];
    }
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
      <li><a href="http://localhost/demo/Listings/new.php">Create Listing</a></li>
      <li><a href="http://localhost/demo/Listings/profile.php">View My Listings</a></li>
      <li class="active"><a href="http://localhost/demo/App/search.php">Join a Ride</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="http://localhost/demo/Users/index.php">My Profile</a></li>
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
      <li><input type= "date" name = "sdate" /></li>
      <li><input type= "date" name = "edate" /></li>
      <li>Departure Time Range:</li>
      <li><input type= "text" name = "stime" placeholder = '00:00'/></li>
      <li><input type= "text" name = "etime" placeholder = '23:59'/></li>
      <li>Required Seats:</li>
      <li><input type= "number" name = "seats"/></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>

    <?php
      // Connect to the database. Please change the password in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
      if ($db){
        if ($_POST[sdate] == null) { $_POST[sdate] = date('Y-m-d'); }
        if ($_POST[edate] == null) { $_POST[edate] = date('Y-m-d',strtotime(' + 30 days',strtotime($_POST[sdate]))); }
        $_POST[stime] = ($_POST[stime] == null) ? date('H:i',strtotime("00:00")) : date('H:i',strtotime($_POST[stime]));
        $_POST[etime] = ($_POST[etime] == null) ? date('H:i',strtotime("23:59")) : date('H:i',strtotime($_POST[etime]));
        $_POST[seats] = ($_POST[seats] == null) ? 0 : $_POST[seats];
        $result = pg_query($db, 
                  "SELECT *,
                  (case when Owner = '$_POST[adname]'  then 1 else 0 end) +
                  (case when Seats >= '$_POST[seats]' then 1 else 0 end) +
                  (case when Start = '$_POST[adstartloc]' then 1 else 0 end) +
                  (case when Dest = '$_POST[adendloc]' then 1 else 0 end) +
                  (case when depDate BETWEEN '$_POST[sdate]' AND '$_POST[edate]' then 1 else 0 end) +
                  (case when depTime BETWEEN '$_POST[stime]' AND '$_POST[etime]' then 1 else 0 end)
                  as relevance
                  FROM User_Post 
                  WHERE Owner = '$_POST[adname]' 
                  OR Seats >= '$_POST[seats]'
                  OR Start = '$_POST[adstartloc]'
                  OR Dest = '$_POST[adendloc]'
                  OR depDate BETWEEN '$_POST[sdate]' AND '$_POST[edate]'
                  OR depTime BETWEEN '$_POST[stime]' AND '$_POST[etime]'
                  ORDER BY relevance DESC");    
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

            echo "<a href='http://localhost/demo/Listings/listings.php?Owner=$row[owner]&Seats=$row[seats]&Start=$row[start]&Dest=$row[dest]&depDate=$row[depdate]&depTime=$row[deptime]'> 
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