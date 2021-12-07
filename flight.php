<?php
include("auth.php");
require('db.php');
//print_r($_SESSION);
$pn="'".$_SESSION["pn"]."'";
$from=$_SESSION['from'];
$to=$_SESSION['to'];
$date1=$_SESSION['date1'];
$date2=$_SESSION['date2'];
$bc="'".$_SESSION['bc']."'";

	
?>

<!DOCTYPE html>
<html>
	<head>
		<form name="chooseFlight" action="" method="post">
			
				<tr class="tablerow">
						<td align="right">Journey<?php echo "<br>";?></td>
					<?php
					$j = 0;
					$r = 0;
					$jid = array();
					$rid = array();
					$jprice = array();
					$rprice = array();
						
					if($bc==1) {
						$sqla = "call Find_Flight_BC($date1,$from,$to,$pn)";
						$resulta = $con->query($sqla);
						if ($resulta->num_rows > 0) {
						while($rowa = $resulta->fetch_assoc()) {
							$j++;
							$jid[$j]=$rowa['id']; 
							$jprice[$j]=$rowa['BusinessClassPrice'];
							
							?>
							<td><input type="radio" name="j1" value="<?php echo $j?>" checked> <?php echo "Flight No.: ".$rowa['planID'].",Airlines Name : ".$rowa['AirlinesName'].", Aricraft Name: ".$rowa['AricraftName'].", Date: ".$rowa['date'].",Departure From : ".$rowa['Departure_From'].",Arrival To : ".$rowa['Arrival_To']
							.",Departure Time : ".$rowa['DepartureTime'].",Arrival Time : ".$rowa['ArrivalTime'].", Price: ".$rowa['BusinessClassPrice']."<br>";
					}}}	
					else {
						$sqla = "call Find_Flight_EC($date1,$from,$to,$pn)";
						
						$resulta = $con->query($sqla);
						if ($resulta->num_rows > 0) {
						while($rowa = $resulta->fetch_assoc()) {
							$j++;
							$jid[$j]=$rowa['id']; 
							$jprice[$j]=$rowa['EconomyClassPrice'];
							?>
							<td><input type="radio" name="j1" value="<?php echo $j?>" checked> <?php echo "Flight No.: ".$rowa['planID'].",Airlines Name : ".$rowa['AirlinesName'].", Aricraft Name: ".$rowa['AricraftName'].", Date: ".$rowa['date'].",Departure From : ".$rowa['Departure_From'].",Arrival To : ".$rowa['Arrival_To']
							.",Departure Time : ".$rowa['DepartureTime'].",Arrival Time : ".$rowa['ArrivalTime'].", Price: ".$rowa['EconomyClassPrice']."<br>";
					}}}
						?>
						</td>
					</tr>
					<?php
					$con->close();
					$con = mysqli_connect("localhost","root","rony2204","flight_booking");
					if (mysqli_connect_errno())
					  {
					  echo "Failed to connect to MySQL: " . mysqli_connect_error();
					  }
						  
						  
					if ($date2 !=='0'){
						?>
						<tr class="tablerow">
							<td align="right">Return<?php echo "<br>";?></td>
						<?php
						
							
						if($bc==1) {
							$sqla = "call Find_Flight_BC($date2,$to,$from,$pn)";
							$resulta = $con->query($sqla);
							if ($resulta->num_rows > 0) {
							while($rowa = $resulta->fetch_assoc()) {
								$r++;
								$rid[$r]=$rowa['id']; 
								$rprice[$r]=$rowa['BusinessClassPrice'];
								?>
							<td><input type="radio" name="r1" value="<?php echo $r?>" checked> <?php echo "Flight No.: ".$rowa['planID'].",Airlines Name : ".$rowa['AirlinesName'].", Aricraft Name: ".$rowa['AricraftName'].", Date: ".$rowa['date'].",Departure From : ".$rowa['Departure_From'].",Arrival To : ".$rowa['Arrival_To']
							.",Departure Time : ".$rowa['DepartureTime'].",Arrival Time : ".$rowa['ArrivalTime'].", Price: ".$rowa['BusinessClassPrice']."<br>";?>
							<?php
								
						}}}	
						else {
							$sqla = "call Find_Flight_EC($date2,$to,$from,$pn)";
							
							$resulta = $con->query($sqla);
							if ($resulta->num_rows > 0) {
							while($rowa = $resulta->fetch_assoc()) {
								$r++;
								$rid[$r]=$rowa['id']; 
								$rprice[$r]=$rowa['EconomyClassPrice'];
								?>
							<td><input type="radio" name="r1" value="<?php echo $r?>" checked> <?php echo "Flight No.: ".$rowa['planID'].",Airlines Name : ".$rowa['AirlinesName'].", Aricraft Name: ".$rowa['AricraftName'].", Date: ".$rowa['date'].",Departure From : ".$rowa['Departure_From'].",Arrival To : ".$rowa['Arrival_To']
							.",Departure Time : ".$rowa['DepartureTime'].",Arrival Time : ".$rowa['ArrivalTime'].", Price: ".$rowa['EconomyClassPrice']."<br>";?>
							<?php
							
					}}}
						?>
						</td>
					</tr>
					<?php
					}?>
					<tr class="tableheader">
						<input type="submit" name="Total" value="Booking">
					</tr>
				
			</form>
			
			<?php
$tp = 0;								
if ($date2 !=='0'){
	if (isset($_POST['j1'])){
		$_SESSION['rt']=1;
		$_SESSION['jid']=$jid[$_POST['j1']];
		$_SESSION['jprice']=$jprice[$_POST['j1']];
		$tp=$tp+$jprice[$_POST['j1']];
		if (isset($_POST['r1'])){ 
			$_SESSION['rid']=$rid[$_POST['r1']];
			$_SESSION['rprice']=$rprice[$_POST['r1']];
			$tp=$tp+$rprice[$_POST['r1']]; 
			$_SESSION['tp']=$tp;
			header("Location: flight2.php");
			end();
		}
	}
}else{
	if (isset($_POST['j1'])){
		$_SESSION['rt']=0;
		$_SESSION['jid']=$jid[$_POST['j1']];
		$_SESSION['jprice']=$jprice[$_POST['j1']];
		$tp=$tp+$jprice[$_POST['j1']];
		$_SESSION['tp']=$tp;
		header("Location: flight2.php");
		end();
	}	
}					
					
				
?>
			<p><a href="index.php">Home</a></p>
			<a href="logout.php">Logout</a>
		
	</body>
</html>