<?php	
	include "./scripts/detect_device.php";
	if($user_agent_mobile) {
		$device = "mobile";
	}
	else {
		$device = "desktop";
	}
	
	$menu_icon = '<svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></path></svg>';
	$power_icon = '<svg class="power-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 54.1c63 45 104 118.6 104 201.9 0 136.8-110.8 247.7-247.5 248C120 504.3 8.2 393 8 256.4 7.9 173.1 48.9 99.3 111.8 54.2c11.7-8.3 28-4.8 35 7.7L162.6 90c5.9 10.5 3.1 23.8-6.6 31-41.5 30.8-68 79.6-68 134.9-.1 92.3 74.5 168.1 168 168.1 91.6 0 168.6-74.2 168-169.1-.3-51.8-24.7-101.8-68.1-134-9.7-7.2-12.4-20.5-6.5-30.9l15.8-28.1c7-12.4 23.2-16.1 34.8-7.8zM296 264V24c0-13.3-10.7-24-24-24h-32c-13.3 0-24 10.7-24 24v240c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24z"/></svg>';
	$settings_icon = '<svg class="settings-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M444.788 291.1l42.616 24.599c4.867 2.809 7.126 8.618 5.459 13.985-11.07 35.642-29.97 67.842-54.689 94.586a12.016 12.016 0 0 1-14.832 2.254l-42.584-24.595a191.577 191.577 0 0 1-60.759 35.13v49.182a12.01 12.01 0 0 1-9.377 11.718c-34.956 7.85-72.499 8.256-109.219.007-5.49-1.233-9.403-6.096-9.403-11.723v-49.184a191.555 191.555 0 0 1-60.759-35.13l-42.584 24.595a12.016 12.016 0 0 1-14.832-2.254c-24.718-26.744-43.619-58.944-54.689-94.586-1.667-5.366.592-11.175 5.459-13.985L67.212 291.1a193.48 193.48 0 0 1 0-70.199l-42.616-24.599c-4.867-2.809-7.126-8.618-5.459-13.985 11.07-35.642 29.97-67.842 54.689-94.586a12.016 12.016 0 0 1 14.832-2.254l42.584 24.595a191.577 191.577 0 0 1 60.759-35.13V25.759a12.01 12.01 0 0 1 9.377-11.718c34.956-7.85 72.499-8.256 109.219-.007 5.49 1.233 9.403 6.096 9.403 11.723v49.184a191.555 191.555 0 0 1 60.759 35.13l42.584-24.595a12.016 12.016 0 0 1 14.832 2.254c24.718 26.744 43.619 58.944 54.689 94.586 1.667 5.366-.592 11.175-5.459 13.985L444.788 220.9a193.485 193.485 0 0 1 0 70.2zM336 256c0-44.112-35.888-80-80-80s-80 35.888-80 80 35.888 80 80 80 80-35.888 80-80z"/></svg>';
?>
<!-- Copyright <?php echo date('Y'); ?> © Xtrendence -->
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="./source/css/style.css">
		<script src="./source/js/jquery.js"></script>
		<script src="./source/js/shake.js"></script>
		<script src="./source/js/donutty.js"></script>
		<script src="./source/js/main.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="theme-color" content="#141414">
		<meta content="./images/favicon/Apple144.png" itemprop="image">
		<link rel="apple-touch-icon-precomposed" sizes="57x57" href="./images/favicon/Apple57.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="./images/favicon/Apple72.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="./images/favicon/Apple114.png">
		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="./images/favicon/Apple120.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="./images/favicon/Apple144.png">
		<title>Lights</title>
	</head>
	
	<body id="<?php echo $device; ?>">
		<div class="main-wrapper noselect">
			<div class="section power">
				<div class="power-switch" data-action="on">
					<div class="slider">
						<?php echo $power_icon; ?>
					</div>
				</div>
			</div>
			<div class="section toggles">
				<?php echo $settings_icon; ?>
			</div>
			<div class="section settings">
				<button class="settings-title">IP &amp; Port</button>
				<input class="settings-input ip" type="text" placeholder="IP...">
				<input class="settings-input port" type="text" placeholder="Port...">
				<button class="settings-confirm action-button change-config">Confirm</button>
			</div>
			<div class="section brightness">
				<div class="brightness-block action-button 1" data-action="dimmest" data-value="1"><button>1</button></div>
				<div class="brightness-block action-button 10" data-action="dimmer" data-value="10"><button>10</button></div>
				<div class="brightness-block action-button 25" data-action="dim" data-value="25"><button>25</button></div>
				<div class="brightness-block action-button 50" data-action="medium" data-value="50"><button>50</button></div>
				<div class="brightness-block action-button 75" data-action="bright" data-value="75"><button>75</button></div>
				<div class="brightness-block action-button 100" data-action="brightest" data-value="100"><button>100</button></div>
			</div>
			<div class="section color">
				<div class="color-block action-button 16760908" data-action="orange">
					<div class="color-swatch orange"></div>
				</div>
				<div class="color-block action-button 16777215" data-action="white">
					<div class="color-swatch white"></div>
				</div>
				<div class="color-block action-button 6684825" data-action="purple">
					<div class="color-swatch purple"></div>
				</div>
				<div class="color-block action-button 65280" data-action="green">
					<div class="color-swatch green"></div>
				</div>
				<div class="color-block action-button 255" data-action="blue">
					<div class="color-swatch blue"></div>
				</div>
				<div class="color-block action-button 16711680" data-action="red">
					<div class="color-swatch red"></div>
				</div>
			</div>
		</div>
	</body>
</html>