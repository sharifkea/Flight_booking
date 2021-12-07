<?php
	include("auth.php");
	require('db.php');
	$query = "SELECT b.id As BookingID FROM booking b JOIN users u ON u.id =b.userID and u.email='".$_SESSION['email']."';" ;
	$result = mysqli_query($con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	$x =array();
	$y = 0;
?>




<html>
	<head>
	</head>
	<body>
		<center>
			<font size="22">Flight Booking </font>
			<form method="post">
				<h3>All Tickets<h3>
				<table>					
					<tr class="tablerow">
						<td align="right">BookingID</td>
						<td>
							<select name="BookingID">
								<option value="">--Select--</option>
								<?php
									if ($result->num_rows > 0) {
										while($row = $result->fetch_assoc()) {
											$x[$y]=$row['BookingID'];
								?>
								<option value="<?php echo $x[$y]?>"  <?php if(isset($_POST['BookingID']) && $_POST['BookingID']==$x[$y]) { ?>selected<?php  } ?>><?php echo $x[$y]?></option>
								<?php $y++; }}?>
							</select>
						</td>
					</tr>
					<tr class="tableheader">
						<td align="center" colspan="2"><input type="submit" name="submit" value="Submit"></td>
					</tr>
				</table>
			</form>

		<?php
				
		if(isset($_POST['submit']))
		{
			$x="'".$_POST['BookingID']."'";			 
			echo "<br>";			
			$servername = "localhost";
			$username = "root";
			$password = "rony2204";
			$dbname = "flight_booking";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}
		$sql = "call All_tickets($x)";
		$result = $conn->query($sql);
		$y =0;
		$z = 0;
		$p =1;
		$class = " ";
		if ($result->num_rows > 0) {
			  
			while($row = $result->fetch_assoc()) {
				++$y; 
				if (($y % 2)==0) {
					echo "Return<br>";
			}else {
				echo "Passenger: ".$p."<br>";
				$p++;
			}if ($row["Class"]==0) {
				$row["Class"] = "Economy";
			}else {
				$row["Class"] ="Business";
			}  
			echo "BookingID: " . $row["BookingID"]. " - Ticket Num: " . $row["Ticket_Num"]."- Name: " . $row["PassengerName"]. " - AirlinesName: " . $row["AirlinesName"]. 
			" - Flight Num: " . $row["Flight_Num"]. " - Date: " . $row["date"]."<br> From: " . $row["Departure_From"]. " - To: " . $row["Arrival_To"]. " - Dep.Time: " . $row["DepartureTime"].
			" - Arr.Time: " . $row["ArrivalTime"]. " - Class: " . $row["Class"]." - Price: " . $row["price"]."<br>";
			$z=$z+$row["price"];
			
		  }
		} else {
			  echo "0 results";
			}
			echo "Total Price: ".$z;
			$conn->close();
			}
			?>

			<p><a href="index.php">Home</a></p>
			<a href="logout.php">Logout</a>
		</center>
	</body>
</html>