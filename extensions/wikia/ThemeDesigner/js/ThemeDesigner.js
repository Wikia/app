$(function() {
	ThemeDesigner.init();
});

var ThemeDesigner = {

	settings: {
		"color-body": "",
		"color-page": "",
		"color-buttons": "",
		"color-links": "",
		"theme": "",
		"wordmark-text": "",
		"wordmark-color": "",
		"wordmark-font": "Orbitron",
		"wordmark-font-size": "",
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
		ThemeDesigner.applySettings();

		$().log(ThemeDesigner.settings, 'ThemeDesigner');

		// iframe resizing
		$(window).resize(ThemeDesigner.resizeIframe).resize();

		// handle navigation clicks
		$("#Navigation a").click(ThemeDesigner.navigationClick);

		// init theme tab
		ThemeDesigner.ThemeTabInit();

		// init wordmark tab
		ThemeDesigner.WordmarkTabInit();

		// click first tab
		$("#Navigation a:first").click();
	},

	applySettings: function() {
		$("#swatch-color-background").css("background-color", ThemeDesigner.settings["color-body"]);
		$("#swatch-color-buttons").css("background-color", ThemeDesigner.settings["color-buttons"]);
		$("#swatch-color-links").css("background-color", ThemeDesigner.settings["color-links"]);
		$("#swatch-color-page").css("background-color", ThemeDesigner.settings["color-page"]);
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

		var slideTo = (arrow.hasClass("previous")) ? -760 : 0;
		list.animate({
			marginLeft: slideTo
		}, "slow");
		$("#ThemeTab .next, #ThemeTab .previous").toggleClass("disabled");
	},

	WordmarkTabInit: function() {
		var fonts = ["Helvetica", "Capralba", "Fontin", "IM Fell", "Josefin Sans", "Orbitron", "Prociono", "Reenie Beanie", "Tangerine", "Titillium", "Yanone Kaffeesatz"];

		// populate font menu
		var options = '';
		for(i=0; i<fonts.length; i++) {
			var selected = '';
			if (ThemeDesigner.settings["wordmark-font"] == fonts[i]) {
				selected = ' selected="selected"';
			}
			options += '<option value="' + fonts[i] + '"' + selected +'>' + fonts[i] + '</option>';
		}
		$("#wordmark-font").html(options);

		// populate wordmark text
		$("#wordmark").html(ThemeDesigner.settings["wordmark-text"]);
	}

};