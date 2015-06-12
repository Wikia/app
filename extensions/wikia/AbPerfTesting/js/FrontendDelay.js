/**
 * Introduce a delayed onDOMReady event to measure the impact of performance regressions
 *
  * @see FrontendDelay.class.php
 */
(function(w, log, weppy, $) {

	function info(msg) {
		log(msg, log.levels.info, 'FrontEndDelay');
	}

	var delay = w.wgPerfTestFrontEndDelay;

	// report the delayed onDOMReady
	// will be stored in rum_metrics_performance_tests series in InfluxDB
	$(function() {
		var sink = weppy('performance_tests::metrics');
		if (w.wgNow) {
			sink.store('domCompleteDelayed', new Date() - w.wgNow); // metrics.domCompleteDelayed [ms]
		}
	});

	// skip the test, there's no delay defined
	if (!delay) {
		info('delay not defined, leaving...');
		return;
	}

	info('delay set to ' + delay + ' ms');

	// @see http://api.jquery.com/jquery.holdready/
	$.holdReady(true);

	setTimeout(function() {
		info('hold released');
		$.holdReady(false);
	}, delay);

})(window, window.Wikia.log, window.Weppy, jQuery);
