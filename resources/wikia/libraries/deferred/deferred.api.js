/*global deferred, Zepto*/

/**
 * Extends Zepto to have $.Deferred() compatible API
 *
 * @see https://github.com/heavylifters/deferred-js
 * @see http://api.jquery.com/category/deferred-object/
 * @author macbre
 */

(function (deferred, $) {
	'use strict';

	$.Deferred = deferred.deferred;
	$.when = function () {
		return deferred.all(arguments);
	};

	// jQuery's done() = deferred.js's then() with just a first parameter past
	$.Deferred.prototype.done = $.Deferred.prototype.then;

	// jQuery specific "wrapping" promise object
	$.Deferred.prototype.promise = function () {
		var self = this;

		return {
			always: function (callback) {
				return self.both(callback);
			},
			done: function (callback) {
				return self.then(callback);
			},
			fail: function (errback) {
				return self.fail(errback);
			},
			then: function (callback, errback) {
				return self.then(callback, errback);
			}
		};
	};

}(deferred, Zepto));
