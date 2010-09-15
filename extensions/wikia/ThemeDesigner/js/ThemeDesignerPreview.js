$(function() {
	ThemeDesignerPreview.init();
});

var ThemeDesignerPreview = {
	init: function() {
		$("#WikiaArticle .thumbinner")
			.first()
			.attr("style", "width:302px")
			.find("a")
			.first()
			.html(
				'<img width="300" src="/extensions/wikia/ThemeDesigner/images/aquarium.jpg">'
			);	
			
		$("#WikiaArticle .thumbinner").append('<div class="picture-attribution"><img width="16" height="16" class="avatar" src="/extensions/wikia/ThemeDesigner/images/td-avatar.jpg">Added by <a>FunnyBunny</a></div>');
		$("a.new").removeClass("new");
		
		//no floating footer on preview
		$("#WikiaFooter").children(".toolbar").removeClass("float");
		$(window).unbind("scroll");
	},

	loadSASS: function(url) {
		$("#clickmask").animate({"opacity": .65}, "fast");
		$('<style class="ThemeDesignerPreviewSASS">').appendTo("head").load(url, function() {
			$(this).prev(".ThemeDesignerPreviewSASS").remove();
			$("#clickmask").animate({"opacity": 0}, "fast");
		});
	}
};