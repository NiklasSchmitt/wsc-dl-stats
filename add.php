<?php
include_once("config.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://unpkg.com/papercss@1.6.1/dist/paper.min.css">
	<title>Add Plugin | WSC DL-stats</title>
</head>
<body>
	<div class="paper container">
		<h2>Add WSC Plugin</h2>
		<p>
			<?php
			if (isset($_GET['error']) ) {
				echo "<div class='row flex-spaces'><div class='alert alert-danger'>Could not insert into plugins!</div></div>";
			}
			?>
			Here you can add a new WSC-Plugin for tracing download-stats.
		</p>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off">
			<div class="form-group">
				<p><label for="name">Name</label>
				<input type="text" placeholder="Name of plugin" id="name" name="name" required></p>
				<p><label for="pluginstore">Pluginstore-ID</label>
				<input type="text" placeholder="ID of Pluginstore-entry" id="pluginstore" name="pluginstore" required></p>
				<button class="btn-small btn-secondary" type="submit">Add Plugin</button>
			</div>
		</form>
		<p><a href="index.php" style="background-image:none;"><button class="btn-small btn-primary">Back</button></a></p>
		<?php

		if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty(validate_form_input($_POST['name'])) && !empty(validate_form_input($_POST['pluginstore'])) ) {
			$name = $_POST['name'];
			$pluginstore = $_POST['pluginstore'];

			$stmt2 = mysqli_prepare($mysqli, "INSERT INTO `plugins` (`name`, `pluginstore`) VALUES (?, ?)");
			mysqli_stmt_bind_param($stmt2, "si", $name, $pluginstore);
			if (mysqli_stmt_execute($stmt2)) {
				echo '<meta http-equiv="refresh" content="0; URL=index.php?add-success">';
			} else {
				echo '<meta http-equiv="refresh" content="0; URL=?error">';
			}
		}
		// $stmt = mysqli_prepare($mysqli, "SELECT `id`, `name` FROM `plugins`");
		// mysqli_stmt_execute($stmt); mysqli_stmt_store_result($stmt);
		// mysqli_stmt_bind_result($stmt, $id, $name);
		// while (mysqli_stmt_fetch($stmt)) {
		// 	echo "<p><a href='show_data.php?id=".$id."'>$name</a></p>";
		// }
		?>
	</div>
</body>
</html>
