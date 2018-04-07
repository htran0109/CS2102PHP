<?PHP
	include('viewAd.php');
	//$bidder = $_SESSION["username"];
	$bidder = 'joe';
	$customers = $_POST['customers'];
		
	if ((int)$customers > (int)$seats) {
		echo "<script type='text/javascript'> 
			document.getElementById('errorMessage').innerHTML = 'Not enough seats available.';
		</script>";
	}
	
	pg_query($db, "INSERT INTO Bid(Bidder, Owner, Start, Dest, depDate, depTime, Customers) VALUES('$bidder', '$owner', '$start', '$dest', '$depdate', '$deptime', '$customers');"); 
	
?>
