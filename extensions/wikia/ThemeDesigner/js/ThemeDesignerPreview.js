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
		$(window).unbind("scroll").unbind("resize");
		$("#WikiaFooter").children(".toolbar").removeClass("float").css({
			left: "50%",
			right: "auto"
		});
		//click mask
		$("body").append('<div id="clickmask" class="clickmask"></div>');
	},

	loadSASS: function(url) {
		//fade out
		$("#clickmask").animate({"opacity": .65}, "fast", function() {
			//mark old stylesheet(s) for removal
			$(".ThemeDesignerPreviewSASS").addClass("remove");
			//ajax request for new stylesheet
			$.get(url, function(data) {
				//add new stylesheet to head
				$('<style class="ThemeDesignerPreviewSASS">' + data + '</style>').appendTo("head");
				//remove marked stylesheets
				$(".ThemeDesignerPreviewSASS.remove").remove();
				//fade in
				$("#clickmask").animate({"opacity": 0}, "fast");
			});
		});
	}
};