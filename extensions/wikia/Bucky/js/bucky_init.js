/* global Weppy */
(function (context) {
	'use strict';

	context.Bucky = context.Weppy;

	if (context.define && context.define.amd) {
		context.define('bucky', [], function () {
			return context.Weppy;
		});
		context.define('weppy', [], function () {
			return context.Weppy;
		});
	}

	$(function () {
		var config = $.extend({}, context.wgWeppyConfig, {
			'context': context.wgTransactionContext
		});
		Weppy.setOptions(config);
		$(context).on('load', function () {
			setTimeout(function () {
				Weppy.sendPagePerformance();
			}, 0);
		});
	});

})(window);
