var Ad = Ad || {};

Ad.Util = (function (console, debugLevel, undef) {
	'use strict';

	return {
		log: function (msg, obj) {
			if (console && debugLevel) {
				if (obj === undef) {
					console.log(msg);
				} else {
					console.log(msg, obj);
				}
			}
		}
	};
}(window.console, 1));
