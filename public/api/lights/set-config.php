<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		include_once "../Config.php";

		if(empty($_POST)) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}

		$config = new Config();
		$config->config = ["ip" => $_POST["ip"], "port" => $_POST["port"]];
		$config->setConfig();
	} else {
		echo json_encode(["message" => "Wrong HTTP request method. Use POST instead."]);
	}
?>