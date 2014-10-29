(function(win) {
	'use strict';
	// source: http://underscorejs.org/underscore.js
	var now, debounce;

	now = Date.now || function() {
		return new Date().getTime();
	};

	debounce = function (func, wait, immediate) {
		var timeout, args, context, timestamp, result;

		var later = function() {
			var last = now() - timestamp;

			if (last < wait && last > 0) {
				timeout = setTimeout(later, wait - last);
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
			if (!timeout) timeout = setTimeout(later, wait);
			if (callNow) {
				result = func.apply(context, args);
				context = args = null;
			}

			return result;
		};
	};

	// module
	var StickyElement = function() {
		var sourceElement, alignToElement, topSticked, topFixed, lastY = -1;

		/**
		 * Initialize values and hook to window events
		 */
		function init (_sourceElement, _alignToElement, _topFixed) {
			sourceElement = _sourceElement;
			alignToElement = _alignToElement;
			topFixed = _topFixed;

			window.addEventListener('load',   updateSize);
			window.addEventListener('scroll', debounce(updatePosition, 10));
			window.addEventListener('resize', debounce(updateSize, 10));

			updateSize();

			return this;
		}

		function updateSize () {
			topSticked = alignToElement.offsetTop;

			console.log('updateSize', topSticked);

			updatePosition(true);
		}

		function updatePosition (force) {
			force = force || false;

			if (!force && win.pageYOffset === lastY) return;

			lastY = win.pageYOffset;

			if (lastY <= topSticked) {
				sourceElementPosition('absolute', topSticked);
			} else {
				sourceElementPosition('fixed', topFixed);
			}
		}

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

	//
	win.stickyElement = function(_sourceElement, _alignToElement, _topFixed) {
		var stickyElement;

		stickyElement = new StickyElement();
		return stickyElement.init(_sourceElement, _alignToElement, _topFixed);
	};
})(window);
