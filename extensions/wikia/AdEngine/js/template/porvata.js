/*global define*/
define('ext.wikia.adEngine.template.porvata', [
	'ext.wikia.adEngine.video.videoAdFactory'
], function (videoAdFactory) {
	'use strict';

	function loadVideoAd(params) {
		var vastTargeting = params.vastTargeting || {
				src: params.src,
				pos: params.slotName,
				passback: 'porvata'
			};

		return videoAdFactory.create(
			params.width,
			params.height,
			params.container,
			vastTargeting,
			params.vastUrl
		);
	}

	/**
	 * @param {object} params
	 * @param {object} params.container - DOM element where player should be placed
	 * @param {object} params.slotName - Slot name key-value needed for VastUrlBuilder
	 * @param {object} params.src - SRC key-value needed for VastUrlBuilder
	 * @param {object} params.width - Player width
	 * @param {object} params.height - Player height
	 * @param {string} [params.onReady] - Callback executed once player is ready
	 * @param {string} [params.vastUrl] - Vast URL (DFP URL with page level targeting will be used if not passed)
	 */
	function show(params) {
		return videoAdFactory.init()
			.then(function () {
				var video = loadVideoAd(params);

				if (params.onReady) {
					params.onReady(video);
				}

				if (params.autoPlay) {
					video.play();
				}

				return video;
			});
	}

	return {
		show: show
	};
});
