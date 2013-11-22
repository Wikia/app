/* Lazy loading for images inside articles (skips wikiamobile)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

$(function() {
	'use strict';

	// it's a global, it should be a global
	var ImgLzy = {
		cache: [],
		timestats: 0,
		lastScrollTop: 0,

		init: function() {
			var self = this,
				throttled;
			self.createCache();
			self.checkAndLoad();
			throttled = $.throttle( 250, $.proxy( self.checkAndLoad, self ) );
			$( window ).on( 'scroll', throttled );
		},

		createCache: function() {
			var self = this;
			self.cache = [];
			$( 'img.lzy' ).each(function( idx ) {
				var cacheItem = [],
					$el = $( this ),
					top = $el.offset().top;
				cacheItem.push( this );
				cacheItem.push ( $el );
				cacheItem.push( top );
				cacheItem.push( $el.height() + top );
				self.cache[ idx ] = cacheItem;
			});
		},

		verifyCache: function() {
			if( this.cache.length === 0 ) {
				return;
			}
			// make sure that position of elements in the cache didn't change
			var lastidx = this.cache.length - 1,
				randidx = Math.floor( Math.random() * lastidx ),
				checkidx = [ lastidx, randidx ],
				changed = false,
				i,
				idx,
				pos,
				diff;
			for( i in checkidx ) {
				idx = checkidx[ i ];
				if( idx in this.cache ) {
					pos = this.cache[ idx ][ 1 ].offset().top;
					diff = Math.abs( pos - this.cache[ idx ][ 2 ] );
					if ( diff > 5 ) {
						changed = true;
						break;
					}
				}
			}
			if ( changed ) {
				this.createCache();
			}
		},

		load: function( image ) {
			// this code can only be run from AJAX requests (ie. ImgLzy is registered AFTER DOM ready event
			// so those are new images in DOM
			var $img = $( image ),
				dataSrc = $img.data( 'src' );
			image.onload = '';
			if ( dataSrc ) {
				image.src = dataSrc;
			}
			$img.removeClass( 'lzy' ).removeClass( 'lzyPlcHld' );

		},

		checkAndLoad: function() {
			//var timestart = ( new Date() ).getTime();

			this.verifyCache();

			var scrollTop = $( window ).scrollTop(),
				scrollSpeed = Math.abs( scrollTop - this.lastScrollTop ),
				scrollBottom,
				onload,
				idx,
				cacheEl,
				el,
				$el,
				elTop,
				elBottom;

			scrollSpeed = Math.min( scrollSpeed, 1000 ) * 3 + 200;
			this.lastScrollTop = scrollTop;
			scrollBottom = scrollTop + $( window ).height() + scrollSpeed;
			scrollTop = scrollTop - scrollSpeed;
			onload = function() {
				this.setAttribute( 'class', this.getAttribute( 'class' ) + ' lzyLoaded' );
			};
			for ( idx in this.cache ) {
				cacheEl = this.cache[ idx ];
				el = cacheEl[ 0 ];
				$el = cacheEl[ 1 ];
				elTop = cacheEl[ 2 ];
				elBottom = cacheEl[ 3 ];
				if( ( scrollTop < elTop && scrollBottom > elTop ) ||
					( scrollTop < elBottom && scrollBottom > elBottom ) ) {
					$el.addClass( 'lzyTrns' );
					el.onload = onload;
					el.src = $el.data( 'src' );
					$el.removeClass( 'lzy' );
					delete this.cache[ idx ];
				}
			}
			//this.timestats = ( new Date() ).getTime() - timestart;
			//console.log( this.timestats );
		}
	};

	ImgLzy.init();

	// fix iOS bug - not firing scroll event when after refresh page is opened in the middle of its content
	require( [ 'wikia.browserDetect', 'wikia.window' ], function( browserDetect, w ) {
		if ( browserDetect.isIPad() ) {
			w.addEventListener( 'pageshow', function() {
				$.proxy( ImgLzy.checkAndLoad, ImgLzy );
			} );
		}

	} );

	window.ImgLzy = ImgLzy;
});
