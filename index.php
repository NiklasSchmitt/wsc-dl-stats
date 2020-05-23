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
	<title>WoltLab Suite Plugin-Stats</title>
</head>
<body>
	<div class="paper container">
		<h2>WSC Plugin-stats</h2>
		<p>
			<?php
			if (isset($_GET['add-success']) ) {
				echo "<div class='row flex-spaces'><div class='alert alert-success'>Plugin successfully added!</div></div>";
			}
			?>
			On this page you can trace the download-stats for all of your WoltLab Suite plugins.
		</p>
		<?php
		$stmt = mysqli_prepare($mysqli, "SELECT `id`, `name` FROM `plugins`");
		mysqli_stmt_execute($stmt); mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $id, $name);
		while (mysqli_stmt_fetch($stmt)) {
			echo "<p><a href='show_data.php?id=".$id."' style='background-image:none;'><button class='btn-small btn-secondary'>$name</button></a></p>";
		}
		?>
		<p>
			<a href="add.php" style="background-image:none;"><button class="btn-small btn-primary">Add Plugin</button></a>
			<a href="fetch_data.php?id=all" style="background-image:none;"><button class="btn-small btn-primary">Fetch Data for ALL Plugins</button></a>
		</p>
	</div>
</body>
</html>
