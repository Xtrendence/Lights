<?php
	class Light {
		private $bulb;

		public function __construct($config) {
			$this->bulb = $config;
		}

		public function sendRequest($method, $params) {
			$connection = fsockopen($this->bulb['ip'], $this->bulb['port'], $errno, $errstr, 30);
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
	}
?>