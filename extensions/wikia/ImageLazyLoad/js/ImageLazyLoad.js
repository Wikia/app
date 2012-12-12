/* Lazy loading for images inside articles (skips wikiamobile)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */

$(function() {
	// it's a global, it should be a global
	var ImgLzy = {
		cache: [],
		timestats: 0,
		lastScrollTop: 0,

		init: function() {
			var self = this;
			self.createCache();
			self.checkAndLoad();
			var throttled = $.throttle( 250, $.proxy(self.checkAndLoad, self) );
			$(window).on('scroll', throttled);
		},

		createCache: function() {
			var self = this;
			self.cache = [];
			$('img.lzy').each(function(idx) {
				var cacheItem = [];
				var $el = $(this);
				var top = $el.offset().top;
				cacheItem.push(this);
				cacheItem.push($el);
				cacheItem.push(top);
				cacheItem.push($el.height() + top);
				self.cache[idx] = cacheItem;
			});
		},

		verifyCache: function() {
			if( this.cache.length == 0 ) { return; }
			// make sure that position of elements in the cache didn't change
			var lastidx = this.cache.length - 1;
			var randidx = Math.floor(Math.random() * lastidx);
			var checkidx = [lastidx, randidx];
			var changed = false;
			for( var i in checkidx ) {
				var idx = checkidx[i];
				if( idx in this.cache ) {
					var pos = this.cache[idx][1].offset().top;
					var diff = Math.abs( pos - this.cache[idx][2] );
					if ( diff > 5 ) {
						changed = true;
						break;
					}
				}
			}
			if (changed) {
				this.createCache();
			}
		},

		load: function(image) {
			// this code can only be run from AJAX requests (ie. ImgLzy is registered AFTER DOM ready event
			// so those are new images in DOM
			var $img = $(image);
			image.onload = '';
			var dataSrc = $img.data('src');
			if (dataSrc) {
				image.src = dataSrc;
			}
			$img.removeClass('lzy').removeClass('lzyPlcHld');

		},

		checkAndLoad: function() {
			//var timestart = (new Date()).getTime();

			this.verifyCache();

			var scrollTop = $(window).scrollTop();
			var scrollSpeed = Math.abs( scrollTop - this.lastScrollTop );
			scrollSpeed = Math.min(scrollSpeed, 1000)*3 + 200;
			this.lastScrollTop = scrollTop;
			var scrollBottom = scrollTop + $(window).height() + scrollSpeed;
			scrollTop = scrollTop - scrollSpeed;
			var onload = function() { this.setAttribute( 'class', this.getAttribute('class') + " lzyLoaded" ); };
			for (var idx in this.cache) {
				var cacheEl = this.cache[idx];
				var el = cacheEl[0];
				var $el = cacheEl[1];
				var elTop = cacheEl[2];
				var elBottom = cacheEl[3];
				if( (scrollTop < elTop && scrollBottom > elTop) || (scrollTop < elBottom && scrollBottom > elBottom) ) {
					$el.addClass('lzyTrns');
					el.onload = onload;
					el.src = $el.data('src');
					$el.removeClass('lzy');
					delete this.cache[idx];
				}
			}
			//this.timestats = (new Date()).getTime() - timestart;
			//console.log(this.timestats);
		}
	}

	ImgLzy.init();

	window.ImgLzy = ImgLzy;
});