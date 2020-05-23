<?php
include_once("config.inc.php");
// fetch_data.php
// this script, fetch download-stats from https://pluginstore.woltlab.com/file/XXXX and save it into an mysql-database

if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty(validate_form_input($_GET['id'])) ) {
	$id = $_GET['id'];
	if ($id == "all") {
		$stmt = mysqli_prepare($mysqli, "SELECT count(*) FROM `plugins` ");
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $count); mysqli_stmt_fetch($stmt);

		for($i=1; $i <= $count; $i++) {
			echo "<p>Fetching Data for Plugin-ID $i: <br>";
			fetch_plugin($mysqli, $i);
			echo "</p>";
		}
	} else {
		fetch_plugin($mysqli, $id);
	}
}
echo "<p><a href='index.php'>Back</a></p>";
function fetch_plugin($mysqli, $plugin) {
	$stmt = mysqli_prepare($mysqli, "SELECT `pluginstore` FROM `plugins` WHERE `id` = ? LIMIT 1");
	mysqli_stmt_bind_param($stmt, "i", $plugin); mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt); // use this, if you just want to use num_rows
	if ($stmt->num_rows == 1) {
		mysqli_stmt_bind_result($stmt, $pluginstore_id); mysqli_stmt_fetch($stmt); // use this, if you want to select one row and get the result

		$page = get_url("https://pluginstore.woltlab.com/file/".$pluginstore_id);
		if (preg_match ('/(\d*)\sDownloads/', $page, $arr)) {
			$downloads = $arr[1];
		}

		$stmt2 = mysqli_prepare($mysqli, "INSERT INTO `stats` (`id`, `date`, `value`) VALUES (?, CURDATE(), ?)");
		mysqli_stmt_bind_param($stmt2, "ii", $plugin, $downloads);
		if (mysqli_stmt_execute($stmt2)) {
			return $downloads;
		} else {
			echo "Could not insert stats for plugin-id ".$plugin.": ".mysqli_error($mysqli);
			return 0;
		}
	} else {
		echo "No plugin found with id $plugin!";
		return 0;
	}
}

function get_url($request_url) {
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $request_url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($curl_handle, CURLOPT_TIMEOUT, 0);
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl_handle, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
	$JsonResponse = curl_exec($curl_handle);
	$http_code = curl_getinfo($curl_handle);

	return($JsonResponse);
}
?>
