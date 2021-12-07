
<?php
include("auth.php");
?>
<html>
	<center>
		<head>
			<font size="22">Flight Booking </font>
			<title>Home</title>
		</head>
		<body>
			<div class="form">
				<p>Welcome <?php echo $_SESSION['username']; ?>!</p>
				<p>This is secure area.</p>
				<p><a href="seeTickets.php">See Tickets</a></p>
				<p><a href="searchFlight.php">Search New Flight</a></p>
				<a href="logout.php">Logout</a>
			</div>
		</body>
	</center>
</html>