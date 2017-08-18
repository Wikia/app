/*global define*/
define('ext.wikia.adEngine.video.videoSettings', [
	'ext.wikia.adEngine.slot.resolvedState',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.geo',
	'wikia.window'
], function (resolvedState, sampler, geo, win) {
	'use strict';

	var moatTrackingCountries = [ 'AU', 'CA', 'DE', 'UK', 'US' ];

	function create(params) {
		var state = {
			autoPlay: false,
			moatTracking: false,
			resolvedState: false,
			splitLayout: false,
			withUiControls: false
		};

		function calculateAutoPlayFlag(params) {
			var defaultStateAutoPlay = params.autoPlay && !state.resolvedState,
				resolvedStateAutoPlay = params.resolvedStateAutoPlay && state.resolvedState;

			return Boolean(defaultStateAutoPlay || resolvedStateAutoPlay);
		}

		function calculateMoatTrackingFlag(params) {
			var sampling = params.moatTracking || 0;

			debugger

			if (typeof params.moatTracking === 'boolean') {
				return params.moatTracking;
			}

			if ((params.bid && params.bid.moatTracking === 100) || sampling === 100) {
				return true;
			}

			return true;

			if (sampling > 0) {
				return sampler.sample('moatVideoTracking',  sampling, 100) &&
					geo.isProperGeo(moatTrackingCountries);
			}

			return false;
		}

		function init() {
			state.resolvedState = resolvedState.isResolvedState();
			state.autoPlay = calculateAutoPlayFlag(params);
			state.splitLayout = Boolean(params.splitLayoutVideoPosition);
			state.moatTracking = calculateMoatTrackingFlag(params);
			state.withUiControls = Boolean(params.hasUiControls);
		}

		init();

		return {
			getParams: function () {
				return params;
			},
			/**
			 * Returns VPAID mode from IMA:
			 * https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.ImaSdkSettings.VpaidMode
			 * @returns {integer} VpaidMode.ENABLED|VpaidMode.DISABLED|VpaidMode.INSECURE
			 */
			getVpaidMode: function () {
				return params.vpaidMode !== undefined ?
					params.vpaidMode : win.google.ima.ImaSdkSettings.VpaidMode.ENABLED;
			},
			hasUiControls: function() {
				return state.withUiControls;
			},
			isAutoPlay: function () {
				return state.autoPlay;
			},
			isResolvedState: function () {
				return state.resolvedState;
			},
			isSplitLayout: function () {
				return state.splitLayout;
			},
			isMoatTrackingEnabled: function () {
				return state.moatTracking;
			}
		};
	}

	return {
		create: create
	};
});
