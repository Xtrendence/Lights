<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		include_once '../Config.php';
		include_once '../Light.php';

		if(empty($_POST)) {
			$_POST = json_decode(file_get_contents("php://input"), true);
		}

		$config = new Config();
		$info = $config->getConfig();

		$light = new Light($info);

		$color = $_POST['color'];

		$colors = ["orange" => 0xFFC04C, "white" => 0xFFFFFF, "purple" => 0x660099, "green" => 0x00FF00, "blue" => 0x0000FF, "red" => 0xFF0000];

		if(in_array($color, array_keys($colors))) {
			$light->sendRequest("set_rgb", [$colors[$color]]);
		}
	} else {
		echo json_encode(['message' => "Wrong HTTP request method. Use POST instead."]);
	}
?>