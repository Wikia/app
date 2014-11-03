/**
 * Module wikia.underscore
 *
 * Underscore (stripped down to needed elements)
 * @source: http://underscorejs.org/underscore.js
 *
 * @author Bartosz 'V.' Bentkowski
 */
define('wikia.underscore', ['wikia.window'], function underscoreModule(win) {
	'use strict';

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
	 * return API to spawn new instances of StickyElement
	 */
	return {
		now: now,
		debounce: debounce
	}
});
