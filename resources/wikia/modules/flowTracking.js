define('wikia.flowTracking', ['wikia.cookies', 'wikia.tracker', 'mw'], function (cookies, tracker, mw) {
	var cookieName = 'flowTrackingLabel',
		track = tracker.buildTrackingFunction({
			trackingMethod: 'analytics',
			category: 'flow-tracking'
		});

	function beginFlow(flowLabel) {
		cookies.set(cookieName, label, { path: mw.config.get('wgCookiePath') });
		track({
			action: tracker.ACTIONS.BEGIN,
			label: flowLabel
		});
	}

	function endFlow() {
		var flowLabel = cookies.get(cookieName);

		if (flowLabel && isContentPage()) {
			track({
				action: tracker.ACTIONS.END,
				label: flowLabel
			});
		}
	}

	function isContentPage() {
		return mw.config.get('wgNamespaceNumber') === 0;
	}

	return {
		beginFlow: beginFlow,
		endFlow: endFlow
	}
});
