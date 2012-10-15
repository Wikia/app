/**
 * SlimboxThumbs extensions /rewritten/
 * License: GNU GPL 3.0 or later
 * Contributor(s): Vitaliy Filippov <vitalif@mail.ru>
 */
var slimboxSizes = {};
function makeSlimboxThumbs( $, wgUploadPath, wgFullScriptPath ) {
	var re = new RegExp( wgUploadPath+'/thumb' );
	var links = [];
	var ww = $( window ).width() * 0.8;
	var wh = $( window ).height() * 0.8;
	$( 'img' ).each( function( i, e ) {
		if ( re.exec( e.src ) && e.parentNode.nodeName == 'A' ) {
			var h = e.src.replace( '/thumb', '' ).replace( /\/[^/]+$/, '' );
			var n = unescape( h.substr( h.lastIndexOf( '/' )+1 ).replace( /_/g, ' ' ) );
			if ( slimboxSizes[n] && ( slimboxSizes[n][0] > ww || slimboxSizes[n][1] > wh ) ) {
				var sc = ww;
				var sh = Math.round( slimboxSizes[n][0] * wh / slimboxSizes[n][1] );
				if ( sh < sc ) sc = sh;
				h = wgFullScriptPath + '/thumb.php?f=' + escape(n) + '&w=' + sc;
			}
			e.parentNode._lightbox = [ h, '<a href="'+e.parentNode.href+'">'+n+'</a>' ];
			links.push( e.parentNode );
		}
	} );
	$( links ).slimbox({ captionAnimationDuration: 0 }, function( e, i ) {
		return e._lightbox;
	}, function() { return true; });
}
