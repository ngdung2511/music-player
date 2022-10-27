<!DOCTYPE html>
<html>
<head>
	<title>REGISTER</title>
	<link rel="stylesheet" type="text/css" href="general_page.css">
</head>
<body>
     <form action="register.php" method="post">
     	<h2>REGISTER</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
     	<label>Username</label>
     	<input type="text" name="username" placeholder="Your username" required><br>

     	<label>Password</label>
     	<input type="password" name="password" placeholder="Password" required><br>

        <label>Confirm password</label>
     	<input type="password" name="confirm-password" placeholder="Confirm password" required><br>

     	<button type="submit">Register</button>
     </form>
</body>
</html>