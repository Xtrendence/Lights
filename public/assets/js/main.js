document.addEventListener("DOMContentLoaded", () => {
	let processing = false;
	let status = {};
	let config = {};

	let changedBrightness = new Date().getTime() / 1000;

	let body = document.getElementsByTagName("body")[0];

	if(detectMobile()) {
		body.id = "mobile";
	}
	else {
		body.id = "desktop";
	}

	let divOverlay = document.getElementsByClassName("overlay")[0];

	let divBrightnessInput = document.getElementsByClassName("brightness-input-wrapper")[0];

	let inputBrightness = document.getElementById("brightness-input");

	let buttonBrightnessCancel = document.getElementById("brightness-cancel");
	let buttonBrightnessConfirm = document.getElementById("brightness-confirm");

	let divToggleWrapper = document.getElementsByClassName("toggle-wrapper")[0];
	let divIconWrapper = document.getElementsByClassName("icon-wrapper")[0];

	let divCircle = document.getElementById("brightness-circle");
	let divDot = document.getElementById("brightness-dot");
	let divBrightnessOutput = document.getElementsByClassName("brightness-output-wrapper")[0];

	let divColor = document.getElementsByClassName("color-block");
	let divSwatch = document.getElementsByClassName("color-swatch");

	let buttonColor = document.getElementById("color-mode");
	let buttonBright = document.getElementById("bright-mode");

	let inputIP = document.getElementById("ip");
	let inputPort = document.getElementById("port");

	let buttonGuestModeEnabled = document.getElementById("guest-mode-enabled");
	let buttonGuestModeDisabled = document.getElementById("guest-mode-disabled");

	let buttonConfirmConfig = document.getElementById("confirm-config");

	let circle = document.getElementsByClassName("progress-circle")[0];
	let radius = circle.r.baseVal.value;
	let circumference = radius * 2 * Math.PI;

	circle.style.strokeDasharray = `${circumference} ${circumference}`;
	circle.style.strokeDashoffset = `${circumference}`;

	let spanBrightness = document.getElementById("brightness-output");

	getConfig();
	getStatus();

	setInterval(statusInterval, 1500);

	brightnessInput();

	function statusInterval() {
		if(!processing && document.hasFocus()) {
			getStatus();
		}
	}

	divOverlay.addEventListener("click", () => {
		hideBrightnessInput();
	});

	divToggleWrapper.addEventListener("click", () => {
		if(divIconWrapper.classList.contains("active")) {
			setPower(false);
		} else {
			setPower(true);
		}
	});

	divBrightnessOutput.addEventListener("click", () => {
		if(divBrightnessOutput.classList.contains("active")) {
			hideBrightnessInput();
		} else {
			showBrightnessInput();
		}
	});

	inputBrightness.addEventListener("keydown", (e) => {
		if(e.key.toLowerCase() === "enter") {
			buttonBrightnessConfirm.click();
		}
	});

	buttonBrightnessCancel.addEventListener("click", () => {
		hideBrightnessInput();
	});

	buttonBrightnessConfirm.addEventListener("click", () => {
		try {
			let number = parseInt(inputBrightness.value);
			setBrightness(number);
			hideBrightnessInput();
		} catch(e) {
			console.log(e);
		}
	});

	for(let i = 0; i < divColor.length; i++) {
		divColor[i].addEventListener("click", async () => {
			if(status.power === "off") {
				await setPower(true);
			}
			let color = divColor[i].getAttribute("data-color");
			setColor(color, "color");
		});
	}

	buttonColor.addEventListener("click", async () => {
		if(status.power === "off") {
			await setPower(true);
		}
		buttonColor.classList.add("active");
		buttonBright.classList.remove("active");
		setColor("orange", "color");
	});

	buttonBright.addEventListener("click", async () => {
		if(status.power === "off") {
			await setPower(true);
		}
		buttonColor.classList.remove("active");
		buttonBright.classList.add("active");
		setColor(null, "bright");
	});

	buttonGuestModeEnabled.addEventListener("click", () => {
		buttonGuestModeEnabled.classList.add("active");
		buttonGuestModeDisabled.classList.remove("active");
	});

	buttonGuestModeDisabled.addEventListener("click", () => {
		buttonGuestModeEnabled.classList.remove("active");
		buttonGuestModeDisabled.classList.add("active");
	});

	buttonConfirmConfig.addEventListener("click", () => {
		setConfig(inputIP.value, inputPort.value);
	});

	function hideBrightnessInput() {
		inputBrightness.value = "";

		divOverlay.classList.add("hidden");
		divBrightnessInput.classList.add("hidden");

		inputBrightness.blur();
	}

	function showBrightnessInput() {
		inputBrightness.value = status.brightness;

		divOverlay.classList.remove("hidden");
		divBrightnessInput.classList.remove("hidden");

		inputBrightness.focus();
	}

	function getConfig() {
		sendRequest("GET",
			"./api/lights/get-config.php"
		).then((json) => {
			try {
				let response = JSON.parse(json);
				config = response;
				inputIP.value = response.ip;
				inputPort.value = response.port;
				if(response["guest-mode"]) {
					buttonGuestModeEnabled.classList.add("active");
					buttonGuestModeDisabled.classList.remove("active");
				} else {
					buttonGuestModeEnabled.classList.remove("active");
					buttonGuestModeDisabled.classList.add("active");
				}
			} catch(error) {
				console.log(error);
			}
		}).catch((error) => {
			console.log(error);
		});
	}

	async function setConfig(ip, port) {
		let body = { "ip":ip, "port":port, "guest-mode":buttonGuestModeEnabled.classList.contains("active") };

		return new Promise((resolve, reject) => {
			sendRequest("POST",
				"./api/lights/set-config.php",
				JSON.stringify(body)
			).then(() => {
				getConfig();
				resolve();
			}).catch((error) => {
				console.log(error);
				reject();
			});
		});
	}

	function getStatus() {
		sendRequest("GET",
			"./api/lights/get-status.php"
		).then((json) => {
			try {
				let response = JSON.parse(json);
				let result = JSON.parse(response[0])["result"];
				if(typeof result !== "undefined") {
					status.power = result[0];
					status.brightness = result[1];
					status.color = result[2];
					status.mode = result[3];

					if(status.power === "on") {
						divIconWrapper.classList.add("active");
					} else {
						divIconWrapper.classList.remove("active");
					}

					setTransform(divDot, (status.brightness * 360) / 100);
					spanBrightness.textContent =  status.brightness;

					if(!document.getElementsByClassName(status.color)[0].classList.contains("active") || status.mode === "2") {
						for(let i = 0; i < divSwatch.length; i++) {
							divSwatch[i].parentElement.classList.remove("active");
							divSwatch[i].classList.remove("active");
							if(status.mode === "1" && divSwatch[i].classList.contains(status.color)) {
								divSwatch[i].parentElement.classList.add("active");
								divSwatch[i].classList.add("active");
							}
						}
					}

					if(status.mode === "1") {
						buttonColor.classList.add("active");
						buttonBright.classList.remove("active");
					} else if(status.mode === "2") {
						buttonColor.classList.remove("active");
						buttonBright.classList.add("active");
					}
				}
			} catch(error) {
				console.log(error);
			}
		}).catch((error) => {
			console.log(error);
		});
	}

	async function setPower(power) {
		processing = true;
		let body = { power:power };

		return new Promise((resolve, reject) => {
			sendRequest("POST", 
				"./api/lights/set-power.php", 
				JSON.stringify(body)
			).then(() => {
				getStatus();
				resolve();
			}).catch((error) => {
				console.log(error);
				reject();
			});
		});
	}

	async function setBrightness(brightness, mode) {
		if(status.power === "off") {
			await setPower(true);
		}

		processing = true;
		changedBrightness = new Date().getTime();
		let body = { brightness:brightness, mode:mode };

		return new Promise((resolve, reject) => {
			sendRequest("POST", 
				"./api/lights/set-brightness.php", 
				JSON.stringify(body)
			).then(() => {
				getStatus();
				resolve();
			}).catch((error) => {
				console.log(error);
				reject();
			});
		});
	}

	function setTransform(element, angle) {
		let transfromString = "rotate(" + angle + "deg)";
		element.style.webkitTransform = transfromString;
		element.style.MozTransform = transfromString;
		element.style.msTransform = transfromString;
		element.style.OTransform = transfromString;
		element.style.transform = transfromString;

		let percentage = ((angle * 100) / 360).toFixed(0);
		setProgress(percentage);
	}

	function setProgress(percent) {
		let offset = circumference - percent / 100 * circumference;
		circle.style.strokeDashoffset = offset;
	}

	function processRadial(posX, posY) {
		if(typeof posX !== "undefined" && typeof posY !== "undefined") {
			let centerX = divCircle.offsetWidth / 2 + divCircle.getBoundingClientRect().left;
			let centerY = divCircle.offsetHeight / 2 + divCircle.getBoundingClientRect().top;

			let deltaX = centerX - posX;
			let deltaY = centerY - posY;
			
			let angle = (Math.atan2(deltaY, deltaX) * (180 / Math.PI));
			angle -= 90;

			if(angle < 0) {
				angle = 360 + angle;
			}

			angle = Math.round(angle);

			setTransform(divDot, angle);

			let percentage = ((angle * 100) / 360).toFixed(0);

			if(percentage > 100) {
				percentage = 100;
			} else if(percentage < 0) {
				percentage = 0;
			}

			spanBrightness.textContent =  percentage;
				
			setTimeout(() => {
				if((new Date().getTime()) - changedBrightness > 1000) {
					setBrightness(spanBrightness.textContent);
				} else {
					console.log("Rate limit exceeded.");
				}
			}, 100);
		}
	}

	function brightnessInput() {
		let dragging = false;

		divCircle.addEventListener("click", function(e) {
			dragging = false;
			processRadial(e.pageX, e.pageY);
		}, false);

		divCircle.addEventListener("mousedown", function(e) {
			dragging = true;
		}, false);

		divCircle.addEventListener("touchstart", function(e) {
			dragging = true;
			body.style.overflowY = "hidden";
		}, false);

		divCircle.addEventListener("touchmove", function(e) {
			e.preventDefault();
			processRadial(e.touches[0].pageX, e.touches[0].pageY);
			body.style.overflowY = "hidden";
		});

		document.addEventListener("mouseup", function(e) {
			dragging = false;
		}, false);

		document.addEventListener("touchend", function(e) {
			dragging = false;
			body.style.overflowY = "visible";
		}, false);

		function draw(e) {
			let posX, posY, touch;
			if(dragging) {
				touch = void 0;

				if(e.touches) {
					touch = e.touches[0];
				}

				if(typeof e !== "undefined") {
					posX = e.pageX;
					posY = e.pageY;
				} else if(typeof touch !== "undefined") {
					posX = touch.pageX;
					posY = touch.pageY;
				}
				
				processRadial(posX, posY);
			}
		};

		document.addEventListener("mousemove", draw);
		document.addEventListener("touchmove", draw);
	}

	async function setColor(color, mode) {
		processing = true;
		let body = { color:color, mode:mode };
		if(mode === "bright") {
			body.brightness = parseInt(spanBrightness.textContent);
		}

		return new Promise((resolve, reject) => {
			sendRequest("POST", 
				"./api/lights/set-color.php", 
				JSON.stringify(body)
			).then(() => {
				getStatus();
				resolve();
			}).catch((error) => {
				console.log(error);
				reject();
			});
		});
	}
});

let sendRequest = (method, url, body) => {
	let xhr = new XMLHttpRequest();

	return new Promise((resolve, reject) => {
		xhr.addEventListener("readystatechange", () => {
			if(xhr.readyState !== 4) return;
			if(xhr.status >= 200 && xhr.status < 300) {
				resolve(xhr.responseText);
			} else {
				reject();
			}
		});

		xhr.open(method, url, true);
		xhr.send(body);
	});
}

function detectMobile() {
	var check = false;
	(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
}