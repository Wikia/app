/*global deferred, Zepto*/

/**
 * Extends Wikia to have Wikia.Deferred() compatible API
 *
 * @see https://github.com/heavylifters/deferred-js
 * @see http://api.jquery.com/category/deferred-object/
 * @author macbre
 */

(function (deferred, Wikia) {
	'use strict';

	Wikia.Deferred = deferred.deferred;
	Wikia.when = function () {
		return deferred.all(arguments);
	};

	// jQuery's done() = deferred.js's then() with just a first parameter past
	Wikia.Deferred.prototype.done = Wikia.Deferred.prototype.then;

	// jQuery specific "wrapping" promise object
	Wikia.Deferred.prototype.promise = function () {
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

}(deferred, Wikia));
