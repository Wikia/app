/*global define*/
define('ext.wikia.adEngine.video.videoSettings', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.sampler',
	'wikia.instantGlobals',
	'wikia.window'
], function (adContext, sampler, instantGlobals, win) {
	'use strict';

	function create(params) {
		var state = {
			autoPlay: false,
			moatTracking: false,
			withUiControls: false
		};

		function calculateAutoPlayFlag(params) {
			return Boolean(params.autoPlay);
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
			state.autoPlay = calculateAutoPlayFlag(params);
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
