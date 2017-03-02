/*global define*/
define('ext.wikia.adEngine.template.porvata', [
	'ext.wikia.adEngine.video.player.porvata',
	'ext.wikia.adEngine.video.videoSettings',
	'wikia.document',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (porvata, videoSettings, doc, mercuryListener) {
	'use strict';

	function getVideoContainer(slotName) {
		var container = doc.createElement('div'),
			providerContainer = doc.querySelector('#' + slotName + ' > .provider-container');

		container.classList.add('vpaid-container');
		providerContainer.appendChild(container);

		return container;
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
		params.vpaidMode = 2;
		if (params.vpaidMode === 2) {
			params.container = getVideoContainer(params.slotName);
		}

		porvata.inject(videoSettings.create(params)).then(function (video) {
			if (params.vpaidMode === 2) {
				video.addEventListener('loaded', function () {
					var ad = video.ima.getAdsManager().getCurrentAd(),
						contentType = ad.getContentType() || '';

					if (contentType.indexOf('application/') !== -1) {
						params.container.classList.add('vpaid-enabled');
					}
				});
				video.addEventListener('allAdsCompleted', function () {
					params.container.querySelector('.video-player').classList.add('hidden');
				});
			}

			if (mercuryListener) {
				mercuryListener.onPageChange(function () {
					video.destroy();
				});
			}

			return video;
		});
	}

	return {
		show: show
	};
});
