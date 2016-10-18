define('wikia.flowTracking', ['wikia.tracker', 'wikia.window', 'mw', 'jquery'], function (tracker, w, mw, $) {
	'use strict';

	var flows = {
			CREATE_PAGE_DIRECT_URL: 'create-page-direct-url'
		},
		track = tracker.buildTrackingFunction({
			category: 'flow-tracking',
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
		track(prepareParams(tracker.ACTIONS.FLOW_START, flow, extraParams));
	}

	/**
	 * Track intermediary flow step
	 *
	 * @param flow name of the flow
	 * @param extraParams additional parameters to track
	 */
	function trackFlowStep(flow, extraParams) {
		track(prepareParams(tracker.ACTIONS.FLOW_MID_STEP, flow, extraParams));
	}

	function prepareParams(action, flow, extraParams) {
		var params = {
			action: action,
			flowname: flow,
			label: flow
		};

		extraParams = extraParams || {};
		return $.extend(params, extraParams, { useragent: userAgent });
	}

	return {
		beginFlow: beginFlow,
		trackFlowStep: trackFlowStep,
		flows: flows
	}
});
