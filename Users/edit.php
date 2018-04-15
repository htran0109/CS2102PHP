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
  <title>Edit Profile</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
</head>
<body>
  <?php
    include_once('../header.php');
  ?>
  <div class="container-fluid">
    <h1 class="display-4"> <?php if (isset($_POST["Owner"])) echo $_POST["Owner"] . "'s"; else echo "My"; ?> Profile </h1>
  <div class="form-group">
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
    </dl>
    <dl class="row">  
      <div class="form-check">
      <input class="form-check-input" type="checkbox" id="ownCar" name="ownCar">
        <label class="form-check-label" for="ownCar">
          I'd like to add a car
        </label>

      </div>
    </dl>
    
    <dl class="row">
      <div id = "carInfo" style="display:none">
        <label for="license_plate">License Plate</label>
        <input name="license_plate" type="text" class="form-control" placeholder="Enter your car's license plate" />
        <label for="model">Model</label>
        <input name="model" type="text" class="form-control" placeholder="Enter your car model e.g. Toyota, Honda, etc." />
        <label for="make">Make</label>
        <input name="make" type="text" class="form-control" placeholder="Enter your car make e.g. Corolla, Civic, etc." />
        <label for="color">Color</label>
        <input name="color" type="text" class="form-control" placeholder="Enter your car color" />
        <label for="total_seats">Seats</label>
        <input name="total_seats" type="number" class="form-control" placeholder="Enter total seats available" />
      </div>
    </dl>
    </div>
      <input class='btn ml-1' id='submit' name='submit' value=Submit Edit type='submit'>
  </form>
    <?php 
    $url = "../Users/profile.php?Owner=$username";
        echo "
      <div style='float:left'>
      <form action='$url'>
      <input type='submit' class='btn'
        value='Back'/>
      </form></div>";
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
          $db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");

          $mobile = trim($_POST['mobile']);
          $email = trim($_POST['email']);

          $license_plate = trim($_POST['license_plate']);
          $model = trim($_POST['model']);
          $make = trim($_POST['make']);
          $color = trim($_POST['color']);
          $total_seats = trim($_POST['total_seats']);
          // echo "<p></p>";
          // echo $owner."\n";
          // echo $seats."\n";
          // echo $start."\n";
          // echo $dest."\n";
          // echo $depdate."\n";
          // echo $deptime."\n";
          // echo "<p></p>";

          $result = pg_query($db, 
          "UPDATE profile
           SET mobile_number = '$_POST[mobile]',
            email = '$_POST[email]'
           WHERE 
            username = '$username';
           ");
          $carInsert = true;
          if(isset($_POST['ownCar'])) 
          {
                $db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
                $result2 = pg_query($db, "SELECT * FROM car;");
                pg_query($db, "INSERT INTO car (license_plate, total_seats, color, model, make, username) VALUES('$license_plate', '$total_seats', '$color', '$model', '$make', '$username');");
                $result3 = pg_query($db, "SELECT * FROM car;");
                if (pg_num_rows($result3) <= pg_num_rows($result2)) {
                  $carInsert = false;
                  $error = pg_last_error($db);
                  echo $error;
                  $error = preg_replace("/ERROR: /i","",$error);
                  $error = preg_replace("/CONTEXT: .*/","",$error);
                  echo $error;
                  echo "<p style='color:red'>Car not added; Please ensure all fields are filled out, and that you are 18 years or older</p>";
                }
          }
          if(pg_affected_rows($result) > 0 && $carInsert) {
            header("Location:profile.php");
            exit();
          }
          else {
            echo pg_last_error($db);
            echo $error;
            $error = preg_replace("/ERROR: /i","",$error);
            $error = preg_replace("/CONTEXT: .*/","",$error);
            echo $error; 
            echo "<p style='color:red'>User profile unchanged due to error in fields</p>";
          }
      }
      ?>
  <script>
  ownCar.addEventListener( 'change', function() {
    if(this.checked) {
        document.getElementById("carInfo").style.display="block";
    } else {
        document.getElementById("carInfo").style.display="none";
    }
  });

  </script>
</body>
</html>
