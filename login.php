<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
	</head>
	<body>
		<?php
			require('db.php');
			session_start();
			if (isset($_POST['email'])){
			 $email = stripslashes($_REQUEST['email']);
			 $email = mysqli_real_escape_string($con,$email);
			 $password = stripslashes($_REQUEST['password']);
			 $password = mysqli_real_escape_string($con,$password);
			 $query = "SELECT * FROM `users` WHERE email='$email'
			 and password='".md5($password)."'";
			 $result = mysqli_query($con,$query) or die(mysql_error());
			 $rows = mysqli_num_rows($result);
			 
				if($rows==1){
					$row = $result->fetch_assoc();
					$_SESSION['email'] = $row['email'];
					$_SESSION['userid'] = $row['id'];
					$_SESSION['username'] = $row['username'];
				 header("Location: index.php");
				}else{
				 echo "<div class='form'>
				<h3>E-Mail/Password is incorrect.$</h3>
				<?php

				?>
				<br/>Click here to <a href='login.php'>Login</a></div>";
				}
			}else{

		?>
		<div class="form">
			<h1>Welcome To Flight Booking</h1>
			<h2>Log In</h2>
			<form action="" method="post" name="login">
				<input type="email" name="email" placeholder="E-Mail" required />
				<input type="password" name="password" placeholder="Password" required />
				<input name="submit" type="submit" value="Login" />
			</form>
			<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
		</div>
		<?php } ?>
	</body>
</html>