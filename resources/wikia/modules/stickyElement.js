/**
 * Module wikia.stickyElement
 *
 * Helps element stay on the page (works similar to
 * position: sticky polyfills, but it's smaller and
 * won't insert additional markup to document.
 *
 * @author Bartosz 'V.' Bentkowski
 */
define('wikia.stickyElement', ['wikia.window', 'wikia.document', 'wikia.underscore'], function stickyElementModule(win, doc, _) {
	'use strict';

	/**
	 * StcikyElement class
	 * @returns {{init: init}}
	 * @constructor
	 */
	var StickyElement = function() {
		var sourceElement, alignToElement, topScrollLimit, topSticked, topFixed, minWidth, lastY = -1;


		/**
		 * Constructor for StickyElement class
		 *
		 * @param {Element} _sourceElement
		 * @param {Element} _alignToElement
		 * @param {Number} _topFixed
		 * @param {Number=} _minWidth
		 * @returns {Object} StickyElement
		 */
		function init (_sourceElement, _alignToElement, _topFixed, _minWidth) {
			sourceElement = _sourceElement;
			alignToElement = _alignToElement;
			topFixed = _topFixed;
			minWidth = _minWidth || 0;

			win.addEventListener('load',   updateSize);
			win.addEventListener('scroll', _.debounce(updatePosition, 10));
			win.addEventListener('resize', _.debounce(updateSize, 10));

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

			if (currentY <= topScrollLimit || (!!minWidth && win.innerWidth < minWidth)) {
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
