<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="./assets/css/style.css">
		<link rel="stylesheet" href="./assets/css/resize.css">
		<link rel="apple-touch-icon" sizes="180x180" href="./assets/img/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicon-16x16.png">
		<link rel="manifest" href="./assets/img/site.webmanifest">
		<link rel="mask-icon" href="./assets/img/safari-pinned-tab.svg" color="#5bbad5">
		<link rel="shortcut icon" href="./assets/img/favicon.ico">
		<meta name="msapplication-TileColor" content="#2d89ef">
		<meta name="msapplication-config" content="./assets/img/browserconfig.xml">
		<meta name="theme-color" content="#111111">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="mobile-web-app-capable" content="yes">
		<meta charset="UTF-8">
		<meta name="description" content="Yeelight bulb remote.">
		<meta name="author" content="Xtrendence">
		<script src="./assets/js/main.js"></script>
		<title>Bulb Remote</title>
	</head>
	<body>
		<div class="section">
			<div class="toggle-wrapper">
				<div class="icon-wrapper">
					<svg class="moon-icon" width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1390 1303q-54 9-110 9-182 0-337-90t-245-245-90-337q0-192 104-357-201 60-328.5 229t-127.5 384q0 130 51 248.5t136.5 204 204 136.5 248.5 51q144 0 273.5-61.5t220.5-171.5zm203-85q-94 203-283.5 324.5t-413.5 121.5q-156 0-298-61t-245-164-164-245-61-298q0-153 57.5-292.5t156-241.5 235.5-164.5 290-68.5q44-2 61 39 18 41-15 72-86 78-131.5 181.5t-45.5 218.5q0 148 73 273t198 198 273 73q118 0 228-51 41-18 72 13 14 14 17.5 34t-4.5 38z"/></svg>
					<svg class="sun-icon" width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1472 896q0-117-45.5-223.5t-123-184-184-123-223.5-45.5-223.5 45.5-184 123-123 184-45.5 223.5 45.5 223.5 123 184 184 123 223.5 45.5 223.5-45.5 184-123 123-184 45.5-223.5zm276 277q-4 15-20 20l-292 96v306q0 16-13 26-15 10-29 4l-292-94-180 248q-10 13-26 13t-26-13l-180-248-292 94q-14 6-29-4-13-10-13-26v-306l-292-96q-16-5-20-20-5-17 4-29l180-248-180-248q-9-13-4-29 4-15 20-20l292-96v-306q0-16 13-26 15-10 29-4l292 94 180-248q9-12 26-12t26 12l180 248 292-94q14-6 29 4 13 10 13 26v306l292 96q16 5 20 20 5 16-4 29l-180 248 180 248q9 12 4 29z"/></svg>
				</div>
			</div>
		</div>
		<div class="section">
			<div class="brightness-wrapper">
				<div class="brightness-container">
					<span id="brightness-output" class="noselect">0%</span>
					<div id="brightness-circle">
						<div id="brightness-dot"></div>
					</div>
					<svg class="progress-ring">
						<circle class="progress-circle" fill="transparent" r="95" cx="100" cy="100"/>
					</svg>
				</div>
			</div>
		</div>
		<div class="section">
			<div class="color-wrapper">
				<div class="color-block" data-color="orange">
					<div class="color-swatch orange 16760908"></div>
				</div>
				<div class="color-block" data-color="white">
					<div class="color-swatch white 16777215"></div>
				</div>
				<div class="color-block" data-color="purple">
					<div class="color-swatch purple 6684825"></div>
				</div>
				<div class="color-block" data-color="green">
					<div class="color-swatch green 65280"></div>
				</div>
				<div class="color-block" data-color="blue">
					<div class="color-swatch blue 255"></div>
				</div>
				<div class="color-block" data-color="red">
					<div class="color-swatch red 16711680"></div>
				</div>
			</div>
		</div>
		<div class="section">
			<div class="config-wrapper">
				<input type="text" id="ip" placeholder="IP...">
				<input type="text" id="port" placeholder="Port...">
				<span>Guest Mode</span>
				<button class="guest-mode" id="guest-mode-enabled">Enabled</button>
				<button class="guest-mode" id="guest-mode-disabled">Disabled</button>
				<button id="confirm-config">Confirm</button>
			</div>
		</div>
	</body>
</html>