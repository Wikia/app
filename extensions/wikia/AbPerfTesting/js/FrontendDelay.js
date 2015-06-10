/**
 * Introduce a delayed onDOMReady event to measure the impact of performance regressions
 *
  * @see FrontendDelay.class.php
 */
(function(w, log, $) {

	function info(msg) {
		log(msg, log.levels.info, 'FrontEndDelay');
	}

	var delay = w.wgPerfTestFrontEndDelay;
	if (!delay) return;

	info('delay set to ' + delay + ' ms');

	// @see http://api.jquery.com/jquery.holdready/
	$.holdReady(true);

	setTimeout(function() {
		info('hold released');
		$.holdReady(false);
	}, delay);

})(window, window.Wikia.log, jQuery);
