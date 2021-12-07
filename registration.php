
<html>
	<head>
		<meta charset="utf-8">
		<title>Registration</title>
	</head>
	<body>
		<?php
			require('db.php');
			if (isset($_REQUEST['email'])){
				
				$email = stripslashes($_REQUEST['email']);
				$email = mysqli_real_escape_string($con,$email);
				$query = "SELECT * FROM `users` WHERE email='$email'";
				$result = mysqli_query($con,$query) or die(mysql_error());
				$rows = mysqli_num_rows($result);
				
				if($rows==1){
					echo "<div class='form'>
					<h3>Your Email is allrady used.</h3>
					<br/>Click here to <a href='login.php'>Login</a>
					<p>Click here to go to registration again? <a href='registration.php'>Register</a></p>
					</div>";
				}
				else{
					$username = stripslashes($_REQUEST['username']);
					$username = mysqli_real_escape_string($con,$username); 
					$password = stripslashes($_REQUEST['password']);
					$password = mysqli_real_escape_string($con,$password);
					$query = "INSERT into `users` (username, email, password)
					VALUES ('$username', '$email', '".md5($password)."')";
					$result = mysqli_query($con,$query);
					
					
					if($result){
						echo "<div class='form'>
						<h3>You are registered successfully.</h3>
						<br/>Click here to <a href='login.php'>Login</a></div>";
					}
				}
			}else{
		?>
		<div class="form">
			<h1>Registration</h1>
			<form name="registration" action="" method="post">
				<input type="text" name="username" placeholder="Name" required />
				<input type="email" name="email" placeholder="Email" required />
				<input type="password" name="password" placeholder="Password" required />
				<input type="submit" name="submit" value="Register" />
			</form>
		</div>
		<?php } ?>
	</body>
</html>