/**
 * MediaWiki legacy wikibits
 *
 * TODO: not loaded yet, calls to deprecated functions need to be replaced first
 *
 * @see http://www.mediawiki.org/wiki/ResourceLoader/JavaScript_Deprecations
 */
(function(){
	window.mwEditButtons = [];
	window.mwCustomEditButtons = [];

	if ( mw.config.get( 'wgBreakFrames' ) ) {
		// Un-trap us from framesets
		if ( window.top != window ) {
			window.top.location = window.location;
		}
	}

	window.redirectToFragment = function( fragment ) {
		if ( window.location.hash == '' ) {
			// Mozilla needs to wait until after load, otherwise the window doesn't
			// scroll.See <https://bugzilla.mozilla.org/show_bug.cgi?id=516293>.
			$(function() {
				window.location.hash = fragment;
			});
		}
	};

	function importAssetPage(server, page, type) {
		var url = '/index.php?title=' + encodeURIComponent(page.replace(/ /g,'_')).replace('%2F','/').replace('%3A',':') + ((type == 'js') ? '&action=raw&ctype=text/javascript' : '&action=raw&ctype=text/css');
		url = window.forceReviewedContent(url);

		if( typeof server == "string" ) {
			if( server.indexOf( '://' ) == -1 && !server.startsWith( '//' ) ) {url = 'http://' + server + '.wikia.com' + url;}
			else {url = server + url;}
		}
		return (type == 'js') ? mw.loader.load(url) : mw.loader.load(url , 'text/css');
	}

	// http://www.wikia.com/wiki/User:Dantman/global.js
	// RT#9031

	window.importScriptPage = function( page, server ) {
		return importAssetPage(page, server, 'js');
	};

	window.importStylesheetPage = function( page, server ) {
		return importAssetPage(page, server, 'css');
	};
})();
