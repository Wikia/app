/**
 * Plugin that automatically truncates the plain text contents of an element and adds an ellipsis
 */
( function( $ ) {

// Cache ellipsed substrings for every string-width combination
var cache = { };

$.fn.autoEllipsis = function( options ) {
	options = $.extend( {
		'position': 'center',
		'tooltip': false,
		'restoreText': false
	}, options );
	$(this).each( function() {
		var $this = $(this);
		if ( options.restoreText ) {
			if ( ! $this.data( 'autoEllipsis.originalText' ) ) {
				$this.data( 'autoEllipsis.originalText', $this.text() );
			} else {
				$this.text( $this.data( 'autoEllipsis.originalText' ) );
			}
		}
		var text = $this.text();
		var w = $this.width();
		var $text = $( '<span />' ).css( 'whiteSpace', 'nowrap' );
		$this.empty().append( $text );
		
		// Try cache
		if ( !( text in cache ) ) {
			cache[text] = {};
		}
		if ( w in cache[text] ) {
			$text.text( cache[text][w] );
			return;
		}
		
		$text.text( text );
		if ( $text.width() > w ) {
			switch ( options.position ) {
				case 'right':
					// Use binary search-like technique for efficiency
					var l = 0, r = text.length;
					do {
						var m = Math.ceil( ( l + r ) / 2 );
						$text.text( text.substr( 0, m ) + '...' );
						if ( $text.width() > w ) {
							// Text is too long
							r = m - 1;
						} else {
							l = m;
						}
					} while ( l < r );
					$text.text( text.substr( 0, l ) + '...' );
					break;
				case 'center':
					// TODO: Use binary search like for 'right'
					var i = [Math.round( text.length / 2 ), Math.round( text.length / 2 )];
					var side = 1; // Begin with making the end shorter
					while ( $text.outerWidth() > w  && i[0] > 0 ) {
						$text.text( text.substr( 0, i[0] ) + '...' + text.substr( i[1] ) );
						// Alternate between trimming the end and begining
						if ( side == 0 ) {
							// Make the begining shorter
							i[0]--;
							side = 1;
						} else {
							// Make the end shorter
							i[1]++;
							side = 0;
						}
					}
					break;
				case 'left':
					// TODO: Use binary search like for 'right'
					var r = 0;
					while ( $text.outerWidth() > w && r < text.length ) {
						$text.text( '...' + text.substr( r ) );
						r++;
					}
					break;
			}
			if ( options.tooltip )
				$text.attr( 'title', text );
		}
		cache[text][w] = $text.text();
	} );
};

} )( jQuery );