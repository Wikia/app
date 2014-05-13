/*global syslogReport: true */
/* jshint maxlen: 150 */
/* Lazy loading for images inside articles (skips wikiamobile)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */
define('wikia.ImgLzy', ['jquery', 'wikia.log', 'wikia.window'], function ($, log, w) {
	'use strict';

	var ImgLzy,
		// allow WebP thumbnails for JPG and PNG files only (exclude video thumbnails)
		// e.g. /muppet/images/thumb/9/98/BBC1_promos_for_Muppets_Tonight/150px-BBC1_promos_for_Muppets_Tonight.jpg
		thumbCheckRegExp = /\/images\/thumb\/[0-9a-f]\/[0-9a-f]{2}\/[^/]+\.(jpg|jpeg|jpe|png)(\/)/i;

	function logger(msg) {
		log(msg, log.levels.info, 'ImgLzy');
	}

	ImgLzy = {
		cache: [],
		timestats: 0,
		browserSupportsWebP: false,

		init: function () {
			var proxy = $.proxy(this.checkAndLoad, this),
				throttled = $.throttle(250, proxy);

			this.$scroller = $('.scroller');

			this.createCache();
			this.checkAndLoad();

			$(window).on('scroll', throttled);
			this.$scroller.on('scroll', throttled);
			$(document).on('tablesorter_sortComplete', proxy);

			logger('initialized');
		},

		relativeTop: function (e) {
			return e.offset().top - e.parents('.scroller').offset().top;
		},

		absTop: function (e) {
			return e.offset().top;
		},

		checkWebPSupport: function () {
			logger('checking WebP support...');

			// @see http://stackoverflow.com/a/5573422
			var webP = new Image();
			webP.src = 'data:image/webp;base64,UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA';
			webP.onload = webP.onerror = $.proxy(function () {
				this.browserSupportsWebP = webP.height === 2;

				logger('has support for WebP: ' + (this.browserSupportsWebP ? 'yes' : 'no'));

				// report WebP support stats to Kibana
				if (w.wgEnableWebPSupportStats === true && typeof syslogReport === 'function') {
					syslogReport(log.levels.info, 'webp', {
						'webp-support': this.browserSupportsWebP ? 'yes' : 'no'
					});
				}
			}, this);
		},

		// rewrite the URL to request WebP thumbnails (if enabled on this wiki and supported by the browser)
		rewriteURLForWebP: function (src) {
			if (w.wgEnableWebPThumbnails === true && this.browserSupportsWebP && thumbCheckRegExp.test(src)) {
				src = src.replace(/\.[^\./]+$/, '.webp');
			}
			return src;
		},

		createCache: function () {
			var self = this;

			self.cache = [];
			$('img.lzy').each(function (idx) {
				var $el = $(this),
					relativeTo = self.$scroller.find(this),
					topCalc, top;

				if (relativeTo.length !== 0) {
					relativeTo = relativeTo.parents('.scroller');
					topCalc = self.relativeTop;
				} else {
					relativeTo = $(window);
					topCalc = self.absTop;
				}

				top = topCalc($el);
				self.cache[idx] = {
					el: this,
					jq: $el,
					topCalc: topCalc,
					top: top,
					bottom: $el.height() + top,
					parent: relativeTo
				};
			});
		},

		verifyCache: function () {
			if (this.cache.length === 0) {
				return;
			}
			// make sure that position of elements in the cache didn't change
			var lastidx = this.cache.length - 1,
				randidx = Math.floor(Math.random() * lastidx),
				checkidx = [lastidx, randidx],
				changed = false,
				i,
				idx,
				pos,
				diff;
			for (i in checkidx) {
				idx = checkidx[i];
				if (idx in this.cache) {
					pos = this.cache[idx].topCalc(this.cache[idx].jq);
					diff = Math.abs(pos - this.cache[idx].top);

					if (diff > 5) {
						changed = true;
						break;
					}
				}
			}
			if (changed) {
				this.createCache();
			}
		},

		load: function (image) {
			// this code can only be run from AJAX requests (ie. ImgLzy is registered AFTER DOM ready event
			// so those are new images in DOM
			var $img = $(image),
				dataSrc = $img.data('src');
			image.onload = '';
			if (dataSrc) {
				image.src = this.rewriteURLForWebP(dataSrc);
			}
			$img.removeClass('lzy').removeClass('lzyPlcHld');
		},

		parentVisible: function (item) {
			if (item.parent[0] === window) {
				return true;
			}

			var fold = $(window).scrollTop() + $(window).height(),
				parentTop = item.parent.offset().top;

			return fold > parentTop;
		},

		checkAndLoad: function () {
			this.verifyCache();

			var onload = function () {
				this.setAttribute('class', this.getAttribute('class') + ' lzyLoaded');
			},
				scrollTop,
				scrollSpeed,
				lastScrollTop,
				scrollBottom,
				idx,
				visible,
				cacheItem;

			for (idx in this.cache) {
				cacheItem = this.cache[idx];
				scrollTop = cacheItem.parent.scrollTop();
				lastScrollTop = cacheItem.parent.data('lastScrollTop') || 0;
				scrollSpeed = Math.min(Math.abs(scrollTop - lastScrollTop), 1000) * 3 + 200;
				scrollBottom = scrollTop + cacheItem.parent.height() + scrollSpeed;
				scrollTop = scrollTop - scrollSpeed;

				cacheItem.parent.data('lastScrollTop', lastScrollTop);
				visible = (scrollTop < cacheItem.top && scrollBottom > cacheItem.top) ||
					(scrollTop < cacheItem.bottom && scrollBottom > cacheItem.bottom);

				if (visible && this.parentVisible(cacheItem)) {
					cacheItem.jq.addClass('lzyTrns');
					cacheItem.el.onload = onload;
					cacheItem.el.src = this.rewriteURLForWebP(cacheItem.jq.data('src'));
					cacheItem.jq.removeClass('lzy');
					delete this.cache[idx];
				}
			}
		}
	};

	return ImgLzy;
});
