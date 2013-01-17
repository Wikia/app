/**
 * Polyfills for Array methods
 *
 * @author  Macbre <macbre@wikia-inc.com>
 * @author Jakub Olek <jakubolek@wikia-inc.com>
 *
 * @see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/
 */

(function () {
	'use strict';

	// add Array.indexOf function in IE8
	// @see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/indexOf
	if (!Array.prototype.indexOf) {
		Array.prototype.indexOf = function (val, fromIndex) {
			var i,
				l;

			fromIndex = fromIndex || 0;

			for (i = fromIndex, l = this.length; i < l; i++) {
				if (this[i] === val) {
					return i;
				}
			}

			return -1;
		};
	}

	// add Array.filter function in IE8
	// @see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/filter
	if (!Array.prototype.filter) {
		Array.prototype.filter = function (fun, t) {
			var i,
				l,
				res = [];

			for (i = 0, l = this.length; i < l; i++) {
				if (fun.call(t, this[i], i, this)) {
					res[res.length] = this[i];
				}
			}

			return res;
		};
	}

	// add Array.lastIndexOf function in IE8
	if (!Array.prototype.lastIndexOf) {
		Array.prototype.lastIndexOf = function (searchElement /*, fromIndex*/) {
			"use strict";

			if (this == null)
				throw new TypeError();

			var t = Object(this);
			var len = t.length >>> 0;
			if (len === 0)
				return -1;

			var n = len;
			if (arguments.length > 1) {
				n = Number(arguments[1]);
				if (n != n)
					n = 0;
				else if (n != 0 && n != (1 / 0) && n != -(1 / 0))
					n = (n > 0 || -1) * Math.floor(Math.abs(n));
			}

			var k = n >= 0
				? Math.min(n, len - 1)
				: len - Math.abs(n);

			for (; k >= 0; k--) {
				if (k in t && t[k] === searchElement)
					return k;
			}
			return -1;
		};
	}
}());