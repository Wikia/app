var ThemeDesignerPreview = {
	init: function() {
		$("#WikiaArticle .thumbinner")
			.first()
			.attr("style", "width:302px")
			.find("a")
			.first()
			.html(
				'<img width="300" src="' + wgExtensionsPath + '/wikia/ThemeDesigner/images/aquarium.jpg">'
			);

		$("#WikiaArticle .thumbinner").append('<div class="picture-attribution"><img width="16" height="16" class="avatar" src="' + wgExtensionsPath + '/wikia/ThemeDesigner/images/td-avatar.jpg">Added by <a>FunnyBunny</a></div>');
		$("a.new").removeClass("new");

		//no floating footer on preview
		$(window).unbind("scroll").unbind("resize");
		$("#WikiaFooter").removeClass("float");
		//click mask
		$("body").append('<div id="clickmask" class="clickmask"></div>');
	},

	loadSASS: function(settings) {
		var paths = [
				'/skins/oasis/css/oasis.scss'
			],
			urls = [];

		$.each(paths, function(i, path) {
			urls.push($.getSassCommonURL(path, settings));
		});

		//fade out
		$("#clickmask").animate({"opacity": 0.65}, "fast", function() {
			var styleSheetsToRemove = [];

			// Find duplicate existing stylesheets and queue them for removal
			$.each(document.styleSheets, function(i, styleSheet) {
				if (styleSheet) {
					$.each(paths, function(j, path) {
						if (styleSheet.href && ~styleSheet.href.indexOf(path)) {
							styleSheetsToRemove.push(styleSheet.ownerNode);
						}
					});
				}
			});

			// Load and inject the new stylesheets
			$.getResources(urls, function() {
				$(styleSheetsToRemove).remove();
				$("#clickmask").animate({"opacity": 0}, "fast");
			});
		});
	}
};

$(function() {
	ThemeDesignerPreview.init();
});
