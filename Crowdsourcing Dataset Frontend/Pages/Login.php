<?php include('../../config/server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Login Page
	</title>
	
	<link rel="stylesheet" type="text/css"
			href="style.css">
</head>
<body>
	<div class="header">
		<h2>Login</h2>
	</div>
	
	<form method="post" action="Login.php">

		<?php include('../../config/errors.php'); ?>

		<div class="input-group">
			<label>Enter Username</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>Enter Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn"
						name="login_user">
				Login
			</button>
		</div>
		


<p>
			New Here?
			<a href="Register.php">
				Click here to register!
			</a>
		</p>



	</form>
</body>

</html>


