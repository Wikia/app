/* global Bucky */
(function (context) {
	'use strict';

	if (context.define && context.define.amd) {
		context.define('bucky', [], Bucky);
	}

	$(function () {
		var config = $.extend({}, window.wgBuckyConfig, {context: window.wgTransactionContext});
		Bucky.setOptions(config);
		$(window).load(function () {
			setTimeout(function () {
				Bucky.sendPagePerformance(false);
			}, 0);
		});
	});

})(window);
