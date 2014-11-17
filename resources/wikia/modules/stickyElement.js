/**
 * Module wikia.stickyElement
 *
 * Helps element stay on the page (works similar to
 * position: sticky polyfills, but it's smaller and
 * won't insert additional markup to document.
 *
 * @author Bartosz 'V.' Bentkowski
 */
define('wikia.stickyElement', [
	'wikia.window', 'wikia.document', 'wikia.underscore'
], function stickyElementModule(win, doc, _) {
	'use strict';

	/**
	 * StcikyElement class
	 * @returns {{init: init}}
	 * @constructor
	 */
	var StickyElement = function() {
		var options, topScrollLimit, topSticked, lastY = -1;


		/**
		 * Constructor for StickyElement class
		 *
		 * @param {JSON} userOptions
		 *  sourceElement
		 *  alignToElement
		 *  topFixed
		 *  minWidth (defaults to 0)
		 *  [adjustFunc]
		 * @returns {Object} StickyElement
		 */
		function init (userOptions) {
			var defaultOptions = {
				minWidth: 0,
				adjustFunc: _.identity
			};
			options = _.extend(defaultOptions, userOptions);

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
			topScrollLimit = options.alignToElement.getBoundingClientRect().top +
				win.pageYOffset -
				doc.documentElement.clientTop -
				options.topFixed; // minus desired offset when element is fixed

			topSticked = options.alignToElement.offsetTop;

			topScrollLimit = options.adjustFunc(topScrollLimit, 'topScrollLimit');
			topSticked = options.adjustFunc(topSticked, 'topSticked');

			lastY = -1;

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

			if (currentY <= topScrollLimit || (!!options.minWidth && win.innerWidth < options.minWidth)) {
				sourceElementPosition('absolute', topSticked);
			} else {
				sourceElementPosition('fixed', options.topFixed);
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
			options.sourceElement.style.cssText = "position:" + position + ";top:" + top + "px;";
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
