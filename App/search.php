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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  <style>li {list-style: none;}</style>
<head>
  <title>Search Listing</title>
</head>
<body>
  <?php
  include_once('../header.php');
  ?>

	<div class="container">
		<form name = 'search' action='/demo/App/search.php' method='POST'>
			<h1 class="display-4"> Find Listings By: </h1>
			<div class="form-group">
				<label for="adname">Driver</label>
				<input name="adname" type="text" class="form-control" placeholder="Enter username of driver." />
				<label for="adstartloc">Start</label>
				<input name="adstartloc" type="text" class="form-control" placeholder="Enter starting location." />
				<label for="adendloc">Destination</label>
				<input name="adendloc" type="text" class="form-control" placeholder="Enter destination." />
				<label> Range of dates accepted </label>
				
				<div class="row">
					<div class="col-sm">
						<input name="sdate" type="date" class="form-control" placeholder="Enter start date." />
					</div>
					<div class="col-sm">
						<input name="edate" type="date" class="form-control" placeholder="Enter end date." />
					</div>
				</div>
				
				<label>Range of times accepted</label>
				<div class="row">
					<div class="col-sm">
						<input name="stime" type="time" class="form-control" placeholder="Enter start time." />
					</div>
					<div class="col-sm">
						<input name="etime" type="time" class="form-control" placeholder="Enter end time." />
					</div>
				</div>
				<label for="number">Required Seats</label>
				<input name="seats" type="number" class="form-control" placeholder="Enter required seats." />	
				<button name="submit" type="submit" class="btn btn-primary">Submit</button>				
			</div>
		</form>
	</div>
		
	<?php
		try {
			search();
		} catch (Exception $e) {
			echo $e->getMessage() . " Please try again.";
		}
		
		function search() {
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
			
			if (isset($_POST[sdate]) != isset($_POST[edate])) { throw new exception("You must input both start date and end date."); }
			if (isset($_POST[stime]) != isset($_POST[etime])) { throw new exception("You must input both start time and end time."); }
			$filters = "";
			foreach ($keys as $id => $value) {
			  if ($value == null) { continue; }
			  if ($filters != "" && $id != 4 && $id != 6 ) { $filters.=' OR '; }
			  switch ($id) {
				case 0:
				  $relevance .= " (case when Owner = '$_POST[adname]'  then 1 else 0 end) +";
				  $filters .= " owner = '$_POST[adname]'";
				  break;

				case 1:
				  $relevance .= " (case when origin = '$_POST[adstartloc]'  then 1 else 0 end) +";
				  $filters.=" origin = '$_POST[adstartloc]'";
				  break;

				case 2:
				  $relevance .= " (case when destination = '$_POST[adendloc]'  then 1 else 0 end) +";
				  $filters.=" Destination = '$_POST[adendloc]'";
				  break;

				case 3:
				  $relevance .= " (case when depart_Date BETWEEN '$_POST[sdate]'";
				  $filters.=" depart_date BETWEEN '$_POST[sdate]'";
				  break;

				case 4:
				  $relevance .= " AND '$_POST[edate]' then 1 else 0 end) +";
				  $filters.=" AND '$_POST[edate]'";
				  break;

				case 5:
				  $relevance .= " (case when depart_time BETWEEN '$_POST[stime]'";
				  $filters.=" depart_time BETWEEN '$_POST[stime]'";
				  break;

				case 6:
				  $relevance .= " AND '$_POST[etime]' then 1 else 0 end) +";
				  $filters.=" AND '$_POST[etime]'";
				  break;


				case 7:
				  $relevance .= " (case when seats_available-coalesce(relevant_bid.total_seats_desired,0) >= '$_POST[seats]' then 1 else 0 end) +";
				  $filters.=" seats_available-coalesce(relevant_bid.total_seats_desired,0) >= '$_POST[seats]'";
				  break;
			  }
			}

			$relevance = rtrim($relevance, " +");
			$query = 	"
							SELECT
							p.owner,
							p.origin,
							p.destination,
							p.depart_date,
							p.depart_time,
							p.seats_available - coalesce(relevant_bid.total_seats_desired,0) as seats," . $relevance . " as relevance 
							FROM post p NATURAL LEFT OUTER JOIN (SELECT
							b.owner,
							b.origin,
							b.destination,
							b.depart_date,
							b.depart_time,
							SUM(b.seats_desired) AS total_seats_desired
							FROM bid b
							WHERE b.accepted = 'true'
							GROUP BY
							b.owner,
							b.origin,
							b.destination,
							b.depart_date,
							b.depart_time
							) As relevant_bid
							WHERE " . $filters . "ORDER BY relevance DESC"
							;
			$result = pg_query($db, $query);      
			echo "         
			<table class='table'>
			<thead>
          <tr>
            <th scope='col'>License Plate</th>
            <th scope='col'>Driver</th>
            <th scope='col'>Seats</th>
            <th scope='col'>Begin Location</th>
            <th scope='col'>End Location</th>
            <th scope='col'>Departure Date</th>
            <th scope='col'>Departure Time</th>
            <th scope='col'></th>

          </tr>
        </thead>
        <tbody>";
			if (isset($_POST['submit'])) {
			  while ($row = pg_fetch_array($result)) { 
            echo "


            <form action='../Ads/profile.php' method = 'POST'>
                <tr>
    							<td> $row[license_plate] </td>
    							<td> $row[owner] </td>
                  <td> $row[seats_available] </td>
                  <td> $row[origin] </td>
                  <td> $row[destination] </td>
                  <td> $row[depart_date] </td>
                  <td> $row[depart_time] </td>
                  <td> <button name='submit' type='submit' class='btn btn-primary'>View More</button> </td>

                  <input hidden name='license_plate' value = $row[license_plate]>
                  <input hidden name='owner' value = $row[owner]>
                  <input hidden name='seats_available' value = $row[seats_available]>
                  <input hidden name='origin' value = $row[origin]>
                  <input hidden name='destination' value = $row[destination]>
                  <input hidden name='depart_date' value = $row[depart_date]>
                  <input hidden name='depart_time' value = $row[depart_time]>
                </tr>
            </form>
          ";
            $count = $count + 1;
				}  
				echo "</tbody></table>";
			}
		  } else {
			echo "Connection failed";
		  }
		}
	
	 ?>			
</body>
</html>