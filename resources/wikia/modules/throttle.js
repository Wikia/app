/*global define, clearTimeout, setTimeout*/
define('wikia.throttle', function () {
	'use strict';

	function throttle(fn, threshold, scope) {
		threshold = threshold || 250;
		var last,
			deferTimer;

		return function () {
			var context = scope || this,
				now = +(new Date()),
				args = arguments;

			if (last && now < last + threshold) {
				// hold on to it
				clearTimeout(deferTimer);
				deferTimer = setTimeout(function () {
					last = now;
					fn.apply(context, args);
				}, threshold);
			} else {
				last = now;
				fn.apply(context, args);
			}
		};
	}

	return throttle;
});
