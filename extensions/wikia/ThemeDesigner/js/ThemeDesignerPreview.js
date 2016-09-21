var ThemeDesignerPreview = {
	init: function() {
		$(".portable-infobox h2")
			.first()
			.after(
				'<figure class="pi-item pi-image">'+
				'<a href="#" class="image image-thumbnail" title="">' +
				'<img width="100%" src="' + wgExtensionsPath + '/wikia/ThemeDesigner/images/aquarium.jpg">' +
				'</a>' +
				'</figure>'
			);

		$("a.new").removeClass("new");

		//no floating footer on preview
		$(window).unbind("scroll").unbind("resize");
		$("#WikiaFooter").removeClass("float");
		//click mask
		$("body").append('<div id="clickmask" class="clickmask"></div>');
	},

	loadSASS: function(settings) {
		var sassUrl = $.getSassesURL([
			'/skins/oasis/css/oasis.scss',
			'/extensions/wikia/PortableInfobox/styles/PortableInfobox.scss',
			'/extensions/wikia/PortableInfobox/styles/PortableInfoboxEuropaTheme.scss'
		], settings);

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
