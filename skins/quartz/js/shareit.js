/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
*/
function shareIt_callback(e) {
	YAHOO.util.Event.preventDefault(e);
	var el = YAHOO.util.Event.getTarget(e);
	if(el.nodeName == 'A' || el.nodeName == 'IMG') {
		id = el.id.replace(/_img/,'').replace(/_a/,'');

		if(id == 'shareDelicious') {
			location.href='http://del.icio.us/post?v=4&noui&jump=close&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title);
		} else if(id == 'shareStumble') {
			location.href='http://www.stumbleupon.com/submit?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title);
		} else if(id == 'shareDigg') {
			location.href='http://digg.com/submit?phase=2&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title);
		}
	}
}
function initShareIt() {
	YAHOO.util.Event.addListener('shareIt', 'click',  shareIt_callback);
	YAHOO.util.Event.addListener(['shareEmail_img','shareEmail_a'], 'click', notifyShow);
}
YAHOO.util.Event.onContentReady("shareIt", initShareIt);