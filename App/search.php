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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
<head>
  <title>Search Listing</title>
</head>
<body>
  <?php
  include_once('../header.php');
  ?>
  <!--
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
</nav>-->
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
      <li><input type= "date" name = "sdate" required/></li>
      <li><input type= "date" name = "edate" required/></li>
      <li>Departure Time Range:</li>
      <li><input type= "text" name = "stime" placeholder = '00:00' required/></li>
      <li><input type= "text" name = "etime" placeholder = '23:59' required/></li>
      <li>Required Seats:</li>
      <li><input type= "number" name = "seats"/></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>

    <?php
      // Connect to the database. Please change the password in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
      if ($db){
        $keys[] = (isset($_POST[adname])) ? $_POST[adname] : null;
        $keys[] = (isset($_POST[adstartloc])) ? $_POST[adstartloc] : null;
        $keys[] = (isset($_POST[adendloc])) ? $_POST[adendloc] : null;
        $keys[] = (isset($_POST[sdate])) ? $_POST[sdate] : null;
        $keys[] = (isset($_POST[edate])) ? $_POST[edate] : null;
        $keys[] = (isset($_POST[stime])) ? $_POST[stime] : null;
        $keys[] = (isset($_POST[etime])) ? $_POST[etime] : null;
        $keys[] = (isset($_POST[seats])) ? $_POST[seats] : null;
        $filters = "";
        foreach ($keys as $id => $value) {
          echo $id . $value;
          if ($value == null) { continue; }
          if ($filters != "" && $id != 4 && $id != 6 ) { $filters.=' OR '; }
          switch ($id) {
            case 0:
              $relevance .= " (case when Owner = '$_POST[adname]'  then 1 else 0 end) +";
              $filters .= " owner = '$_POST[adname]'";
              break;

            case 1:
              $relevance .= " (case when start = '$_POST[adstartloc]'  then 1 else 0 end) +";
              $filters.=" start = '$_POST[adstartloc]'";
              break;

            case 2:
              $relevance .= " (case when dest = '$_POST[adendloc]'  then 1 else 0 end) +";
              $filters.=" Dest = '$_POST[adendloc]'";
              break;

            case 3:
              $relevance .= " (case when depDate BETWEEN '$_POST[sdate]'";
              $filters.=" depdate BETWEEN '$_POST[sdate]'";
              break;

            case 4:
              $relevance .= " AND '$_POST[edate]' then 1 else 0 end) +";
              $filters.=" AND '$_POST[edate]'";
              break;

            case 5:
              $relevance .= " (case when deptime BETWEEN '$_POST[stime]'";
              $filters.=" deptime BETWEEN '$_POST[stime]'";
              break;

            case 6:
              $relevance .= " AND '$_POST[etime]' then 1 else 0 end) +";
              $filters.=" AND '$_POST[etime]'";
              break;


            case 7:
              $relevance .= " (case when seats >= '$_POST[seats]' then 1 else 0 end) +";
              $filters.=" seats >= '$_POST[seats]'";
              break;
          }
        }

        $relevance = rtrim($relevance, " +");
        $query = "select *," . $relevance . " as relevance FROM User_Post WHERE " . $filters . " ORDER BY relevance DESC";
        $result = pg_query($db, $query);      
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

            echo "<a href='http://localhost/demo/Ad/viewAd.php?Owner=$row[owner]&Seats=$row[seats]&Start=$row[start]&Dest=$row[dest]&depDate=$row[depdate]&depTime=$row[deptime]'> 
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