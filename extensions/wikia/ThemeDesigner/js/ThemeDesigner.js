$(function() {
	ThemeDesigner.init();
});

var ThemeDesigner = {

	init: function() {

		// theme settings
		ThemeDesigner.settings = themeSettings

		// settings history
		ThemeDesigner.history = themeHistory;

		$().log(ThemeDesigner, 'ThemeDesigner');

		// iframe resizing
		$(window).resize(ThemeDesigner.resizeIframe).resize();

		// handle navigation clicks - switching between tabs
		$("#Navigation a").click(ThemeDesigner.navigationClick);

		// handle "Save" button clicks
		$('#Toolbar').find(".save").click(ThemeDesigner.saveClick);

		// handle "Cancel" button clicks
		$('#Toolbar').find(".cancel").click(ThemeDesigner.cancelClick);

		// init tabs
		ThemeDesigner.ThemeTabInit();
		ThemeDesigner.CustomizeTabInit();
		ThemeDesigner.WordmarkTabInit();

		// click appropriate tab based on the settings
		if(ThemeDesigner.settings["theme"] == "custom") {
			$('#Navigation [rel="CustomizeTab"]').click();
		} else {
			$('#Navigation [rel="ThemeTab"]').click();
		}

		// init Tool Bar
		ThemeDesigner.ToolBarInit();

		ThemeDesigner.applySettings(false, false);
	},

	ThemeTabInit: function() {

		// click handler for next and previous arrows in theme slider
		$("#ThemeTab .previous, #ThemeTab .next").click(function(event) {
			event.preventDefault();
			var list = $("#ThemeTab .slider ul");
			var arrow = $(this);

			// prevent disabled clicks
			if(arrow.hasClass("disabled")) {
				return;
			}

			var slideTo = (arrow.hasClass("previous")) ? 0 : -760;
			list.animate({marginLeft: slideTo}, "slow");
			$("#ThemeTab .next, #ThemeTab .previous").toggleClass("disabled");
		});

		// click handler for themes thumbnails
		$("#ThemeTab").find(".slider").find("li").click(function() {
			// highlight selected theme
			$(this).parent().find(".selected").removeClass("selected");
			$(this).addClass("selected");

			ThemeDesigner.set("theme", $(this).attr("data-theme"));
		});

		// select current theme
		$("#ThemeTab").find('[data-theme=' + ThemeDesigner.settings["theme"] + ']').addClass("selected");
	},

	CustomizeTabInit: function() {
		$("#CustomizeTab").find("li").find("img[id*='color']").click(function(event) {
			ThemeDesigner.showPicker(event, "color");
		});
	},

	WordmarkTabInit: function() {
		// handle font family and font size menu change
		$("#wordmark-font").change(function() { ThemeDesigner.set("wordmark-font", $(this).val()); });
		$("#wordmark-size").change(function() { ThemeDesigner.set("wordmark-size", $(this).val()); });

		// handle wordmark editing
		$("#wordmark-edit-button").click(function(event) {
			event.preventDefault();
			$("#wordmark, #wordmark-edit").toggle();
		});

		$("#wordmark-edit").find("button").click(function(event) {
			event.preventDefault();
			ThemeDesigner.set("wordmark-text", $("#wordmark-edit").find('input[type="text"]').val());
			$("#wordmark, #wordmark-edit").toggle();
		});
	},

	ToolBarInit: function() {
		$("#Toolbar .history").click(function() { $(this).find("ul").css("display", "block"); });
		$("#Toolbar .history ul").mouseleave(function() { $(this).css("display", "none"); });
		$("#Toolbar .history ul li").click(ThemeDesigner.revertToPreviousTheme);
	},

	showPicker: function(event, type) {
		event.stopPropagation();
		var swatch = $(event.currentTarget);

		// check the type (color or image)
		if(type == "color") {

			//add user color if different than swatches
			var swatches = $("#ThemeDesignerPicker").children(".color").find(".swatches");
			var duplicate = false;
			swatches.find("li").each(function() {
				if(swatch.css("background-color") == $(this).css("background-color")) {
					duplicate = true;
					return false;
				}
			});

			if(!duplicate) {
				swatches.append('<li class="user" style="background-color: ' + swatch.css("background-color") + '"></li>');
			}

			// handle swatch clicking
			swatches.find("li").click(function() {
				ThemeDesigner.hidePicker();
				ThemeDesigner.set(swatch.attr("class"), ThemeDesigner.rgb2hex($(this).css("background-color")));
				ThemeDesigner.set("theme", "custom");
			});

			//handle custom colors
			$("#ColorNameForm").submit(function(event) {
				event.preventDefault();

				var color = $("#color-name").val()

				// if numbers only, add hash.
				if(ThemeDesigner.isNumeric(color) && (color.length == 3 || color.length == 6)) {
					color = "#" + color;
				}

				ThemeDesigner.hidePicker();
				ThemeDesigner.set(swatch.attr("class"), color);
				ThemeDesigner.set("theme", "custom");
			});

		} else if (type == "image") {
			///
		}

		// show picker
		$("#ThemeDesignerPicker")
			.css({
				top: swatch.offset().top + 10,
				left: swatch.offset().left + 10
			})
			.removeClass("color image")
			.addClass(type);

		// clicking away will close picker
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
	 * @author: Inez Korczynski
	 */
	set: function(setting, newValue) {
		$().log("Setting: '" + setting + "' to: '" + newValue + "'");

		ThemeDesigner.settings[setting] = newValue;

		if(setting == "wordmark-image-name") {
			return;
		}

		if(setting == "theme" && newValue != "custom") {
			$.extend(ThemeDesigner.settings, ThemeDesigner.themes[newValue]);
		}

		var reloadCSS = false;
		var updateSkinPreview = false;

		if(setting == "color-body" || setting == "color-page" || setting == "color-buttons" || setting == "color-links" || setting == "background-image" || setting == "background-tiled") {
			reloadCSS = true;
		}

		if(setting == "wordmark-font" || setting == "wordmark-size" || setting == "wordmark-text") {
			updateSkinPreview = true;
		}

		ThemeDesigner.applySettings(reloadCSS, updateSkinPreview);
	},

	/**
	 * Async callback for uploading wordmark image
	 *
	 * @author: Inez Korczynski
	 */
	wordmarkUploadCallback : {
		onComplete: function(response) {

			var response = $.evalJSON(response);

			if(response.errors && response.errors.length > 0) {

				alert(response.errors.join("\n"));

			} else {

				ThemeDesigner.set("wordmark-image-name", response.wordmarkImageName);
				ThemeDesigner.set("wordmark-image-url", response.wordmarkImageUrl);

			}
		}
	},

	/**
	 * Wordmark image upload button handler which cancel async request when image is not selected
	 *
	 * @author: Inez Korczynski
	 */
	wordmarkUpload: function(e) {

		if($('#WordMarkUploadFile').val() == '') {
			return false;
		}

	},

	revertToPreviousTheme: function(event) {
		event.preventDefault();
		ThemeDesigner.settings = ThemeDesigner.history[$(this).index()]['settings'];
		ThemeDesigner.applySettings(true, true);
	},

	cancelClick: function(event) {
		event.preventDefault();
		document.location = returnTo;
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

	history: false,

	settings: false,

	themes: false,

	applySettings: function(reloadCSS, updateSkinPreview) {

		/*** Theme Tab ***/
		if(ThemeDesigner.settings["theme"] == "custom") {
			$("#ThemeTab").find(".slider").find(".selected").removeClass("selected");
		}

		/*** Customize Tab ***/
		// color swatches
		$("#swatch-color-background").css("background-color", ThemeDesigner.settings["color-body"]);
		$("#swatch-color-buttons").css("background-color", ThemeDesigner.settings["color-buttons"]);
		$("#swatch-color-links").css("background-color", ThemeDesigner.settings["color-links"]);
		$("#swatch-color-page").css("background-color", ThemeDesigner.settings["color-page"]);

		/*** Wordmark Tab ***/
		// style wordmark preview
		$("#wordmark").removeClass().addClass(ThemeDesigner.settings["wordmark-font"]).addClass(ThemeDesigner.settings["wordmark-size"]).html(ThemeDesigner.settings["wordmark-text"]);

		// populate wordmark editor
		$("#wordmark-edit").find('input[type="text"]').val(ThemeDesigner.settings["wordmark-text"]);

		// select current font
		$("#wordmark-font").find('[value="' + ThemeDesigner.settings["wordmark-font"] + '"]').attr("selected", "selected");

		// select current size
		$("#wordmark-size").find('[value="' + ThemeDesigner.settings["wordmark-size"] + '"]').attr("selected", "selected");

		//wordmark image
		$("#WordmarkTab").find(".graphic").find(".preview").attr("src", ThemeDesigner.settings["wordmark-image-url"]);

		if(reloadCSS) {
			var sass = "/__sass/skins/oasis/css/oasis.scss/128263333333333333333127999/";
			sass += "color-body=" + escape(ThemeDesigner.settings["color-body"]);
			sass += "&color-page=" + escape(ThemeDesigner.settings["color-page"]);
			sass += "&color-buttons=" + escape(ThemeDesigner.settings["color-buttons"]);
			sass += "&color-links=" + escape(ThemeDesigner.settings["color-links"]);
			sass += "&background-image=" + escape(ThemeDesigner.settings["background-image"]);
			sass += "&background-tiled=" + escape(ThemeDesigner.settings["background-tiled"]);
			document.getElementById('PreviewFrame').contentWindow.ThemeDesignerPreview.loadSASS(sass);
		}

		if(updateSkinPreview) {
			$("#PreviewFrame").contents().find("#WikiHeader").find(".wordmark")
				.removeClass()
				.addClass("wordmark")
				.addClass(ThemeDesigner.settings["wordmark-font"])
				.addClass(ThemeDesigner.settings["wordmark-size"])
				.find("a").text(ThemeDesigner.settings["wordmark-text"])
		}
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