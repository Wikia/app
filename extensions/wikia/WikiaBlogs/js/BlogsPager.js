function wkBlogShowPage(offset) {
	var wkBlogCurValue = YAHOO.util.Dom.get("wk-blog-current-page");
	var __offset = (!wkBlogCurValue) ? 0 : wkBlogCurValue.innerHTML; __offset = (__offset > 0) ? parseInt(__offset) - 1 : 0;
	var wkBlogLoader = YAHOO.util.Dom.get("wk_blogs_loader");
	var __pagerCallback = {
		success: function( oResponse ) { YAHOO.util.Dom.get("wk_blogs_article").innerHTML = oResponse.responseText; wkBlogLoader.innerHTML = ""; },
		failure: function( oResponse ) { wkBlogLoader.innerHTML = ""; }
	};
	if (wkBlogLoader) {
		wkBlogLoader.innerHTML = "<img src=\"http://images.wikia.com/common/skins/common/images/ajax.gif\">";
		offset = parseInt(__offset) + parseInt(offset);
		var params = "&rsargs[0]=" + wgArticleId + "&rsargs[1]=" + wgNamespaceNumber + "&rsargs[2]=" + offset;
		var baseurl = wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params;
		YAHOO.util.Connect.asyncRequest( "GET", baseurl, __pagerCallback );
	}
}