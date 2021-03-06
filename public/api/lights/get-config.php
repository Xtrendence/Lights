<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		include_once "../Config.php";

		$config = new Config();
		$info = $config->getConfig();

		echo json_encode($config->config);
	} else {
		echo json_encode(["message" => "Wrong HTTP request method. Use GET instead."]);
	}
?>