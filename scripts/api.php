<?php		
	$queries = array();
	parse_str($_SERVER['QUERY_STRING'], $queries);
	if(empty($queries['action'])) {
		$action = $_POST['action'];
	}
	else {
		$action = $queries['action'];
	}
	
	function light($ip, $port, $method, $params) {
		$connection = fsockopen($ip, $port, $errno, $errstr, 30);
		stream_set_blocking($connection, false);
		$action = array();
		if($connection) {
			$action["id"] = 1;
			$action["method"] = $method;
			$action["params"] = $params;
			fwrite($connection, json_encode($action) . "\r\n");
			fflush($connection);
			usleep(100 * 1000);
			$output[] = fgets($connection);
			fclose($connection);
		}
		return json_encode($output);
	}
	
	$ip = file_get_contents("../source/cfg/ip.config");
	$port = file_get_contents("../source/cfg/port.config");
	
	if($action == "power-status") {
		echo light($ip, $port, "get_prop", ["power"]);
	}
	if($action == "status") {
		$status = json_decode(light($ip, $port, "get_prop", ["power"]), true);
		$result = json_decode($status[0], true)['result'][0];
		echo json_encode($result);
	}
	if($action == "full-status") {
		$props = ["power", "bright", "ct", "rgb", "hue", "sat", "color_mode", "name", "bg_power", "bg_flowing", "bg_flow_params", "bg_ct", "bg_lmode", "bg_bright", "bg_rgb", "bg_hue", "bg_sat", "nl_br", "active_mode"];
		foreach($props as $prop) {
			echo $prop . " | " . light($ip, $port, "get_prop", [$prop]);
		}
	}
	if($action == "brightness-status") {
		$status = json_decode(light($ip, $port, "get_prop", ["bright"]), true);
		$result = json_decode($status[0], true)['result'][0];
		echo json_encode($result);
	}
	if($action == "color-status") {
		$status = json_decode(light($ip, $port, "get_prop", ["rgb", "color_mode"]), true);
		$result = array("color" => json_decode($status[0], true)['result'][0], "mode" => json_decode($status[0], true)['result'][1]);
		echo json_encode($result);
	}
	if($action == "dimmest") {
		echo light($ip, $port, "set_bright", [1]);
	}
	if($action == "dimmer") {
		echo light($ip, $port, "set_bright", [10]);
	}
	if($action == "dim") {
		echo light($ip, $port, "set_bright", [25]);
	}
	if($action == "medium") {
		echo light($ip, $port, "set_bright", [50]);
	}
	if($action == "bright") {
		echo light($ip, $port, "set_bright", [75]);
	}
	if($action == "brighter") {
		echo light($ip, $port, "set_bright", [85]);
	}
	if($action == "brightest") {
		echo light($ip, $port, "set_scene", ["ct", 3000, 100]);
	}
	if($action == "on") {
		echo light($ip, $port, "set_power", ["on"]);
	}
	if($action == "off") {
		echo light($ip, $port, "set_power", ["off"]);
	}
	if($action == "orange") {
		echo light($ip, $port, "set_rgb", [0xFFC04C]);
	}
	if($action == "white") {
		echo light($ip, $port, "set_rgb", [0xFFFFFF]);
	}
	if($action == "purple") {
		echo light($ip, $port, "set_rgb", [0x660099]);
	}
	if($action == "green") {
		echo light($ip, $port, "set_rgb", [0x00FF00]);
	}
	if($action == "blue") {
		echo light($ip, $port, "set_rgb", [0x0000FF]);
	}
	if($action == "red") {
		echo light($ip, $port, "set_rgb", [0xFF0000]);
	}
	if($action == "change-config") {
		$new_ip = $_POST['ip'];
		$new_port = $_POST['port'];
		file_put_contents("../source/cfg/ip.config", $new_ip);
		file_put_contents("../source/cfg/port.config", $new_port);
	}
	if($action == "get-config") {
		$config = ["ip" => $ip, "port" => $port, "guest-mode" => $guest_mode_config];
		echo json_encode($config);
	}
	exit();
?>