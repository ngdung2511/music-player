<!DOCTYPE html>
<html>

<?php
include "db_conn.php";
session_start();
$userID = $_SESSION['id'];

if ($userID == null) {
	header("Location: login_page.php?error=Please log in first");
} else {
	$songId = $_GET['id'];
	$sql = "SELECT * FROM audios WHERE id= $songId";

	$result = mysqli_query($conn, $sql);

	if ($result) {
		$row = mysqli_fetch_assoc($result);
		$songName = $row['name'];
		$author = $row['author_name'];
	}
}
?>

<head>
	<title>Edit your song</title>
	<link rel="stylesheet" type="text/css" href="general_page.css">
</head>

<body>
	<form class="edit_form" action="handleEdit.php" method="post">
		<h2>Edit your music info</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
		<label>Name of song</label>
		<input type="text" name="my_audio" placeholder="Edit Song Name" value="<?php global $songName;
		echo $songName; ?>" required>
		<label>Author</label>
		<input type="text" name="author" placeholder="Edit Song Author" value="<?php global $author;
		echo $author; ?>"
		required>
		<input type="hidden" name="id" id="id" value="<?php echo $songId ?>">
		<input style="cursor: pointer;" type="submit" value="Change" name="submit">
	</form>
</body>

</html>