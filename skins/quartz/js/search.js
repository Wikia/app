/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
*/
function initSearch() {
	var done = false;
	var searchField_callback = function () {
		if ( ! done ) {
			done = true;
			YAHOO.util.Dom.get('searchfield').value = '';
			YAHOO.util.Dom.replaceClass('searchfield', 'gray', 'black');
		}
	}
	YAHOO.util.Event.addListener('searchfield', 'focus',  searchField_callback);

	var searchSubmit_callback = function () {
		YAHOO.util.Dom.get('searchform').submit();
	}
	YAHOO.util.Event.addListener('searchSubmit', 'click',  searchSubmit_callback);
};
YAHOO.util.Event.onContentReady("searchform", initSearch);