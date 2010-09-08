$(function() {
	$("#WikiaArticle .thumbinner")
		.first()
		.attr("style", "width:302px")
		.find("a")
		.first()
		.html(
			'<img width="300" src="/extensions/wikia/ThemeDesigner/images/aquarium.jpg">'
		);	
		
	$("#WikiaArticle .thumbinner").append('<div class="picture-attribution"><img width="16" height="16" class="avatar" src="/extensions/wikia/ThemeDesigner/images/td-avatar.jpg">Added by <a>FunnyBunny</a></div>');
	
});