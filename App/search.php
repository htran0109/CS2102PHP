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
	<div class="container">
		<form name = 'search' action='http://localhost/demo/App/search.php' method='POST'>
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
				<input name="number" type="number" class="form-control" placeholder="Enter required seats." />	
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
			  while ($row = pg_fetch_array($result)) { 

				if($count % 2 == 0) {
				echo "<a style='text-decoration:none' href='http://localhost/demo/Ads/profile.php?Owner=$row[owner]&Seats=$row[seats]&Start=$row[start]&Dest=$row[dest]&depDate=$row[depdate]&depTime=$row[deptime]'> 
				  <div class = 'container-fluid list-group-item' style='background-color:#c1badb'>  
					<div class='row'>
					<div class = 'col-sm' style='color:black'>Ad Owner: $row[owner]</div>
					<div class = 'col-sm' style='color:black'>Seats: $row[seats]</div>     
					<div class = 'col-sm' style='color:black'>Begin Location: $row[start]</div>
					<div class = 'col-sm' style='color:black'>End Location: $row[dest]</div>
					<div class = 'col-sm' style='color:black'>Departure Date: $row[depdate]</div>
					<div class = 'col-sm' style='color:black'>Departure Time: $row[deptime]</div>
				  </div>
				  </div>
				</a>";
				$count = $count + 1;
				}
				else {
				  echo "<a style='text-decoration:none' href='http://localhost/demo/Ads/profile.php?Owner=$row[owner]&Seats=$row[seats]&Start=$row[start]&Dest=$row[dest]&depDate=$row[depdate]&depTime=$row[deptime]'> 
				  <div class = 'container-fluid list-group-item' style='background-color:#efefef'>  
					<div class='row'>
					<div class = 'col-sm' style='color:black'>Ad Owner: $row[owner]</div>
					<div class = 'col-sm' style='color:black'>Seats: $row[seats]</div>     
					<div class = 'col-sm' style='color:black'>Begin Location: $row[start]</div>
					<div class = 'col-sm' style='color:black'>End Location: $row[dest]</div>
					<div class = 'col-sm' style='color:black'>Departure Date: $row[depdate]</div>
					<div class = 'col-sm' style='color:black'>Departure Time: $row[deptime]</div>
				  </div>
				  </div>
				</a>";
				$count = $count + 1;
				}
			  }
			}
		  } else {
			echo "Connection failed";
		  }
		}
		 ?>			
</body>
</html>