/*global define*/
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.video.porvata',
	'ext.wikia.adEngine.video.player.playwire.playwire',
	'ext.wikia.adEngine.video.player.ui.videoInterface',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adHelper, uapContext, adSlot, porvata, playwire, videoInterface, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.uapVideo';

	function getVideoHeight(params) {
		return params.width / params.videoAspectRatio;
	}

	function getSlotWidth(slot) {
		return slot.clientWidth;
	}

	function loadPorvata(params, slotContainer, providerContainer) {
		params.container = slotContainer;

		log(['VUAP loadPorvata', params], log.levels.debug, logGroup);

		return porvata.inject(params)
			.then(function (video) {
				videoInterface.setup(video, [
					'progressBar',
					'pauseOverlay',
					'volumeControl',
					'closeButton',
					'toggleAnimation'
				], {
					image: providerContainer,
					container: slotContainer,
					aspectRatio: params.aspectRatio,
					videoAspectRatio: params.videoAspectRatio
				});

				video.addEventListener('allAdsCompleted', function () {
					video.reload();
				});

				return video;
			});
	}

	function loadPlaywire(params, adSlot, imageContainer) {
		var container = doc.createElement('div');

		container.classList.add('video-player', 'hidden');
		adSlot.appendChild(container);

		params.container = container;

		log(['VUAP loadPlaywire', params], log.levels.debug, logGroup);
		return playwire.inject(params)
			.then(function (video) {
				videoInterface.setup(video, [
					'closeButton',
					'toggleAnimation'
				], {
					image: imageContainer,
					container: adSlot,
					aspectRatio: params.aspectRatio,
					videoAspectRatio: params.videoAspectRatio
				});

				video.addEventListener('wikiaAdStarted', function () {
					var slotWidth = getSlotWidth(adSlot);
					video.resize(slotWidth, getVideoHeight(params));
				});
				if (params.autoplay) {
					var slotWidth = getSlotWidth(adSlot);
					video.play(slotWidth, getVideoHeight(params));
				}

				return video;
			});
	}

	function loadVideoAd(params) {
		var loadedPlayer,
			providerContainer = adSlot.getProviderContainer(params.slotName),
			slotContainer = providerContainer.parentNode;

		log(['loadVideoAd params', params], log.levels.debug, logGroup);

		params.width = getSlotWidth(slotContainer);
		params.height = getVideoHeight(params);
		params.vastTargeting = {
			src: params.src,
			pos: params.slotName,
			passback: 'vuap',
			uap: uapContext.getUapId()
		};

		log(['loadVideoAd upadated params', params], log.levels.debug, logGroup);

		if (params.player === 'playwire') {
			loadedPlayer = loadPlaywire(params, slotContainer, providerContainer);
		} else {
			loadedPlayer = loadPorvata(params, slotContainer, providerContainer);
		}

		return loadedPlayer.then(function (video) {
			win.addEventListener('resize', adHelper.throttle(function () {
				var slotWidth = getSlotWidth(slotContainer);
				video.resize(slotWidth, getVideoHeight(params));
			}));

			params.videoTriggerElement.addEventListener('click', function () {
				var slotWidth = getSlotWidth(slotContainer);
				video.play(slotWidth, getVideoHeight(params));
			});

			return video;
		});
	}

	function isEnabled(params) {
		return params.videoTriggerElement && params.videoAspectRatio;
	}

	return {
		isEnabled: isEnabled,
		loadVideoAd: loadVideoAd
	};
})
;
