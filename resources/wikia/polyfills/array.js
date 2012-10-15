/**
 * Polyfills for Array methods
 *
 * @see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/
 */

// add Array.indexOf function in IE8
// @see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/indexOf
if (typeof [].indexOf === 'undefined') {
	Array.prototype.indexOf = function(val, fromIndex) {
		fromIndex = fromIndex || 0;
		for (var i = fromIndex, m = this.length; i < m; i++) {
			if (this[i] === val) {
				return i;
			}
		}
		return -1;
	}
}

// add Array.filter function in IE8
// @see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/filter
if (typeof [].filter === 'undefined') {
	Array.prototype.filter = function(fun, t){
		var len = this.length,
			res = [];

		for (var i = 0; i < len; i++){
			if (fun.call(t, this[i], i, this)) res[res.length] = this[i];
		}

		return res;
	};
}
