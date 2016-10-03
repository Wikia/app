define('wikia.flowTracking', ['wikia.tracker', 'wikia.window', 'mw', 'jquery'], function (tracker, w, mw, $) {

	var track = tracker.buildTrackingFunction({
			category: 'flow-tracking',
			eventName: 'flowtracking',
			trackingMethod: 'analytics'

		}),
		userAgent = w.navigator.userAgent;

	/**
	 * Track edit flow beginning.
	 *
	 * @param flow name of the flow
	 * @param extraParams additional parameters to track
	 */
	function beginFlow(flow, extraParams) {
		var params = prepareParams(tracker.ACTIONS.FLOW_START, flow, extraParams);
		track(params);
	}

	/**
	 * Track intermediary flow step
	 *
	 * @param flow name of the flow
	 * @param extraParams additional parameters to track
	 */
	function trackFlowStep(flow, extraParams) {
		var params = {};

		if (isContentPage()) {
			params = prepareParams(tracker.ACTIONS.FLOW_MID_STEP, flow, extraParams);
			track(params);
		}
	}

	function isContentPage() {
		return mw.config.get('wgNamespaceNumber') === 0;
	}

	function prepareParams(action, flow, extraParams) {
		var params = {
			action: action,
			flowname: flow,
			label: flow
		};

		extraParams = extraParams || {};
		return $.extend(params, extraParams, { user_agent: userAgent });
	}

	return {
		beginFlow: beginFlow,
		endFlow: endFlow,
		trackFlowStep: trackFlowStep
	}
});
