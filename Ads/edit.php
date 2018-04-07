<!-- When the user selects a listing, they should be given this page.
  If they are the creator of the page, they should be able to edit fields and submit them to 
  UPDATE the listing-->
<!-- If they are not the creator, they should be able to bid on the listing-->
<!-- If they are an administrator, any other restrictions should be removed-->  
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

  $owner = trim($_POST['owner']);
  $start = trim($_POST['start']);
  $dest = trim($_POST['dest']);
  $depdate = trim($_POST['depdate']);
  $deptime = trim($_POST['deptime']);
  $seats = trim($_POST['seats']);
?>
<!DOCTYPE html>
<head>
  <title>Edit Listing</title>
  <style>li {list-style: none;}</style>
</head>
<body>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
  <title>Edit Listing</title>
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
  <h2 class='form-control-static'>Edit Listing</h2>
  <?php
  $user = $_SESSION["username"];
  $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
  if ($db){ //fetch current user
    $result = pg_query($db, "SELECT * FROM users where username = '$user'");
    $row = pg_fetch_array($result);
    $admin = $row["admin"] === 't';
    $result = pg_query($db, 
                  "SELECT * FROM User_Post 
                   WHERE
            Owner = '$owner' AND
            Seats = '$seats' AND
            Start = '$start' AND
            Dest = '$dest' AND
            depDate = '$depdate' AND
            depTime = '$deptime'); "); 
      $row = pg_fetch_array($result); 
      echo $row['seatsNumber'];
      $_POST['prevResult'] = $row;

  }
  $editAccess = $user === $_GET['Owner'] || $admin === true;
  if(!$editAccess) {
    echo "<p class='form-control-static'> This post is owned by " . $_GET['Owner'] . ". Please contact them about editing this listing </p>" ;
  }
  $disabled = !$editAccess ? 'disabled' : '';
  $hidden = !$editAccess ? 'hidden': 'submit';
  if (!isset($_POST['submit'])) {
    echo "
  <ul>
    <form class='form-horizontal' name='display' method='POST' >
    <input visibility: hidden name='owner' value =$owner>
    <input visibility: hidden name='seats' value =$seats>
    <input visibility: hidden name='start' value =$start>
    <input visibility: hidden name='dest' value =$dest>
    <input visibility: hidden name='depdate' value =$depdate>
    <input visibility: hidden name='deptime' value =$deptime>

    <div class='form-group'>
      <label for='username' class='col-sm-2 control-label'>Owner</label>
      <div class='col-sm-10'>
        <input class='form-control' id='username' name='username' value=$owner type='text' $disabled>
      </div>
    </div>
    <div class='form-group'>
      <label for='seatsNumber' class='col-sm-2 control-label'>Seats</label>
      <div class='col-sm-10 '>
        <input class='form-control' id='seatsNumber' name='seatsNumber' value=$seats type='text' $disabled>
      </div>
    </div>
    <div class='form-group'>
      <label for='start_loc' class='col-sm-2 control-label'>Start Location</label>
      <div class='col-sm-10'>
        <input class='form-control' id='start_loc' name='start_loc' value=$start type='text' $disabled>
      </div>
    </div>
    <div class='form-group'>
      <label for='end_loc' class='col-sm-2 control-label'>End Location</label>
      <div class='col-sm-10'>
        <input class='form-control' id='end_loc' name='end_loc' value=$dest type='text' $disabled>
      </div>
    </div>
    <div class='form-group'>
      <label for='date' class='col-sm-2 control-label'>Date</label>
      <div class='col-sm-10'>
        <input class='form-control' id='date' name='date' value=$depdate type='text' $disabled>
      </div>
    </div>
    <div class='form-group'>
      <label for='starttime' class='col-sm-2 control-label'>Departure Time</label>
      <div class='col-sm-10'>
        <input class='form-control' id='starttime' name='starttime' value=$deptime type='text' $disabled>
      </div>
    </div>
    <div class='form-group'>
      <label for='submit' class='col-sm-2 control-label'>Departure Time</label>
      <div class='col-sm-10'>
        <input class='form-control' id='submit' name='submit' value=Submit Edit type='Submit' $disabled>
      </div>
    </div>    
    </form>
  </ul>";
}
  
        // Connect to the database. Please change the password in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234"); 
      if ($db){
        /*echo $_POST[username];
        echo $_POST[seatsNumber];
        echo $_POST[start_loc];
        echo $_POST[end_loc];
        echo $_POST[date];
        echo $_POST[starttime];*/

      }

      if (isset($_POST['submit'])) {
          echo "Updating Listing\n";
          echo "<p></p>";
          echo $_POST['username']."\n";
          echo $_POST['seatsNumber']."\n";
          echo $_POST['start_loc']."\n";
          echo $_POST['end_loc']."\n";
          echo $_POST['date']."\n";
          echo $_POST['starttime']."\n";

          $owner = trim($_POST['owner']);
          $start = trim($_POST['start']);
          $dest = trim($_POST['dest']);
          $depdate = trim($_POST['depdate']);
          $deptime = trim($_POST['deptime']);
          $seats = trim($_POST['seats']);

          echo "<p></p>";
          echo $owner."\n";
          echo $seats."\n";
          echo $start."\n";
          echo $dest."\n";
          echo $depdate."\n";
          echo $deptime."\n";
          echo "<p></p>";

          $result = pg_query($db, 
          "UPDATE User_Post
           SET Owner = '$_POST[username]',
            Seats = '$_POST[seatsNumber]',
            Start = '$_POST[start_loc]',
            Dest = '$_POST[end_loc]',
            depDate = '$_POST[date]',
            depTime = '$_POST[starttime]'
           WHERE 
            Owner = '$owner' AND
            Seats = '$seats' AND
            Start = '$start' AND
            Dest = '$dest' AND
            depDate = '$depdate' AND
            depTime = '$deptime'
           ");

          if(pg_affected_rows($result) > 0) {
            echo "Updated Successfully!";
          }
          else {
            echo "Update Failed!";
          }
      }
          
  ?>
  </body>
</html>