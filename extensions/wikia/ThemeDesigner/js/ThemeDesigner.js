$(function() {
	ThemeDesigner.init();
});

var ThemeDesigner = {

	wordmarkUpload: function(e) {
		if($('#WordMarkUploadFile').val() == '') {
			return false;
		}
	},

	wordmarkUploadCallback : {
		onComplete: function(response) {
			var response = $.evalJSON(response);
			if(response.errors && response.errors.length > 0) {
				alert(response.errors.join("\n"));
			} else {
				alert('This is a wordmark url: ' + response.wordmarkUrl);
			}
		}
	},

	history: false,

	settings: {
		"color-body": "",
		"color-page": "",
		"color-buttons": "",
		"color-links": "",
		"theme": "oasis",
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

	themes: {
		oasis: {
			"color-body": "#BACDD8",
			"color-page": "#FFFFFF",
			"color-buttons": "#006CB0",
			"color-links": "#006CB0",
			"background-image": "oasis.png",
			"background-tiled": true
		},
		sapphire: {
			"color-body": "#2B54B5",
			"color-page": "#FFFFFF",
			"color-buttons": "#0038D8",
			"color-links": "#0148C2",
			"background-image": "sapphire.png",
			"background-tiled": false
		},
		jade: {
			"color-body": "#003816",
			"color-page": "#DFDBC3",
			"color-buttons": "#C5A801",
			"color-links": "#9C030E",
			"background-image": "jade.jpg",
			"background-tiled": false
		},
		sky: {
			"color-body": "#BDEAFD",
			"color-page": "#DEF4FE",
			"color-buttons": "#F9CE3A",
			"color-links": "#285BAF",
			"background-image": "sky.png",
			"background-tiled": false
		},
		moonlight: {
			"color-body": "#000000",
			"color-page": "#CCD9F9",
			"color-buttons": "#6F027C",
			"color-links": "#6F027C",
			"background-image": "moonlight.jpg",
			"background-tiled": false
		},
		obsession: {
			"color-body": "#7A0146",
			"color-page": "#36001F",
			"color-buttons": "#DE1C4E",
			"color-links": "#F97EC4",
			"background-image": "obsession.jpg",
			"background-tiled": true
		},
		carbon: {
			"color-body": "#1A1A1A",
			"color-page": "#474646",
			"color-buttons": "#012E59",
			"color-links": "#70B8FF",
			"background-image": "carbon.png",
			"background-tiled": false
		},
		beach: {
			"color-body": "#97E4FE",
			"color-page": "#FFFFFF",
			"color-buttons": "#C2D04D",
			"color-links": "#FE7801",
			"background-image": "beach.png",
			"background-tiled": true
		},
		dragstrip: {
			"color-body": "#353637",
			"color-page": "#0C0C0C",
			"color-buttons": "#30A900",
			"color-links": "#FFF000",
			"background-image": "dragstrip.jpg",
			"background-tiled": true
		},
		aliencrate: {
			"color-body": "#484534",
			"color-page": "#C6C5C0",
			"color-buttons": "#653F03",
			"color-links": "#02899D",
			"background-image": "aliencrate.jpg",
			"background-tiled": false
		}
	},

	init: function() {
		// apply JS object settings
		$.extend(ThemeDesigner.settings, themeSettings);
		//TODO: temp
		//ThemeDesigner.settings["theme"] = 'custom';

		// settings history
		ThemeDesigner.history = themeHistory;

		$().log(ThemeDesigner, 'ThemeDesigner');

		// iframe resizing
		$(window).resize(ThemeDesigner.resizeIframe).resize();

		// handle navigation clicks
		$("#Navigation a").click(ThemeDesigner.navigationClick);

		// handle "Save" button clicks
		$('#Toolbar').find('button').eq(0).click(ThemeDesigner.saveClick);

		// init theme tab
		ThemeDesigner.ThemeTabInit();

		// init customize tab
		ThemeDesigner.CustomizeTabInit();

		// init wordmark tab
		ThemeDesigner.WordmarkTabInit();

		// click appropriate tab
		if (ThemeDesigner.settings["theme"] == "custom") {
			$('#Navigation [rel="CustomizeTab"]').click();
		} else {
			$('#Navigation [rel="ThemeTab"]').click();
		}

		// init Tool Bar
		ThemeDesigner.ToolBarInit();

		ThemeDesigner.applySettings(true);
	},

	applySettings: function(skipUpdate) {
		/*** Theme Tab ***/
		if (ThemeDesigner.settings["theme"] == "custom") {
			$("#ThemeTab").find(".slider").find(".selected").removeClass("selected");
		}

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

		// Update Preview
		if (!skipUpdate) {
			ThemeDesigner.updatePreview();
		}
	},

	navigationClick: function(event) {
		event.preventDefault();

		var clickedLink = $(this);
		var command = clickedLink.attr("rel");

		clickedLink.parent().addClass("selected").siblings().removeClass("selected");
		$("#" + command).show().siblings("section").hide();
	},

	resizeIframe: function() {
		$("#PreviewFrame").css("height", $(window).height() - $("#Designer").height());
	},


	ThemeTabInit: function() {
		//slider
		$("#ThemeTab .previous, #ThemeTab .next").click(function(event) {
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
		});

		//clicking themes
		$("#ThemeTab").find(".slider").find("li").click(function() {
			//set up vars
			var theme = $(this).attr("data-theme");
			var themeSettings = ThemeDesigner.themes[theme];

			//highlight selected theme
			$(this).parent().find(".selected").removeClass("selected");
			$(this).addClass("selected");

			//set settings
			$.extend(ThemeDesigner.settings, themeSettings);
			ThemeDesigner.settings["theme"] = theme;

			//apply settings
			ThemeDesigner.applySettings();
		});

		//select current theme
		$("#ThemeTab").find('[data-theme=	' + ThemeDesigner.settings["theme"] + ']').addClass("selected");

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
			ThemeDesigner.applySettings(true);
			$("#wordmark, #wordmark-edit").toggle();
		});
	},

	updatePreview: function() {
		//CSS
		var sass = "/__sass/skins/oasis/css/oasis.scss/128263333333333333333127999/";
		sass += "color-body=" + escape(ThemeDesigner.settings["color-body"]);
		sass += "&color-page=" + escape(ThemeDesigner.settings["color-page"]);
		sass += "&color-buttons=" + escape(ThemeDesigner.settings["color-buttons"]);
		sass += "&color-links=" + escape(ThemeDesigner.settings["color-links"]);
		sass += "&background-image=" + escape(ThemeDesigner.settings["background-image"]);
		sass += "&background-tiled=" + escape(ThemeDesigner.settings["background-tiled"]);
		document.getElementById('PreviewFrame').contentWindow.ThemeDesignerPreview.loadSASS(sass);

		//Wordmark text
		$("#PreviewFrame").contents().find("#WikiHeader").find(".wordmark")
				.removeClass()
				.addClass("wordmark")
				.addClass(ThemeDesigner.settings["wordmark-font"])
				.addClass(ThemeDesigner.settings["wordmark-size"])
				.find("a").text(ThemeDesigner.settings["wordmark-text"])
	},

	saveClick: function(event) {
		event.preventDefault();

		$(event.target).attr('disabled', true);

		ThemeDesigner.save();
	},

	save: function() {
		$().log(ThemeDesigner.settings, 'ThemeDesigner');

		// send current settings to backend
		$.post(wgServer + wgScript + '?action=ajax&rs=moduleProxy&moduleName=ThemeDesigner&actionName=SaveSettings&outputType=data',
			{'settings': ThemeDesigner.settings},
			function(data) {
				document.location = returnTo; // redirect to article from which ThemeDesigner was triggered
			},
			'json');
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
				ThemeDesigner.settings["theme"] = "custom";
				ThemeDesigner.applySettings();
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
				ThemeDesigner.settings["theme"] = "custom";
				ThemeDesigner.applySettings();
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
	},

	ToolBarInit: function() {
		$("#Toolbar .history").click(function() {
			$(this).find("ul").css("display", "block");
		});
		$("#Toolbar .history ul").mouseleave(function() {
			$(this).css("display", "none");
		});
		$("#Toolbar .history ul li").click(ThemeDesigner.revertToPreviousTheme);

		// temp code and mock data for testing and placeholder, load ThemeDesigner.history here later
		var clonedSettings1 = $.extend(true, {}, ThemeDesigner.settings);
		var clonedSettings2 = $.extend(true, {}, ThemeDesigner.settings);
		var clonedDefault = $.extend(true, {}, ThemeDesigner.settings);
		clonedSettings1["color-body"] = "red";
		clonedSettings2["color-body"] = "blue";
		$("#Toolbar .history ul li").first().data("settings", clonedSettings1);
		$("#Toolbar .history ul li").next().data("settings", clonedSettings2);
		$("#Toolbar .history ul li").last().data("settings", clonedDefault);
		// end temp code
	},

	revertToPreviousTheme: function(event) {
		event.preventDefault();
		if($(this).data("settings")) {
			ThemeDesigner.settings = $(this).data("settings");
			ThemeDesigner.applySettings();
		}
	}
};