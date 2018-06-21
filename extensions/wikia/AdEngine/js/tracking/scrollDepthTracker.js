/*global define*/
define('ext.wikia.adEngine.tracking.scrollDepthTracker', [
	'wikia.log',
	'wikia.throttle',
	'wikia.tracker',
	'wikia.window',
	'ext.wikia.adEngine.adContext'
], function (log, throttle, tracker, win, adContext) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.tracking.scrollDepthTracker',
		scrollBreakpoints = [600, 800, 1000, 1200];

	function run() {
		log('run', log.levels.debug, logGroup);

		if (!isEnabled()) {
			log('module disabled', log.levels.debug, logGroup);
			return;
		}

		var currentScrollBreakpoint = scrollBreakpoints.shift(),
		onScroll = throttle(function() {
			log('on scroll', log.levels.debug, logGroup);
			if (!currentScrollBreakpoint) {
				log('no more breakpoints', log.levels.debug, logGroup);
				win.removeEventListener('scroll', onScroll);

				return;
			}

			if (win.pageYOffset >= currentScrollBreakpoint) {
				log('breakpoint: ' + currentScrollBreakpoint, log.levels.debug, logGroup);

				var timeOnPage = Math.round((new Date().getTime() - win.performance.timing.domInteractive) / 1000);

				tracker.track({
					category: 'scroll-depth-monitoring',
					label: currentScrollBreakpoint + 'px|' + timeOnPage + 's|' + win.pvUID,
					trackingMethod: 'internal'
				});
				currentScrollBreakpoint = scrollBreakpoints.shift();
			}
		});

		win.addEventListener('scroll', onScroll);
	}

	function isEnabled() {
		return adContext.get('opts.isScrollDepthTrackingEnabled');
	}

	return {
		run: run
	};
});
