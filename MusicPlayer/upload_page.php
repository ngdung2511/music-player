<!DOCTYPE html>
<html>
<?php
include "db_conn.php";
session_start(); 
$userID = $_SESSION['id'];
if($userID == null) {
  header("Location: login_page.php?error=Please log in first");
}
else
{ 
}
?>
<head>
	<title>Upload your song</title>
	<link rel="stylesheet" type="text/css" href="login_register_page.css">
</head>	

<body>
	<form class="upload_form" action="upload.php" method="post" enctype="multipart/form-data">
		<h2>Upload your music</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>Name of song</label>
		<input type="text" name="my_audio" placeholder="Song Name">
		<label>Author</label>
		<input type="text" name="author" placeholder="Song Author">

		<label>Song file</label>
        <input name="audioFile" type="file" />

        <label>Song thumbnail</label>
        <input name="audioThumb" type="file" />
        <input style="cursor: pointer;" type="submit" value="Upload" name="submit" />
    </form>
</body>

</html>