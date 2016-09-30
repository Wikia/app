define('wikia.flowTracking', ['wikia.cookies', 'wikia.tracker', 'mw'], function (cookies, tracker, mw) {
	var cookieName = 'flowTrackingLabel',
		track = tracker.buildTrackingFunction({
			trackingMethod: 'analytics',
			category: 'flow-tracking'
		});

	/**
	 * Set cookie with current flow name and track flow beginning
	 *
	 * @param flowLabel
	 */
	function beginFlow(flowLabel) {
		cookies.set(cookieName, flowLabel, { path: mw.config.get('wgCookiePath') });
		track({
			action: tracker.ACTIONS.BEGIN,
			label: flowLabel
		});
	}

	/**
	 * Track flow ending
	 */
	function endFlow() {
		var flowLabel = cookies.get(cookieName);

		if (flowLabel && isContentPage()) {
			track({
				action: tracker.ACTIONS.END,
				label: flowLabel
			});
		}
	}

	/**
	 * Track intermediary flow step
	 */
	function trackFlowStep() {
		var flowLabel = cookies.get(cookieName);

		if (flowLabel && isContentPage()) {
			track({
				action: tracker.ACTIONS.STEP,
				label: flowLabel
			});
		}
	}

	function isContentPage() {
		return mw.config.get('wgNamespaceNumber') === 0;
	}

	return {
		beginFlow: beginFlow,
		endFlow: endFlow,
		trackFlowStep: trackFlowStep
	}
});
