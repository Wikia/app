define('wikia.flowTracking', ['wikia.tracker', 'wikia.window', 'mw', 'jquery'], function (tracker, w, mw, $) {

	var track = tracker.buildTrackingFunction({
			trackingMethod: 'analytics',
			category: 'flow-tracking'
		}),
		userAgent = w.navigator.userAgent;

	/**
	 * Track edit flow beginning.
	 *
	 * @param flow name of the flow
	 * @param extraParams additional parameters to track
	 */
	function beginFlow(flow, extraParams) {
		var params = $.extend({
				action: tracker.ACTIONS.FLOW_START,
				label: flow,
				flowname: flow
			}, extraParams, userAgent
		);

		track(params);
	}

	/**
	 * Track intermediary flow step
	 *
	 * @param flow name of the flow
	 * @param extraParams additional parameters to track
	 */
	function trackFlowStep(flow, extraParams) {
		var params = {
			action: tracker.ACTIONS.FLOW_MID_STEP,
			label: flow,
			flowname: flow
		};

		if (isContentPage()) {
			params = $.extend(params, extraParams, userAgent);
			track(params);
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
