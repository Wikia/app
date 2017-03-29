/*global define*/
define('ext.wikia.adEngine.template.porvata', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.video.player.porvata',
	'ext.wikia.adEngine.video.player.porvata.googleIma',
	'ext.wikia.adEngine.video.videoSettings',
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (DOMElementTweaker, porvata, googleIma, videoSettings, doc, win, mercuryListener) {
	'use strict';

	function hideOtherBidsForVeles(params) {
		if (params.adProduct === 'veles' && params.slotName === 'TOP_LEADERBOARD' && win.pbjs) {
			var bidsReceived = win.pbjs._bidsReceived;

			bidsReceived.filter(function (bid) {
				return bid.adId === params.hbAdId;
			}).forEach(function (usedBid) {
				bidsReceived = bidsReceived.filter(function (bid) {
					var result = true;

					if (bid.bidderRequestId === usedBid.bidderRequestId && bid.bidder === params.adProduct) {
						if (bid.adUnitCode === params.slotName) {
							result = true;
						} else {
							result = false;
						}
					} else {
						result = true;
					}

					return result;
				});
			});

			win.pbjs._bidsReceived = bidsReceived;
		}
	}

	function getVideoContainer(slotName) {
		var container = doc.createElement('div'),
			providerContainer = doc.querySelector('#' + slotName + ' > .provider-container');

		container.classList.add('vpaid-container');
		providerContainer.appendChild(container);

		return container;
	}

	function isVpaid(contentType) {
		return contentType.indexOf('application/') === 0;
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
		if (params.vpaidMode === googleIma.vpaidMode.INSECURE) {
			params.originalContainer = params.container;
			params.container = getVideoContainer(params.slotName);
		}

		hideOtherBidsForVeles(params);

		porvata.inject(videoSettings.create(params)).then(function (video) {
			if (params.vpaidMode === googleIma.vpaidMode.INSECURE) {
				var videoPlayer = params.container.querySelector('.video-player');

				video.addEventListener('loaded', function () {
					var ad = video.ima.getAdsManager().getCurrentAd();

					if (ad && isVpaid(ad.getContentType() || '')) {
						params.container.classList.add('vpaid-enabled');
						DOMElementTweaker.show(videoPlayer);
					}
				});

				video.addEventListener('allAdsCompleted', function () {
					DOMElementTweaker.hide(videoPlayer);
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
