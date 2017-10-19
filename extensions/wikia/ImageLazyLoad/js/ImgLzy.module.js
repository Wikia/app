/*global document, window, syslogReport: true */
/* jshint maxlen: 150 */
/* Lazy loading for images inside articles (skips wikiamobile)
 * @author Piotr Bablok <pbablok@wikia-inc.com>
 */
define('wikia.ImgLzy', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';

	var ImgLzy;

	ImgLzy = {
		// load an image if it is within this many pixels from the edge of the viewport
		prefetchDistance: 700,
		loadQueue: [],

		init: function () {
			var proxy = this.onScroll.bind(this),
				throttled = $.throttle(250, proxy);

			this.loadQueue = Array.prototype.slice.call(document.querySelectorAll('img.lzy'));

			// Perform an initial sweep to load any nearby images
			this.onScroll();

			// Scan & load images every 250 ms if the user is scrolling
			$(window).on('scroll', throttled);

			// If a sortable table is sorted, it might change the order of images in the table
			document.addEventListener('tablesorter_sortComplete', proxy);
		},

		/**
		 * Manually load an image
		 * @param {HTMLImageElement} image
		 */
		load: function (image) {
			// this code can only be run from AJAX requests (ie. ImgLzy is registered AFTER DOM ready event
			// so those are new images in DOM
			var dataSrc = image.getAttribute('data-src');
			image.onload = function () {};

			if (dataSrc) {
				image.src = dataSrc;
			}

			image.classList.remove('lzy', 'lzyPlcHld');
		},

		isVisibleInViewport: function (element) {
			// the element is hidden, nothing to do
			if (!element.offsetParent) {
				return false;
			}

			var boundingClientRect = element.getBoundingClientRect();

			// the top of the element must be above the bottom of the viewport or less than N pixels below it
			// and its bottom must be below the top of the viewport or less than N pixels above it
			return boundingClientRect.top - this.prefetchDistance < window.innerHeight &&
				boundingClientRect.bottom + this.prefetchDistance > 0;
		},

		/**
		 * On scroll, process the queue of images that have not yet been loaded,
		 * and load the ones that are within the viewport.
		 * After an image has been loaded, it is removed from the queue - otherwise it remains waiting.
		 */
		onScroll: function () {
			var self = this;

			this.loadQueue = this.loadQueue.filter(function (image) {
				// Image is not yet visible in viewport. Keep it in the queue.
				if (!self.isVisibleInViewport(image)) {
					return true;
				}

				image.onload = self.onImageLoaded;

				var dataSrc = image.getAttribute('data-src');
				if (dataSrc) {
					image.src = dataSrc;
				}

				image.classList.add('lzyTrns');
				image.classList.remove('lzy');

				// image has been loaded, remove it from the queue
				return false;
			});
		},

		/**
		 * Callback handler attached to images when loading begins
		 * Executed in the context of the HTMLImageElement
		 */
		onImageLoaded: function () {
			this.classList.add('lzyLoaded');
		}
	};

	return ImgLzy;
});
