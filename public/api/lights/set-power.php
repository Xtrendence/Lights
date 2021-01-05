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

		$power = $_POST["power"];

		if($power) {
			$light->sendRequest("set_power", ["on"]);
			echo "true";
		} else {
			$light->sendRequest("set_power", ["off"]);
			echo "false";
		}
	} else {
		echo json_encode(["message" => "Wrong HTTP request method. Use POST instead."]);
	}
?>