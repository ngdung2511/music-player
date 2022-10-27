<!DOCTYPE html>
<html>

<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="general_page.css">
</head>	

<body>
	<form class="login_form" action="login.php" method="post">
		<h2>LOGIN</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>Username</label>
		<input type="text" name="uname" placeholder="Your username"><br>

		<label>Password</label>
		<input type="password" name="password" placeholder="Password"><br>
		<button type="submit">Login</button>
	</form>
	<form class="register_form" action="register_page.php">
		<h2>Don't have an account yet?</h2>
		<button>Register</button>
	</form>
</body>

</html>