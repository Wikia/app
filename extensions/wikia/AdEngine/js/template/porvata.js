/*global define*/
define('ext.wikia.adEngine.template.porvata', [
	'ext.wikia.adEngine.video.videoAdFactory'
], function (videoAdFactory) {
	'use strict';

	function loadVideoAd(params) {
		return videoAdFactory.create(
			params.width,
			params.height,
			params.adContainer,
			{
				src: params.src,
				pos: params.slotName,
				passback: 'porvata'
			},
			params.vastUrl,
			true
		);
	}

	/**
	 * @param {object} params
	 * @param {object} params.container - DOM element where player should be placed
	 * @param {object} params.imageContainer - DOM element where is placed default image
	 * @param {string} [params.vastUrl] - Vast URL (DFP URL with page level targeting will be used if not passed)
	 */
	function show(params) {
		videoAdFactory.init()
			.then(function () {
				var video = loadVideoAd(params);

				if (params.onReady) {
					params.onReady(video);
				}

				video.play();
			});
	}

	return {
		show: show
	};
});