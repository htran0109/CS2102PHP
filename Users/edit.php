<?PHP
  session_start();
  
  if (empty($_SESSION["username"])){
    echo "<script type='text/javascript'> 
    alert('You are not logged in. You will be redirected to the login page.');
    window.location.href = 'index.php';
    </script>";
  }
  $username = $_SESSION["username"];
  $db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
  $user = pg_fetch_array(pg_query($db, "SELECT * FROM profile where username='$username';"));
  
?>

<!DOCTYPE html>  
<head>
  <title>View Advertisement</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>
  <?php
    include_once('../header.php');
  ?>
  <div class="container-fluid">
    <h1 class="display-4"> <?php if (isset($_GET["Owner"])) echo $_GET["Owner"] . "'s"; else echo "My"; ?> Profile </h1>
  <form name='display' method='POST'>
    <dl class="row">
      <dt class="col-sm-3">User Name</dt>
      <dd class="col-sm-9"> <?php echo $username; ?> </dd>
      <dt class="col-sm-3">Real Name</dt>
      <dd class="col-sm-9"> <?php echo $user['first_name'] . ' ' . $user['last_name']; ?> </dd>
      <dt class="col-sm-3">Mobile Number</dt>
      <input class='form-control' id='mobile' name='mobile' value= <?php echo $user['mobile_number']?> type='text'>
      <dt class="col-sm-3">Email Address</dt>
      <input class='form-control' id='email' name='email' value= <?php echo $user['email']?> type='text'>
      <dt class="col-sm-3">Date of Birth</dt>
      <dd class="col-sm-9"> <?php echo $user['birthday']; ?> </dd>
      <input class='btn mr-1' id='submit' name='submit' value=Submit Edit type='submit'>
  </form>
    <?php 
    $url = "../Users/profile.php?Owner=$username";
    echo "
      <button type='submit' class='btn'>
        <a href=$url style='text-decoration:none;color:black'>Back</a>
      </button>";
    ?>
  </div>
  <?php
  if (isset($_POST['submit'])) {
          // echo "Updating Listing\n";
          // echo "<p></p>";
          // echo $_POST['username']."\n";
          // echo $_POST['seatsNumber']."\n";
          // echo $_POST['start_loc']."\n";
          // echo $_POST['end_loc']."\n";
          // echo $_POST['date']."\n";
          // echo $_POST['starttime']."\n";

          $owner = trim($_POST['owner']);
          $start = trim($_POST['start']);
          $dest = trim($_POST['dest']);
          $depdate = trim($_POST['depdate']);
          $deptime = trim($_POST['deptime']);
          $seats = trim($_POST['seats']);

          // echo "<p></p>";
          // echo $owner."\n";
          // echo $seats."\n";
          // echo $start."\n";
          // echo $dest."\n";
          // echo $depdate."\n";
          // echo $deptime."\n";
          // echo "<p></p>";

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
            header("Location:profile.php?Owner=$_POST[username]&Seats=$_POST[seatsNumber]&Start=$_POST[start_loc]&Dest=$_POST[end_loc]&depDate=$_POST[date]&depTime=$_POST[starttime]");
            exit();
          }
          else {
            echo "Update Failed!";
          }
      }
      ?>
</body>
</html>
