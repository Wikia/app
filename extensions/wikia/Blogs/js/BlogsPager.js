function wkBlogShowPage(offset) {
	var wkBlogCurValue = $("#wk-blog-current-page").text();
	var __offset = (!wkBlogCurValue) ? 0 : wkBlogCurValue; __offset = (__offset > 0) ? parseInt(__offset) - 1 : 0;
	var wkBlogLoader = $("#wk_blogs_loader");
	var wkBlogLoader2 = $("#wk_blogs_loader2");

	if (wkBlogLoader) {
		wkBlogLoader.html("<img src=\"http://images.wikia.com/common/skins/common/images/ajax.gif\">");
		wkBlogLoader2.html("<img src=\"http://images.wikia.com/common/skins/common/images/ajax.gif\">");
		offset = parseInt(__offset) + parseInt(offset);
		var params = "&rsargs[0]=" + wgArticleId + "&rsargs[1]=" + wgNamespaceNumber + "&rsargs[2]=" + offset + "&rsargs[3]=" + (skin && skin == 'oasis' ? 'oasis' : 'monaco');
		var baseurl = wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params;
		$.get( wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params,
			function(data) {
				if(data) {
					if(skin == 'oasis') {
						$(".WikiaBlogListing").empty().append(data);
					} else {
						$("#wk_blogs_article").empty().append(data);
					}
					$('html, body').animate({scrollTop: $('body').offset().top}, 400);
				}
				wkBlogLoader.html("");
				wkBlogLoader2.html("");
			}
		);
	}
}
