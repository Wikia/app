/**
 * Introduce a delayed onDOMReady event to measure the impact of performance regressions
 *
  * @see FrontendDelay.class.php
 */
(function(w, log, weppy, $) {

	function updateTransactionName(perf_test) {
		// update Weppy config when transaction context is updated
		// matches \Transaction::PARAM_AB_PERFORMANCE_TEST const
		w.wgTransactionContext['perf_test'] = perf_test;

		weppy.setOptions({
			context: w.wgTransactionContext
		});

		// set UA custom dimension
		// should match the PHP code in /extensions/wikia/AbPerfTesting/classes/Hooks.class.php
		if (perf_test) {
			w._gaq.push(
				['set', 'dimension20', perf_test]
			);
		}
	}

	function info(msg) {
		log(msg, log.levels.info, 'FrontEndDelay');
	}

	var delay = w.wgPerfTestFrontEndDelay,
		perf_test = w.wgTransactionContext['perf_test'];

	// FIXME: perform the bucketing logic here, should be moved to the backend
	delay = false;

	if (typeof w.beacon_id === 'string') {
		switch(w.beacon_id.charAt(0)) {
			case '0':
				// this is a control group
				perf_test += '_0';
				delay = 0;
				break;
			case '1':
				perf_test += '_1';
				delay = 100;
				break;
			case '2':
				perf_test += '_2';
				delay = 200;
				break;
			case '3':
				perf_test += '_3';
				delay = 300;
				break;
		}
	}

	if (delay === false) {
		perf_test = undefined;
	}

	updateTransactionName(perf_test);
	// FIXME ends here

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

	// report the delayed onDOMReady
	// will be stored in rum_metrics_performance_tests series in InfluxDB
	$(function() {
		var sink = weppy('performance_tests::metrics');
		if (w.wgNow) {
			sink.store('domCompleteDelayed', new Date() - w.wgNow); // metrics.domCompleteDelayed [ms]
		}
	});

})(window, window.Wikia.log, window.Weppy, jQuery);
