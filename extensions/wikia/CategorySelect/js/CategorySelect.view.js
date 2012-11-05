(function( window, $ ) {

var action = window.wgAction,
	Wikia = window.Wikia || {};

// This file is included on every page, but should only run on view or purge.
if ( action != 'view' && action != 'purge' ) {
	return;
}



})( window, jQuery );