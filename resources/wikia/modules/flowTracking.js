define('wikia.flowTracking', ['wikia.tracker', 'mw'], function (tracker, mw) {

	var track = tracker.buildTrackingFunction({
			trackingMethod: 'analytics',
			category: 'flow-tracking'
		});

	/**
	 * Track edit flow beginning.
	 *
	 * @param flow name of the flow
	 */
	function beginFlow(flow) {
		track({
			action: tracker.ACTIONS.FLOW_START,
			label: flow,
			flowname: flow
		});
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
