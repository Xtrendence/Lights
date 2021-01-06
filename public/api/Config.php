<?php
	class Config {
		public $config;
		
		private $localhost = array("127.0.0.1", "::1");

		public function getConfig() {
			$file = "../../assets/cfg/config.cfg";
			$content = file_get_contents($file);
			if(!empty($content)) {
				$this->config = json_decode($content, true);
				if($this->config["guest-mode"] && $this->lan() || in_array($_SERVER["REMOTE_ADDR"], $this->localhost)) {
					return $this->config;
				} else {
					return ["message" => "Access not authorized."];
				}
			} else {
				return ["message" => "Config file is empty."];
			}
		}

		public function setConfig() {
			$file = "../../assets/cfg/config.cfg";
			$content = file_get_contents($file);
			file_put_contents($file, json_encode($this->config));
		}

		private function lan() {
			if(strpos($_SERVER['REMOTE_ADDR'], "192.168.1.") !== false) {
				return true;
			}
			return false;
		}
	}
?>