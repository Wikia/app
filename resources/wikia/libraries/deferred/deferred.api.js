/*global deferred, Zepto*/

/**
 * Extends Wikia to have Wikia.Deferred() compatible API
 *
 * @see https://github.com/heavylifters/deferred-js
 * @see http://api.jquery.com/category/deferred-object/
 * @author macbre
 */

Wikia = window.Wikia || {};

(function (deferred, Wikia) {
	'use strict';

	Wikia.Deferred = deferred.deferred;
	Wikia.when = function () {
		return deferred.all(arguments);
	};

	// jQuery's done() = deferred.js's then() with just a first parameter past
	deferred.Deferred.prototype.done = deferred.Deferred.prototype.then;

	// jQuery specific methods from "wrapping" promise object
	deferred.Deferred.prototype.always = deferred.Deferred.prototype.both;
	deferred.Deferred.prototype.done = deferred.Deferred.prototype.then;

	// deferred.all requires full API to be available via promise object
	deferred.Deferred.prototype.promise = function () {
		return this;
	};

}(deferred, Wikia));
