/*global define*/
define('ext.wikia.adEngine.video.videoSettings', [
	'ext.wikia.adEngine.slot.resolvedState',
	'wikia.window'
], function (resolvedState, win) {
	'use strict';

	function create(params) {
		var state = {
			autoPlay: false,
			moatTracking: false,
			resolvedState: false,
			splitLayout: false,
			withUiControls: false
		};

		init();

		function init() {
			state.resolvedState = resolvedState.isResolvedState();
			state.autoPlay = isAutoPlay(params);
			state.splitLayout = Boolean(params.splitLayoutVideoPosition);
			state.moatTracking = Boolean(params.moatTracking);
			state.withUiControls = Boolean(params.hasUiControls);
		}

		function isAutoPlay(params) {
			var defaultStateAutoPlay = params.autoPlay && !state.resolvedState,
				resolvedStateAutoPlay = params.resolvedStateAutoPlay && state.resolvedState;
			return Boolean(defaultStateAutoPlay || resolvedStateAutoPlay);
		}

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
