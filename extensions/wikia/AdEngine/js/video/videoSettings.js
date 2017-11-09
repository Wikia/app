/*global define*/
define('ext.wikia.adEngine.video.videoSettings', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.resolvedState',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.instantGlobals',
	'wikia.window'
], function (adContext, resolvedState, sampler, instantGlobals, win) {
	'use strict';

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
			var sampling = instantGlobals.wgAdDriverPorvataMoatTrackingSampling || 0;

			if (typeof params.moatTracking === 'boolean') {
				return params.moatTracking;
			}

			if (!adContext.get('opts.porvataMoatTrackingEnabled')) {
				return false;
			}

			if (sampling === 100) {
				return true;
			}

			if (sampling > 0) {
				return sampler.sample('moat_video_tracking',  sampling, 100);
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
			},
			setMoatTracking: function (status) {
				state.moatTracking = status;
			}
		};
	}

	return {
		create: create
	};
});
