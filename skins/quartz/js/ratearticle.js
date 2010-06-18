/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
*/
YAHOO.util.Event.onDOMReady(function() {
	YAHOO.util.Event.addListener('unrateLink', 'click', unrateArticle);
	YAHOO.util.Event.addListener(['star1','star2','star3','star4','star5'], 'click', rateArticle);
});
var rateArticle_callback = {
    success: function(o) {
		o = eval("("+o.responseText+")");
		YAHOO.util.Dom.setStyle('current-rating', 'width', Math.round(o.item.wkvoteart[0].avgvote * $('#star-rating').attr('rel'))+'px');
		YAHOO.util.Dom.setStyle(['star1','star2','star3','star4','star5'], 'display', o.item.wkvoteart[0].remove ? '' : 'none');
		YAHOO.util.Dom.setStyle('unrateLink', 'display', o.item.wkvoteart[0].remove ? 'none' : '');
		YAHOO.util.Dom.removeClass('star-rating', 'star-rating-progress');
		YAHOO.util.Connect.asyncRequest('POST', window.location.href, null, "action=purge");
	}
}
function rateArticle(e) {
	YAHOO.util.Event.preventDefault(e);
	var rating = this.id.substr(4,1);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath+'/api.php?action=insert&list=wkvoteart&format=json&wkvote='+rating+'&wkpage='+wgArticleId, rateArticle_callback);
	YAHOO.util.Dom.addClass('star-rating', 'star-rating-progress');
}
function unrateArticle(e) {
	YAHOO.util.Event.preventDefault(e);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath+'/api.php?action=wdelete&list=wkvoteart&format=json&wkpage='+wgArticleId, rateArticle_callback);
	YAHOO.util.Dom.addClass('star-rating', 'star-rating-progress');
	YAHOO.util.Dom.setStyle('unrateLink', 'display', 'none');
}