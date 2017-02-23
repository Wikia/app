/*global define*/
define('ext.wikia.adEngine.video.videoSettings', [
	'ext.wikia.adEngine.slot.resolvedState'
], function (resolvedState) {
	'use strict';

	function create(params) {
		var state = {
			autoPlay: false,
			resolvedState: false,
			splitLayout: false
		};

		init();

		function init() {
			state.resolvedState = resolvedState.isResolvedState();
			state.autoPlay = isAutoPlay(params);
			state.splitLayout = Boolean(params.splitLayoutVideoPosition);
		}

		function isAutoPlay(params) {
			var defaultStateAutoPlay = params.autoPlay && !state.resolvedState,
				resolvedStateAutoPlay = params.resolvedStateAutoPlay && state.resolvedState;
			return Boolean(defaultStateAutoPlay || resolvedStateAutoPlay);
		}

		return {
			getParams: function() {
				return params;
			},
			isAutoPlay: function () {
				return state.autoPlay;
			},
			isResolvedState: function () {
				return state.resolvedState;
			},
			isSplitLayout: function () {
				return state.splitLayout;
			}
		};
	}

	return {
		create: create
	};
});
