<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		include_once "../Config.php";
		include_once "../Light.php";

		$config = new Config();
		$info = $config->getConfig();

		$light = new Light($info);
		echo $light->sendRequest("get_prop", ["power", "bright", "rgb", "color_mode"]);
	} else {
		echo json_encode(["message" => "Wrong HTTP request method. Use GET instead."]);
	}
?>