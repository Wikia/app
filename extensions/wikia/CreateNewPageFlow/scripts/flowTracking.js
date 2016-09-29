define('flowTracking', ['wikia.cookies', 'wikia.tracker', 'mw'], function (cookies, tracker, mw) {
	var cookieName = 'CNPFlowLabel',
		track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			trackingMethod: 'analytics',
			category: 'create-new-page-flows'
		});

	function beginFlow(label) {
		cookies.set(cookieName, label, { path: mw.config.get('wgCookiePath') });
		track({
			label: 'begin-' + label
		});
	}

	function endFlow() {
		var flowLabel = cookies.get(cookieName);

		if (flowLabel && validatePage()) {
			track({
				label: 'end-' + flowLabel
			});
		}
	}

	function validatePage() {
		return mw.config.get('wgNamespaceNumber') === 0;
	}

	return {
		beginFlow: beginFlow,
		endFlow: endFlow
	}
});
