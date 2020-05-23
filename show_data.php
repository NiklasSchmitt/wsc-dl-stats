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
	<title>Detailed stats | WSC DL-stats</title>
</head>
<body>
	<div class="paper container">
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty(validate_form_input($_GET['id'])) ) {
			$id = $_GET['id'];
			$dataPoints = array();

			$stmt = mysqli_prepare($mysqli, "SELECT p.id, p.name, s.date, s.value FROM `plugins` AS p JOIN `stats` AS s ON p.id = s.id WHERE p.id = ?");
			mysqli_stmt_bind_param($stmt, "i", $id);
			mysqli_stmt_execute($stmt); mysqli_stmt_store_result($stmt);
			if ($stmt->num_rows >= 1) {
				mysqli_stmt_bind_result($stmt, $db_id, $name, $date, $value);
				while (mysqli_stmt_fetch($stmt)) {
					// echo "<p>Date $date Value $value</p>";
					$arr = array("y" => $value, "label" => $date);
					array_push($dataPoints, $arr);
				}
				?>
				<h3>Stats for <?php echo $name;?></h3>
				<script>
				window.onload = function () {

				var chart = new CanvasJS.Chart("chartContainer", {
					title: {
						text: "Downloads per day"
					},
					axisY: {
						title: "Number of Downloads"
					},
					data: [{
						type: "line",
						dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
					}]
				});
				chart.render();

				}
				</script>
				<div id="chartContainer" style="height: 350px; width: 100%;"></div>
				<p>
					Last run on <?php echo $date;?> (Value: <?php echo $value;?>)<br>
					<p><a href="fetch_data.php?id=<?php echo $id; ?>" style="background-image:none;"><button class="btn-small btn-secondary">Fetch now</button></a></p>
				</p>
				<?php
			} else {
				echo "<p>No stats found for plugin-id $id!</p>";
				echo "<p><a href='fetch_data.php?id=$id' style='background-image:none;'><button class='btn-small btn-secondary'>Fetch now</button></a></p>";
			}
		}
		?>
		<p><a href="index.php" style="background-image:none;"><button class="btn-small btn-primary">Back</button></a></p>
	</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
