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

	var now, debounce, extend, noop, isObject, identity, shuffle;

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

	// Is a given variable an object?
	isObject = function(obj) {
		var type = typeof obj;
		return type === 'function' || type === 'object' && !!obj;
	};

	// Extend a given object with all the properties in passed-in object(s).
	extend = function(obj) {
		if (!isObject(obj)) return obj;
		var source, prop;
		for (var i = 1, length = arguments.length; i < length; i++) {
			source = arguments[i];
			for (prop in source) {
				obj[prop] = source[prop];
			}
		}
		return obj;
	};

	noop = function(){};

	// Keep the identity function around for default iteratees.
	identity = function(value) {
		return value;
	};

	/**
	 * Randomize array element order in-place.
	 * Using Fisher-Yates shuffle algorithm.
	 * Slightly adapted from http://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
	 * @param array
	 * @returns array
	 */
	shuffle = function (array) {
		var i, j, temp;

		for (i = array.length - 1; i > 0; i--) {
			j = Math.floor(Math.random() * (i + 1));
			temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	};

	/**
	 * return API to spawn new instances of StickyElement
	 */
	return {
		now: now,
		debounce: debounce,
		extend: extend,
		noop: noop,
		identity: identity,
		isObject: isObject,
		shuffle: shuffle
	}
});
