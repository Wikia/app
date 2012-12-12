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

			for (i = 0, l = this.length; i < l; i++){
				if (fun.call(t, this[i], i, this)) {
					res[res.length] = this[i];
				}
			}

			return res;
		};
	}
}());