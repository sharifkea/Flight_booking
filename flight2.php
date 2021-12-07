
<?php
require ('db.php');
require ('config.php');
include("auth.php");
//print_r($_SESSION);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to Flight Booking</title>
	</head>
	<body>
		<p>Welcome <?php echo $_SESSION['username']; ?>!</p>
		<?php
			$y =0;
			$x = array();
		?>
		<form method="post">
			<h3>All passanger name<h3> 
			<?php
			for ($y=1;$y<=($_SESSION['pn']);$y++){
		
			?><tr class="tablerow">
			<td align="right">Passanger Name <?php echo $y;?></td>
			<td><input type="text" name="userName[<?php echo $y;?>]" value="<?php if(isset($_POST['userName'][$y])) echo $_POST['userName'][$y]; ?>"></td>
			</tr><br>

			<?php 
			}?>
			<input type="submit"  name="sub" value="Submit"/>
			<p></p>
		</form>
		<?php
			if(isset($_POST['userName']))
				{$y=0;
				foreach($_POST['userName'] as $key =>$value){
					$y++;
					$x[$y-1]= $_POST['userName'][$y];
				}
				for ($z=0;$z<=($y-1);$z++){
					$_SESSION["passanger"][$z]="'".$x[$z]."'";
					//echo $_SESSION["passanger"][$z]."<br>";
				}
				$_SESSION["atp"] = $_SESSION["tp"]*$_SESSION["pn"];
				echo "Total Price for ".$y." passanger(s): ".($_SESSION["atp"]);
		?>
				<form action = "submit.php" method = "post">
					<script src="https://checkout.stripe.com/checkout.js" class = "stripe-button"
						data-key = "<?php echo $PublishableKey?>"
						data-amount = "<?php echo ($_SESSION["atp"]*100)?>"
						data-name = "Flight Booking"
						data-description ="Online air ticket booking"
						data-image ="https://icons.iconarchive.com/icons/itzikgur/my-seven/96/Travel-Airplane-icon.png"
						data-currency = "dkk"
						data-email = "<?php echo $_SESSION["email"]?>">
					</script>
				</form><?php	
			}
		?>
		
		<p><a href="index.php">Home</a></p>
		<a href="logout.php">Logout</a>
	</body>
</html>
		