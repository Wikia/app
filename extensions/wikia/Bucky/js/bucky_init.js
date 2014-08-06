$(function () {
	var config = $.extend({}, window.wgBuckyConfig, {context: window.wgTransactionContext});
	Bucky.setOptions(config);
	$(window).load(function () {
		setTimeout(function () {
			Bucky.sendPagePerformance(false);
		}, 0);
	});
});