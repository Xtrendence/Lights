<?php
	class Config {
		public $config;

		public function getConfig() {
			$file = "../../assets/cfg/config.cfg";
			$content = file_get_contents($file);
			if(!empty($content)) {
				$this->config = json_decode($content, true);
				return $this->config;
			} else {
				return ["message" => "Config file is empty."];
			}
		}

		public function setConfig() {
			$file = "../../assets/cfg/config.cfg";
			$content = file_get_contents($file);
			file_put_contents($file, json_encode($this->config));
		}
	}
?>