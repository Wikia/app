/**
 * Polyfill for `Function.prototype.bind` because PhantomJS 1.9.8 doesn't support it
 * Should only need to use this for unit tests, as all Wikia's supported browsers support bind.
 * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/bind#Polyfill
 */
Function.prototype.bind = Function.prototype.bind || function (oThis) {
	'use strict';

	if (typeof this !== 'function') {
		// closest thing possible to the ECMAScript 5
		// internal IsCallable function
		throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
	}

	var aArgs = Array.prototype.slice.call(arguments, 1),
		self = this,
		NoOp = function () {},
		fBound = function () {
			return self.apply(
				this instanceof NoOp && oThis ? this : oThis,
				aArgs.concat(Array.prototype.slice.call(arguments))
			);
		};

	NoOp.prototype = this.prototype;
	fBound.prototype = new NoOp();

	return fBound;
};
