<?php

include('functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Register</h2>
	</div>
	
	<form method="post" action="register1.php">
	<?php include('errors.php');
	?>

		

		<div class="input-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" value="<?php echo $username; ?>" >
		</div>
		<div class="input-group">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" value="<?php echo $email ; ?>" >
		</div>
		<div class="input-group">
			<label for="password">Password</label>
			<input type="password" name="password_1" id="password">
		</div>
		<div class="input-group">
			<label for="c_password">Confirm password</label>
			<input type="password" name="password_2" id="c_password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_user">Register</button>
		</div>
		<p>
			Already a member? <a href="login1.php">Sign in</a>
		</p>
	</form>
</body>
</html>