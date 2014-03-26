/*global syslogReport: true */
/* Lazy loading for images inside articles (skips wikiamobile)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */
require( [ 'jquery', 'wikia.log', 'wikia.browserDetect', 'wikia.window' ], function( $, log, browserDetect, w ) {
	'use strict';

	var browserSupportsWebP,
		ImgLzy;

	function checkWebPSupport() {
		log('checking WebP support...',  log.levels.info, 'ImgLzy');

		// @see http://stackoverflow.com/a/5573422
		var webP = new Image();
		webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
		webP.onload = webP.onerror = function () {
			browserSupportsWebP = webP.height === 2;

			log('has support for WebP: ' + (browserSupportsWebP ? 'yes' : 'no'),  log.levels.info, 'ImgLzy');

			// report WebP support stats to Kibana
			if ( w.wgEnableWebPSupportStats === true && typeof syslogReport === 'function' ) {
				syslogReport(log.levels.info, 'webp', {'webp-support': browserSupportsWebP ? 'yes' : 'no'});
			}
		};
	}

	// it's a global, it should be a global
	ImgLzy = {
		cache: [],
		timestats: 0,

		init: function() {
			var proxy = $.proxy( this.checkAndLoad, this ),
				throttled = $.throttle( 250, proxy );

			this.createCache();
			this.checkAndLoad();

			$( window ).on( 'scroll', throttled );
			$( '.scroller' ).on( 'scroll', throttled );
			$( document ).on( 'tablesorter_sortComplete', proxy );

			log('initialized', log.levels.info, 'ImgLzy');
		},

		relativeTop: function( e ) {
			return e.offset().top - e.parents( '.scroller' ).offset().top;
		},

		absTop: function( e ) {
			return e.offset().top;
		},

		// rewrite the URL to request WebP thumbnails (if enabled on this wiki and supported by the browser)
		rewriteURLForWebP: function(src) {
			if ( w.wgEnableWebPThumbnails === true && browserSupportsWebP && src.indexOf( '/images/thumb/' ) > 0 ) {
				src = src.replace( /\.[^\./]+$/, '.webp' );
			}
			return src;
		},

		createCache: function() {
			var self = this;
			self.cache = [];
			$( 'img.lzy' ).each( function( idx ) {
				var $el = $( this ),
					relativeTo = $( '.scroller' ).find( this ),
					topCalc, top;

				if ( relativeTo.length !== 0 ) {
					relativeTo = relativeTo.parents( '.scroller' );
					topCalc = self.relativeTop;
				} else {
					relativeTo = $( window );
					topCalc = self.absTop;
				}

				top = topCalc( $el );
				self.cache[idx] = {
					el: this,
					jq: $el,
					topCalc: topCalc,
					top: top,
					bottom: $el.height() + top,
					parent: relativeTo
				};
			} );
		},

		verifyCache: function() {
			if ( this.cache.length === 0 ) {
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
			for ( i in checkidx ) {
				idx = checkidx[ i ];
				if ( idx in this.cache ) {
					pos = this.cache[idx].topCalc( this.cache[idx].jq );
					diff = Math.abs( pos - this.cache[idx].top );

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
				image.src = this.rewriteURLForWebP( dataSrc );
			}
			$img.removeClass( 'lzy' ).removeClass( 'lzyPlcHld' );
		},

		parentVisible: function( item ) {
			if ( item.parent[0] === window ) {
				return true;
			}

			var fold = $( window ).scrollTop() + $( window ).height(),
				parentTop = item.parent.offset().top;

			return fold > parentTop;
		},

		checkAndLoad: function() {
			//var timestart = ( new Date() ).getTime();

			this.verifyCache();

			var onload = function() {
					this.setAttribute( 'class', this.getAttribute( 'class' ) + ' lzyLoaded' );
				},
				scrollTop,
				scrollSpeed,
				lastScrollTop,
				scrollBottom,
				idx,
				visible,
				cacheItem;

			for ( idx in this.cache ) {
				cacheItem = this.cache[idx];
				scrollTop = cacheItem.parent.scrollTop();
				lastScrollTop = cacheItem.parent.data( 'lastScrollTop' ) || 0;
				scrollSpeed = Math.min( Math.abs( scrollTop - lastScrollTop ), 1000 ) * 3 + 200;
				scrollBottom = scrollTop + cacheItem.parent.height() + scrollSpeed;
				scrollTop = scrollTop - scrollSpeed;

				cacheItem.parent.data( 'lastScrollTop', lastScrollTop );
				visible = (scrollTop < cacheItem.top && scrollBottom > cacheItem.top) ||
					(scrollTop < cacheItem.bottom && scrollBottom > cacheItem.bottom);

				if ( visible && this.parentVisible( cacheItem ) ) {
					cacheItem.jq.addClass( 'lzyTrns' );
					cacheItem.el.onload = onload;
					cacheItem.el.src = this.rewriteURLForWebP( cacheItem.jq.data( 'src' ) );
					cacheItem.jq.removeClass( 'lzy' );
					delete this.cache[ idx ];
				}
			}
			//this.timestats = ( new Date() ).getTime() - timestart;
			//console.log( this.timestats );
		}
	};

	// detect WebP support as early as possible
	checkWebPSupport();

	// expose as a global
	window.ImgLzy = ImgLzy;

	$( function() {
		ImgLzy.init();

		// fix iOS bug - not firing scroll event when after refresh page is opened in the middle of its content
		if ( browserDetect.isIPad() ) {
			w.addEventListener( 'pageshow', function() {
				// Safari iOS doesn't trigger scroll event after page refresh.
				// This is a hack to manually lazy-load images after browser scroll the page after refreshing.
				// Should be fixed if we found better solution
				w.setTimeout( $.proxy( ImgLzy.checkAndLoad, ImgLzy ), 0 );
			} );
		}
	});
});
