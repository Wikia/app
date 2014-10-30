/**
 * Module wikia.stickyElement
 *
 * Helps element stay on the page (works similar to
 * position: sticky polyfills, but it's smaller and
 * won't insert additional markup to document.
 *
 * @author Bartosz 'V.' Bentkowski
 */
define('wikia.stickyElement', ['wikia.window', 'wikia.document'], function stickyElementModule(win, doc) {
	'use strict';

	/**
	 * Debounce method taken from Underscore.js
	 *
	 * @source: http://underscorejs.org/underscore.js
	 */
	var now, debounce;

	now = Date.now || function() {
		return new Date().getTime();
	};

	debounce = function (func, wait, immediate) {
		var timeout, args, context, timestamp, result, later;

		later = function() {
			var last = now() - timestamp;

			if (last < wait && last > 0) {
				timeout = win.setTimeout(later, wait - last);
			} else {
				timeout = null;
				if (!immediate) {
					result = func.apply(context, args);
					if (!timeout) context = args = null;
				}
			}
		};

		return function() {
			context = this;
			args = arguments;
			timestamp = now();
			var callNow = immediate && !timeout;
			if (!timeout) timeout = win.setTimeout(later, wait);
			if (callNow) {
				result = func.apply(context, args);
				context = args = null;
			}

			return result;
		};
	};

	/**
	 * StcikyElement class
	 * @returns {{init: init}}
	 * @constructor
	 */
	var StickyElement = function() {
		var sourceElement, alignToElement, topScrollLimit, topSticked, topFixed, lastY = -1;


		/**
		 * Constructor for StickyElement class
		 *
		 * @param {Element} _sourceElement
		 * @param {Element} _alignToElement
		 * @param {Element} _topFixed
		 * @returns {Object} StickyElement
		 */
		function init (_sourceElement, _alignToElement, _topFixed) {
			sourceElement = _sourceElement;
			alignToElement = _alignToElement;
			topFixed = _topFixed;

			win.addEventListener('load',   updateSize);
			win.addEventListener('scroll', debounce(updatePosition, 10));
			win.addEventListener('resize', debounce(updateSize, 10));

			updateSize();

			return this;
		}

		/**
		 * Updates variables that are dependant on screen size and forces updatePosition
		 */
		function updateSize () {
			// calculate changing point using real element offset
			// source: https://github.com/jquery/jquery/blob/2.1.0/src/offset.js#L106
			topScrollLimit = alignToElement.getBoundingClientRect().top +
				win.pageYOffset -
				doc.documentElement.clientTop -
				topFixed; // minus desired offset when element is fixed

			topSticked = alignToElement.offsetTop;

			updatePosition();
		}

		/**
		 * Updates element position based on current window's scroll offset.
		 *
		 * @param {Event=} event
		 */
		function updatePosition (event) {
			var currentY = win.pageYOffset;

			// return if there's nothing to update
			if (event != undefined && currentY === lastY) return;

			if (currentY <= topScrollLimit) {
				sourceElementPosition('absolute', topSticked);
			} else {
				sourceElementPosition('fixed', topFixed);
			}

			lastY = currentY;
		}

		/**
		 *  Updates element style, sets "position" and "top" properties
		 *
		 * @param {String} position
		 * @param {Number} top
		 */
		function sourceElementPosition (position, top) {
			sourceElement.style.cssText = "position:" + position + ";top:" + top + "px;";
		}

		/**
		 * Return API (only constructor)
		 */
		return {
			init: init
		};
	};

	/**
	 * return API to spawn new instances of StickyElement
	 */
	return {
		spawn: function() {
			return new StickyElement();
		}
	}
});
