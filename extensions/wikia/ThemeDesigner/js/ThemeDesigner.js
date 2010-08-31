$(function() {
	ThemeDesigner.init();
});

var ThemeDesigner = {

	settings: false,

	init: function() {
		// store current settings
		ThemeDesigner.settings = window.themeSettings;
		$().log(ThemeDesigner.settings, 'ThemeDesigner');

		// iframe resizing
		$(window).resize(ThemeDesigner.resizeIframe).resize();
	},

	resizeIframe: function() {
		$("#PreviewFrame, #EventThief").css("height", $(window).height() - $("#Designer").height());
		$("#EventThief").css("width", $(window).width() - 20);
	}

};