<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		include_once "../Config.php";
		include_once "../Light.php";

		if(empty($_POST)) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}

		$config = new Config();
		$info = $config->getConfig();

		$light = new Light($info);

		$brightness = $_POST["brightness"];

		if($brightness >= 1 && $brightness <= 100) {
			$light->sendRequest("set_bright", [intval($brightness)]);
		} else if($brightness < 1) {
			$light->sendRequest("set_bright", [1]);
			$light->sendRequest("set_power", ["off"]);
		}
	} else {
		echo json_encode(["message" => "Wrong HTTP request method. Use POST instead."]);
	}
?>