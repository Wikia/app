/**
 * AMD module wrapping Promise global object
 */
define('wikia.promise', function () {
	'use strict';

	var P = window.Promise;

	/**
	 * Constructor for promise with timeout
	 *
	 * @param f(resolve, reject)
	 * @param msToTimeout
	 */
	P.createWithTimeout = function (f, msToTimeout) {
		msToTimeout = msToTimeout || 2000;
		var timeout = new P(function (resolve, reject) {
			setTimeout(reject, msToTimeout);
		});

		return P.race([new P(f), timeout]);
	};

	return P;
});
