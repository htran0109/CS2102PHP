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

    <div class="container">
      <h1 class="display-4"> My Bids </h1>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Driver</th>
            <th scope="col">Seats</th>
            <th scope="col">Begin Location</th>
            <th scope="col">End Location</th>
            <th scope="col">Departure Date</th>
            <th scope="col">Departure Time</th>
            <th scope="col"></th>

          </tr>
        </thead>
        <tbody>
          <?php

          $user = $_SESSION["username"];
          $db     = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=1234");
          $result = pg_query($db, "SELECT * FROM bid WHERE bidder = '$user';");    // Query template
          $count = 0;
          while ($row = pg_fetch_array($result)) {
            echo "
            <form action='profile.php' method = 'POST'>
                <tr>
                  <td> $row[owner] </td>
                  <td> $row[seats_desired] </td>
                  <td> $row[origin] </td>
                  <td> $row[destination] </td>
                  <td> $row[depart_date] </td>
                  <td> $row[depart_time] </td>
                  <td> <button name='submit' type='submit' class='btn btn-primary'>View More</button> </td>

                  <input hidden name='owner' value = $row[owner]>
                  <input hidden name='seats_desired' value = $row[seats_desired]>
                  <input hidden name='origin' value = $row[origin]>
                  <input hidden name='destination' value = $row[destination]>
                  <input hidden name='depart_date' value = $row[depart_date]>
                  <input hidden name='depart_time' value = $row[depart_time]>
                </tr>
            </form>";
            $count = $count + 1;
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="container">
      <h1 class="display-4"> Manage Bids on My Listings</h1>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Bidder</th>
            <th scope="col">Seats</th>
            <th scope="col">Begin Location</th>
            <th scope="col">End Location</th>
            <th scope="col">Departure Date</th>
            <th scope="col">Departure Time</th>
            <th scope="col"></th>

          </tr>
        </thead>
        <tbody>
          <?php

          $result = pg_query($db, "SELECT * FROM bid WHERE owner = '$user';");    // Query template
          $count = 0;
          while ($row = pg_fetch_array($result)) {
            echo "
            <form action='profile.php' method = 'POST'>
                <tr>
                  <td> $row[bidder] </td>
                  <td> $row[seats_desired] </td>
                  <td> $row[origin] </td>
                  <td> $row[destination] </td>
                  <td> $row[depart_date] </td>
                  <td> $row[depart_time] </td>
                  <td> <button name='submit' type='submit' class='btn btn-primary'>View More</button> </td>

                  <input hidden name='owner' value = $row[bidder]>
                  <input hidden name='seats_desired' value = $row[seats_desired]>
                  <input hidden name='origin' value = $row[origin]>
                  <input hidden name='destination' value = $row[destination]>
                  <input hidden name='depart_date' value = $row[depart_date]>
                  <input hidden name='depart_time' value = $row[depart_time]>
                </tr>
            </form>";
            $count = $count + 1;
          }
          ?>
        </tbody>
      </table>
    </div>

  </body>
</html>
