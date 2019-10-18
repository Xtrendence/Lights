$(document).ready(function() {
	check_status();
	adjust_to_screen();
	setInterval(check_status, 10000);
	
	var shake_event = new Shake({threshold: 12});
	shake_event.start();
	window.addEventListener("shake", function() { $(".power-switch").trigger("click") }, false);
	
	var default_brightness_html = '<div class="brightness-block action-button 1" data-action="dimmest" data-value="1"><button>1</button></div><div class="brightness-block action-button 10" data-action="dimmer" data-value="10"><button>10</button></div><div class="brightness-block action-button 25" data-action="dim" data-value="25"><button>25</button></div><div class="brightness-block action-button 50" data-action="medium" data-value="50"><button>50</button></div><div class="brightness-block action-button 75" data-action="bright" data-value="75"><button>75</button></div><div class="brightness-block action-button 100" data-action="brightest" data-value="100"><button>100</button></div>';
	
	$(".power-switch").on("click", function() {
		if($(this).hasClass("active")) {
			perform_action("power", "off");
		}
		else {
			perform_action("power", "on");
		}
	});
	$(".settings-icon").on("click", function() {
		if($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(".section.settings").css("height", "0").hide();
		}
		else {
			$(this).addClass("active");
			$(".section.settings").show().css("height", "290px");
		}
	});
	$(".settings-confirm.change-config").on("click", function() {
		var ip = $(".settings-input.ip").val();
		var port = $(".settings-input.port").val();
		$.ajax({
			url: "./scripts/api.php",
			type: "POST",
			data: { action: "change-config", ip: ip, port: port },
			success: function(data) {
				check_status();
			}
		});
	});
	$(".section.brightness").delegate(".brightness-block", "click", function() {
		perform_action("power", "on");
		var action = $(this).attr("data-action");
		perform_action("brightness", action);
	});
	$(".color-block").on("click", function() {
		perform_action("power", "on");
		var action = $(this).attr("data-action");
		perform_action("color", action);
	});
	$(window).resize(function() {
		$(".section.brightness").html(default_brightness_html);
		setTimeout(adjust_to_screen, 250);
	});
	
	function power_status() {
		$.ajax({
			url: "./scripts/api.php",
			type: "POST",
			data: { action: "status" },
			success: function(data) {
				var result = JSON.parse(data);
				console.log(data);
				if(result == "on") {
					$(".power-switch").addClass("active");
				}
				else if(result == "off") {
					$(".power-switch").removeClass("active");
				}
				else if(result == null) {
					setTimeout(function() {
						power_status();
					}, 2000);
				}
			}
		});
	}
	function brightness_status() {
		$.ajax({
			url: "./scripts/api.php",
			type: "POST",
			data: { action: "brightness-status" },
			success: function(data) {
				var result = JSON.parse(data);
				console.log(data);
				$(".brightness-block").removeClass("active").find(".donut-fill").attr("stroke", "#ffb732");
				$(".brightness-block." + result).addClass("active").find(".donut-fill").attr("stroke", "#00a6ff");
				if(result == null) {
					setTimeout(function() {
						brightness_status();
					}, 2000);
				}
			}
		});
	}
	function color_status() {
		$.ajax({
			url: "./scripts/api.php",
			type: "POST",
			data: { action: "color-status" },
			success: function(data) {
				var result = JSON.parse(data);
				console.log(data);
				$(".color-block").removeClass("active");
				if(result['mode'] == 1) {
					$(".color-block." + result['color']).addClass("active");
				}
				else if(result['color'] == null || result['mode'] == null) {
					setTimeout(function() {
						color_status();
					}, 2000);
				}
			}
		});
	}
	function get_config() {
		$.ajax({
			url: "./scripts/api.php",
			type: "POST",
			data: { action: "get-config" },
			success: function(data) {
				var result = JSON.parse(data);
				console.log(data);
				$(".settings-confirm").removeClass("active");
				$(".settings-input.ip").val(result['ip']);
				$(".settings-input.port").val(result['port']);
			}
		});
	}
	function perform_action(category, action) {
		$.ajax({
			url: "./scripts/api.php",
			type: "POST",
			data: { action: action },
			success: function(data) {
				if(typeof data != "undefined" && data != null && data != "") {
					var result = JSON.parse(data);
				}
				if(category == "power") {
					power_status();
				}
				if(category == "brightness") {
					brightness_status();
				}
				if(category == "color" || action == "brightest") {
					color_status();
				}
			}
		});
	}
	function adjust_to_screen() {
		if($(window).width() > 410) {
			var radius = 45;
		}
		else if($(window).width() <= 410 && $(window).width() > 350) {
			var radius = 35;
		}
		else if($(window).width() <= 350 && $(window).width() > 280) {
			var radius = 25;
		}
		else {
			var radius = 15;
		}
		$(".brightness-block").each(function(key, value) {
			$(value).donutty({
				value:$(value).attr("data-value"),
				round:false,
				circle:true,
				padding:0,
				radius:radius,
				thickness:10,
				bg:"rgb(60,60,60)",
				color:"#ffb732",
				transition:"all 0.5s cubic-bezier(0.57, 0.13, 0.18, 0.98)"
			});
		});
		if($(window).height() < $(".main-wrapper").outerHeight()) {
			$("body").css("overflow-y", "visible");
		}
	}
	function check_status() {
		power_status();
		brightness_status();
		color_status();
		get_config();
	}
});