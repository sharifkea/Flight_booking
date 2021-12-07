<?php
	include("auth.php");
	//session_start();
	require('db.php');
	$query = "SELECT `id` FROM `airports`" ;
	$result = mysqli_query($con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	$x =array();
	$y = 0;

	if(isset($_POST['submit'])){
		$_SESSION["pn"] =$_POST['passengerNumber'];
		$_SESSION['from'] = "'".$_POST['from']."'";
		$_SESSION['to']= "'".$_POST['to']."'";
		$_SESSION['date1']="'".$_POST['date1']."'";
		if ($_POST['date2']!==''){
			$_SESSION['date2'] ="'".$_POST['date2']."'";
		}
		else{
			$_SESSION['date2'] ='0';
		}
		if($_POST['class']=="Business") {
			$_SESSION['bc']=1;
		} else {
			$_SESSION['bc']=0;
		}
		header("Location: flight.php");
		exit(); 
	}
?>	
<html>
<center>
	<head>
		
			<font size="22">Flight Booking </font>
			<title>Search New Flight</title>
		
	</head>
	<body>
		<div class="form">
			<p>Search New Flight</p>
			<form name="SearcFlight" method="post" action="">
				<div align="center" class="message"><?php if(isset($message)) echo $message; ?></div>
				<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
					<tr class="tableheader">
						<td align="center" colspan="2">Select your journey</td>
					</tr>
					<tr class="tablerow">
						<td align="right">Passenger Number</td>
						<td><input type="text" name="passengerNumber" value="<?php if(isset($_POST['passengerNumber'])) echo $_POST['passengerNumber']; ?>"></td>
					</tr>
					<tr class="tablerow">
						<td align="right">Aiprort From</td>
						<td>
							<select name="from">
								<option value="">--Select--</option>
								<?php
									if ($result->num_rows > 0) {
										while($row = $result->fetch_assoc()) {
											$x[$y]=$row['id'];
								?>
								<option value="<?php echo $x[$y]?>"  <?php if(isset($_POST['from']) && $_POST['from']==$x[$y]) { ?>selected<?php  } ?>><?php echo $x[$y]?></option>
								<?php $y++; }}?>
							</select>
						</td>
					</tr>
					<tr class="tablerow">
						<td align="right">Aiprort To</td>
						<td>
							<select name="to">
								<option value="">--Select--</option>
								<?php
									for ($z = 0; $z <count($x); $z++){
								?>
								<option value="<?php echo $x[$z]?>"  <?php if(isset($_POST['to']) && $_POST['to']==$x[$z]) { ?>selected<?php  } ?>><?php echo $x[$z]?></option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr class="col-sm-5">
						<tr class="form-group">
							<td class="form-label">Journey Date</td>
							<td><input class="form-section" type="date" name="date1"  required></td>
						</tr>
					</tr>
					<tr class="col-sm-5">
						<tr class="form-group">
							<td class="form-label">Return Date (If)</td>
							<td><input class="form-section" type="date" name="date2"></td>
						</tr>
					</tr>
					<tr class="tablerow">
						<td align="right">Class</td>
						<td><input type="radio" name="class" value="Business" checked> Business
							<input type="radio" name="class" value="Economy" checked> Economy
						</td>
					</tr>
					<tr class="tableheader">
						<td align="center" colspan="2"><input type="submit" name="submit" value="Submit"></td>
					</tr>
				</table>
			</form>
			<p><a href="index.php">Home</a></p>
			<a href="logout.php">Logout</a>
		</div>
	</body>
	</center>
</html>