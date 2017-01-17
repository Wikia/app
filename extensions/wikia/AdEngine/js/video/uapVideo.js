/*global define*/
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.video.player.porvata',
	'ext.wikia.adEngine.video.player.playwire',
	'ext.wikia.adEngine.video.player.ui.videoInterface',
	'ext.wikia.adEngine.video.player.uiTemplate',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adHelper, uapContext, adSlot, porvata, playwire, videoInterface, UITemplate, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.uapVideo';

	function getVideoHeight(slotWidth, aspectRatio) {
		return slotWidth / aspectRatio;
	}

	function getSlotWidth(slot) {
		return slot.clientWidth * 0.592;
	}

	function loadPorvata(params, slotContainer, providerContainer) {
		params.container = slotContainer;

		log(['VUAP loadPorvata', params], log.levels.debug, logGroup);

		return porvata.inject(params)
			.then(function (video) {
				var uiElements = params.autoPlay ? UITemplate.autoPlay : UITemplate.default;
				log(['VUAP UI elements', uiElements], log.levels.debug, logGroup);

				videoInterface.setup(video, uiElements, {
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
					video.resize(slotWidth, getVideoHeight(slotWidth, params.videoAspectRatio));
				});
				if (params.autoPlay) {
					var slotWidth = getSlotWidth(adSlot);
					video.play(slotWidth, getVideoHeight(slotWidth, params.videoAspectRatio));
				}

				return video;
			});
	}

	function loadVideoAd(params) {
		var loadedPlayer,
			providerContainer = adSlot.getProviderContainer(params.slotName),
			videoContainer = providerContainer.parentNode,
			videoWidth = getSlotWidth(videoContainer);

		log(['loadVideoAd params', params], log.levels.debug, logGroup);

		params.width = videoWidth;
		params.height = getVideoHeight(videoWidth, params.videoAspectRatio);
		params.vastTargeting = {
			src: params.src,
			pos: params.slotName,
			passback: 'vuap',
			uap: uapContext.getUapId()
		};

		log(['loadVideoAd upadated params', params], log.levels.debug, logGroup);

		if (params.player === 'playwire') {
			loadedPlayer = loadPlaywire(params, videoContainer, providerContainer);
		} else {
			loadedPlayer = loadPorvata(params, videoContainer, providerContainer);
		}

		return loadedPlayer.then(function (video) {
			win.addEventListener('resize', adHelper.throttle(function () {
				var slotWidth = getSlotWidth(videoContainer);
				video.resize(slotWidth, getVideoHeight(slotWidth, params.videoAspectRatio));
			}));

			params.videoTriggerElement.addEventListener('click', function () {
				var slotWidth = getSlotWidth(videoContainer);
				// video.play(slotWidth, getVideoHeight(slotWidth, params.videoAspectRatio));
				video.play();
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
});
