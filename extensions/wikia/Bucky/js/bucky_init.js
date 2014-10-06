/* global Bucky */
(function (context) {
	'use strict';

	if (context.define && context.define.amd) {
		context.define('bucky', [], Bucky);
	}

	$(function () {
		var config = $.extend({}, context.wgBuckyConfig, {
			'context': context.wgTransactionContext
		});
		Bucky.setOptions(config);
		$(context).load(function () {
			setTimeout(function () {
				Bucky.sendPagePerformance(false);
			}, 0);
		});
	});

})(window);
