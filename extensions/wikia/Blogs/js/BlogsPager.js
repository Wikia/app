function wkBlogShowPage(offset) {
	var wkBlogCurValue = $("#wk-blog-current-page").text();
	var __offset = (!wkBlogCurValue) ? 0 : wkBlogCurValue; __offset = (__offset > 0) ? parseInt(__offset) - 1 : 0;
	var wkBlogLoader = $("#wk_blogs_loader");
	var wkBlogLoader2 = $("#wk_blogs_loader2");

	if (wkBlogLoader) {
		wkBlogLoader.html("<img src=\"http://images.wikia.com/common/skins/common/images/ajax.gif\">");
		wkBlogLoader2.html("<img src=\"http://images.wikia.com/common/skins/common/images/ajax.gif\">");
		offset = parseInt(__offset) + parseInt(offset);
		var params = "&rsargs[0]=" + wgArticleId + "&rsargs[1]=" + wgNamespaceNumber + "&rsargs[2]=" + offset;
		var baseurl = wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params;
		jQuery.get( wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params,
			function(data) {
				if(data) {
					var dataM = $(data).filter('#wk_blogs_article');
					var dataO = $(data).filter('.WikiaBlogListing');
					$(".WikiaBlogListing").empty().append(dataO);
					$("#wk_blogs_article").empty().append(dataM);
					$('html, body').animate({scrollTop: $('body').offset().top}, 400);
				} 
				wkBlogLoader.html("");
				wkBlogLoader2.html("");
			}
		);
	}
	return false;
}
