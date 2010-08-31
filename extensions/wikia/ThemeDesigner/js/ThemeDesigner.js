$(function() {
	ThemeDesigner.init();
});

var ThemeDesigner = {

	init: function() {
		
		//iframe resizing
		$(window).resize(ThemeDesigner.resizeIframe).resize();
	},
	
	resizeIframe: function() {
		$("#PreviewFrame, #EventThief").css("height", $(window).height() - $("#Designer").height());
		$("#EventThief").css("width", $(window).width() - 20);
	}

};