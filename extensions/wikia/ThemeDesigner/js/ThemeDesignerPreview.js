var ThemeDesignerPreview = {
	init: function() {
		$("#WikiaArticle figure")
			.first()
			.addClass("tright")
			.css("width", 300)
			.find("a")
			.first()
			.html(
				'<img width="300" src="' + wgExtensionsPath + '/wikia/ThemeDesigner/images/aquarium.jpg">'
			);

		$("a.new").removeClass("new");

		//no floating footer on preview
		$(window).unbind("scroll").unbind("resize");
		$("#WikiaFooter").removeClass("float");
		//click mask
		$("body").append('<div id="clickmask" class="clickmask"></div>');
	},

	loadSASS: function(settings) {
		var sassUrl = $.getSassCommonURL('/skins/oasis/css/oasis.scss', settings);
		$("#clickmask").animate({"opacity": 0.65}, "fast", function() {
			$.getCSS(sassUrl, function(link) {
				$(ThemeDesignerPreview.link).remove();
				ThemeDesignerPreview.link = link;
				$("#clickmask").animate({"opacity": 0}, "fast");
			});
		});
	}
};

$(function() {
	ThemeDesignerPreview.init();
});
