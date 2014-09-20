/*global define, clearTimeout, setTimeout*/
define('ext.wikia.adEngine.adHelper', function () {
	'use strict';

	function throttle(fn, threshhold, scope) {
		threshhold = threshhold || 250;
		var last,
			deferTimer;

		return function () {
			var context = scope || this,
				now = +new Date,
				args = arguments;

			if (last && now < last + threshhold) {
				// hold on to it
				clearTimeout(deferTimer);
				deferTimer = setTimeout(function () {
					last = now;
					fn.apply(context, args);
				}, threshhold);
			} else {
				last = now;
				fn.apply(context, args);
			}
		};
	}

	return {
		throttle: throttle
	};
});
