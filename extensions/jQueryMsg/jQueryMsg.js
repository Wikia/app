
jQuery( document ).ready( function( $ ) {
	// add "magic" to Language template parser for keywords
	var options = { magic: { 'SITENAME' : mw.config.get( 'wgSiteName' ) } };
	
	window.gM = mediaWiki.language.getMessageFunction( options );
	$.fn.msg = mediaWiki.language.getJqueryMessagePlugin( options );
} );
