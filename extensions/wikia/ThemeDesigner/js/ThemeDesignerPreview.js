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
