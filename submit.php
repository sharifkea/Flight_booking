<html>
	<head>
		<title>Welcome to Flight Booking</title>
	</head>
	<body>
<?php
include("db.php");
include("auth.php");
require ('config.php');		

if(isset($_POST ['stripeToken'])){
	$bc ="'".$_SESSION["bc"]."'";
	$jid ="'".$_SESSION["jid"]."'";
	$rid ="'".$_SESSION["rid"]."'";
	$pn ="'".$_SESSION["pn"]."'";
	$con->query("set transaction isolation level REPEATABLE READ");
	$con->begin_transaction();
	$qa = "call dec_seat_flight(".$jid.",".$pn.",".$bc.")";
	$qb = "call dec_seat_flight(".$rid.",".$pn.",".$bc.")";	
	if($_SESSION["rt"]==1){
		$resulta = $con->query($qa);
		$resultb = $con->query($qb);
	}else {
		$resulta = $con->query($qa);
	}
	$con->commit();
	$token = $_POST ['stripeToken'];
	$data = \Stripe\Charge::create(array(
		'amount' => $_SESSION["atp"]*100,
		'description' =>"Online air ticket booking",
		'currency' => "dkk",
		'source'=> $token,
	));

	$datab = $data->source;
	
	$paymentid="'".$data->id."'";
	$brand="'".$datab->brand."'";
	$last4="'".$datab->last4."'";
	
	$userid="'".$_SESSION["userid"]."'";
	$atp ="'".$_SESSION["atp"]."'";
	$jprice ="'".$_SESSION["jprice"]."'";
	$rprice ="'".$_SESSION["rprice"]."'";
	
	$sqlbking= "call insert_booking(".$userid.",".$pn.",".$_SESSION["date1"].",".$_SESSION["date2"].",".$bc.",".$paymentid.",".$brand.",".$last4.",".$atp.")";	
	$resultbk = $con->query($sqlbking);
	$row = $resultbk->fetch_assoc();
	echo "Transfer Successful.<br>Thank you for purchase.<br>Your booking ID is:".$row["BookingID"]."<br> Your tranfer details <br>";
	echo "Transfer ID: ".$paymentid."<br>Card: ".$brand."<br>Last 4 degite of Your card: ".$last4."Total amount Charged: ".$atp."dkk.";
	//$con->commit();
	$con->close();
	$conn = mysqli_connect("localhost","root","rony2204","flight_booking");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	//$conn->begin_transaction();				  
	for($y=0;$y<=$_SESSION["pn"]-1;$y++){
		$sqlpb = "INSERT INTO passengerbooking (BookingID,passengerName)
		VALUES ('".$row["BookingID"]."',".$_SESSION["passanger"][$y].")";
		if (mysqli_query($conn, $sqlpb)) {
			$last_id = mysqli_insert_id($conn);
			if($_SESSION["rt"]==1){
				$sqlitj ="call insert_ticket(".$jid.",".$last_id.",".$jprice.",".$bc.")";
				$resultitj = $conn->query($sqlitj);
				$sqlitr ="call insert_ticket(".$rid.",".$last_id.",".$rprice.",".$bc.")";
				$resultitr = $conn->query($sqlitr);
			}else{
				$sqlitj ="call insert_ticket(".$jid.",".$last_id.",".$jprice.",".$bc.")";
				$resultitj = $conn->query($sqlitj);
			}
		} else {
			echo "Error: " . $sqlpb . "<br>" . mysqli_error($conn);
			//$conn->rollback();
			//$conn->close();
		}
		//$conn->commit();
		//$conn->close();
		
	}
	
}
else{
	echo "Something went wrong. Please try again later.";
}

?>

		<p><a href="index.php">Home</a></p>
		<a href="logout.php">Logout</a>
	</body>
</html>

