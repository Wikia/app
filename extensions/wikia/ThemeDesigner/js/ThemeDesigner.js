$(function() {
	ThemeDesigner.init();
});

var ThemeDesigner = {

	history: false,

	settings: {
		"color-body": "",
		"color-page": "",
		"color-buttons": "",
		"color-links": "",
		"theme": "",
		"wordmark-text": "",
		"wordmark-color": "",
		"wordmark-font": "default",
		"wordmark-size": "medium",
		"wordmark-image": false,
		"wordmark-image-revision": false,
		"banner-image": false,
		"banner-image-revision": false,
		"background-image": false,
		"background-image-revision": false,
		"background-tiled": false
	},

	init: function() {
		// apply JS object settings
		$.extend(ThemeDesigner.settings, themeSettings);
		//TODO: temp
		//ThemeDesigner.settings["wordmark-font"] = 'orbitron';

		// settings history
		ThemeDesigner.history = themeHistory;

		$().log(ThemeDesigner, 'ThemeDesigner');

		// iframe resizing
		$(window).resize(ThemeDesigner.resizeIframe).resize();

		// handle navigation clicks
		$("#Navigation a").click(ThemeDesigner.navigationClick);

		// handle "Save" button clicks
		$('#Toolbar').children('button').click(ThemeDesigner.saveClick);

		// init theme tab
		ThemeDesigner.ThemeTabInit();

		// init customize tab
		ThemeDesigner.CustomizeTabInit();

		// init wordmark tab
		ThemeDesigner.WordmarkTabInit();

		// init picker
		ThemeDesigner.PickerInit();

		// click first tab
		$("#Navigation a:first").click();
		
		ThemeDesigner.applySettings();
	},

	applySettings: function() {
		/*** Customize Tab ***/
		//color swatches
		$("#swatch-color-background").css("background-color", ThemeDesigner.settings["color-body"]);
		$("#swatch-color-buttons").css("background-color", ThemeDesigner.settings["color-buttons"]);
		$("#swatch-color-links").css("background-color", ThemeDesigner.settings["color-links"]);
		$("#swatch-color-page").css("background-color", ThemeDesigner.settings["color-page"]);

		/*** Wordmark Tab ***/
		//style wordmark preview
		$("#wordmark").removeClass().addClass(ThemeDesigner.settings["wordmark-font"]).addClass(ThemeDesigner.settings["wordmark-size"]).html(ThemeDesigner.settings["wordmark-text"]);
		//populate wordmark editor
		$("#wordmark-edit").find('input[type="text"]').val(ThemeDesigner.settings["wordmark-text"]);
		//select current font
		$("#wordmark-font").find('[value="' + ThemeDesigner.settings["wordmark-font"] + '"]').attr("selected", "selected");
		//select current size
		$("#wordmark-size").find('[value="' + ThemeDesigner.settings["wordmark-size"] + '"]').attr("selected", "selected");
	},

	navigationClick: function(event) {
		event.preventDefault();

		var clickedLink = $(this);
		var command = clickedLink.attr("rel");

		clickedLink.parent().addClass("selected").siblings().removeClass("selected");
		$("#" + command).show().siblings("section").hide();
	},

	resizeIframe: function() {
		$("#PreviewFrame, #EventThief").css("height", $(window).height() - $("#Designer").height());
		$("#EventThief").css("width", $(window).width() - 20);
	},


	ThemeTabInit: function() {
		$("#ThemeTab .previous, #ThemeTab .next").click(ThemeDesigner.themeSlider);
	},

	themeSlider: function(event) {
		event.preventDefault();
		var list = $("#ThemeTab .slider ul");
		var arrow = $(this);

		// prevent disabled clicks
		if (arrow.hasClass("disabled")) {
			return;
		}

		var slideTo = (arrow.hasClass("previous")) ? 0 : -760;
		list.animate({
			marginLeft: slideTo
		}, "slow");
		$("#ThemeTab .next, #ThemeTab .previous").toggleClass("disabled");
	},

	CustomizeTabInit: function() {
		$("#CustomizeTab").find("li").find("img[id*='color']").click(function(event) {
			ThemeDesigner.showPicker(event, "color");
		});
	},

	WordmarkTabInit: function() {
		//handle font family and font size menu change
		$("#wordmark-font").change(function() {
			ThemeDesigner.settings["wordmark-font"] = $(this).val();
			ThemeDesigner.applySettings();
		});
		$("#wordmark-size").change(function() {
			ThemeDesigner.settings["wordmark-size"] = $(this).val();
			ThemeDesigner.applySettings();
		});

		//handle wordmark editing
		$("#wordmark-edit-button").click(function(event) {
			event.preventDefault();
			$("#wordmark, #wordmark-edit").toggle();
		});
		$("#wordmark-edit").find("button").click(function(event) {
			event.preventDefault();
			ThemeDesigner.settings["wordmark-text"] = $("#wordmark-edit").find('input[type="text"]').val();
			ThemeDesigner.applySettings();
			$("#wordmark, #wordmark-edit").toggle();
		});
	},

	saveClick: function(ev) {
		ev.preventDefault();

		$(ev.target).attr('disabled', true);

		ThemeDesigner.save();
	},

	save: function() {
		$().log(ThemeDesigner.settings, 'ThemeDesigner');

		// send current settings to backend
		$.post(wgScript, {
			'action' :'ajax',
			'rs': 'ThemeDesignerHelper::saveSettings',
			'settings': ThemeDesigner.settings
		}, function(data) {
			// redirect to article from which ThemeDesigner was triggered
			document.location = returnTo;
		}, 'json');
	},


	PickerInit: function() {

	},
	
	showPicker: function(event, type) {
		event.stopPropagation();
		var swatch = $(event.currentTarget);

		//check the type (color or image)
		if (type == "color") {

			//add user color if different than swatches
			var swatches = $("#ThemeDesignerPicker").children(".color").find(".swatches");
			var duplicate = false;
			swatches.find("li").each(function() {
				if (swatch.css("background-color") == $(this).css("background-color")) {
					duplicate = true;
					return false;
				}
			});
			if (!duplicate) {
				swatches.append('<li class="user" style="background-color: ' + swatch.css("background-color") + '"></li>');
			}

			//handle swatch clicking
			swatches.find("li").click(function() {
				var color = ThemeDesigner.rgb2hex($(this).css("background-color"));
				ThemeDesigner.settings[swatch.attr("class")] = color;
				ThemeDesigner.hidePicker();
			});
			
			//handle custom colors
			$("#ColorNameForm").submit(function(event) {
				event.preventDefault();
				
				var color = $("#color-name").val()
				
				// if numbers only, add hash.  
				if (ThemeDesigner.isNumeric(color) && (color.length == 3 || color.length == 6)) {
					color = "#" + color;
				}
				
				ThemeDesigner.settings[swatch.attr("class")] = color;
				ThemeDesigner.hidePicker();
			});
			
			
		} else if (type == "image") {

		}

		//show picker
		$("#ThemeDesignerPicker")
			.css({
				top: swatch.offset().top + 10,
				left: swatch.offset().left + 10
			})
			.removeClass("color image")
			.addClass(type);

		//clicking away will close picker
		$("body").bind("click.picker", ThemeDesigner.hidePicker);
		$("#ThemeDesignerPicker").click(function(event) {
			event.stopPropagation();
		});
	},

	hidePicker: function() {
		$("body").unbind(".picker");
		$("#ColorNameForm").unbind();
		$("#ThemeDesignerPicker")
			.removeClass("color image")
			.find(".user").remove();
		$("#color-name").val("").blur();
		$("#ThemeDesignerPicker").children(".color").find(".swatches").find("li").unbind("click");
		ThemeDesigner.applySettings();
	},

	/**
	 * Converts from rgb(255, 255, 255) to #fff
	 *
	 * Copied here from WikiaPhotoGallery.js
	 */
	rgb2hex: function(rgb) {
		function hex(x) {
			return ("0" + parseInt(x).toString(16)).slice(-2);
		}

		components = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

		if(components) {
			return "#" + hex(components[1]) + hex(components[2]) + hex(components[3]);
		}
		//not an rgb color, probably an hex value has been passed, return it
		else {
			return rgb;
		}
	},
	
	isNumeric: function(input) {
		return (input - 0) == input && input.length > 0;
	}
};