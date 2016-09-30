define('wikia.flowTracking', ['wikia.cookies', 'wikia.tracker', 'mw'], function (cookies, tracker, mw) {

	var track = tracker.buildTrackingFunction({
			trackingMethod: 'analytics',
			category: 'flow-tracking'
		});

	/**
	 * Set cookie with current flow name and track flow beginning
	 *
	 * @param flow name of the flow
	 */
	function beginFlow(flow) {
		track({
			action: tracker.ACTIONS.FLOW_START,
			label: flow
		});
	}

	/**
	 * Track flow ending
	 *
	 * @param flow name of the flow
	 */
	function endFlow(flow) {
		if (isContentPage()) {
			track({
				action: tracker.ACTIONS.FLOW_END,
				label: flow
			});
		}
	}

	/**
	 * Track intermediary flow step
	 *
	 * @param flow name of the flow
	 */
	function trackFlowStep(flow) {
		if (isContentPage()) {
			track({
				action: tracker.ACTIONS.FLOW_MID_STEP,
				label: flow
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
