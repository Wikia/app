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
		 *  [adjustPositionFunc]
		 * @returns {Object} StickyElement
		 */
		function init (userOptions) {
			var defaultOptions = {
				minWidth: 0,
				adjustFunc: _.identity,
				adjustPositionFunc: false
			};
			options = _.extend(defaultOptions, userOptions);

			win.addEventListener('load',   updateSize, false);
			win.addEventListener('resize', _.debounce(updateSize, 10), false);
			win.addEventListener('scroll', _.throttle(updatePosition, 10), false);
			win.addEventListener('touchmove', _.throttle(updatePosition, 10), false);

			updateSize();

			/*jshint validthis:true*/
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
			if (event !== undefined && currentY === lastY) {
				return;
			}
			lastY = currentY;

			if (!!options.minWidth && win.innerWidth < options.minWidth) {
				sourceElementPosition('absolute', 'top', topSticked);
			} else {
				if (typeof options.adjustPositionFunc === 'function' && options.adjustPositionFunc(currentY)) {
					return;
				}

				if (currentY <= topScrollLimit) {
					sourceElementPosition('absolute', 'top', topSticked);
				} else {
					sourceElementPosition('fixed', 'top', options.topFixed);
				}
			}
		}

		/**
		 *  Updates element style, sets "position" and "alignment" properties
		 *
		 * @param {String} position
		 * @param {Number} alignment
		 * @param {Number} value
		 */
		function sourceElementPosition (position, alignment, value) {
			var display = options.sourceElement.style.display;
			options.sourceElement.style.display = 'none';

			options.sourceElement.style.position = position;
			options.sourceElement.style[alignment] = value + 'px';

			options.sourceElement.style.display = display;
		}

		/**
		 * Return API (only constructor)
		 */
		return {
			init: init,
			updatePosition: updatePosition,
			updateSize: updateSize,
			sourceElementPosition: sourceElementPosition
		};
	};

	/**
	 * return API to spawn new instances of StickyElement
	 */
	return {
		spawn: function() {
			return new StickyElement();
		}
	};
});
