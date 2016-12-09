/*global define*/
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.template.porvata',
	'ext.wikia.adEngine.template.playwire',
	'ext.wikia.adEngine.video.player.ui.videoInterface',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adHelper, uapContext, porvata, playwire, videoInterface, videoAdFactory, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.uapVideo';

	function getVideoHeight(width, params) {
		return width / params.videoAspectRatio;
	}

	function getSlotWidth(slot) {
		return slot.clientWidth;
	}

	function loadPorvata(params, adSlot, imageContainer) {
		params.container = adSlot;

		log(['VUAP loadPorvata', params], log.levels.debug, logGroup);
		return porvata.show(params)
			.then(function (video) {
				videoInterface.setup(video, [
					'progressBar',
					'pauseOverlay',
					'volumeControl',
					'closeButton',
					'toggleAnimation'
				], {
					image: imageContainer,
					container: adSlot,
					aspectRatio: params.aspectRatio,
					videoAspectRatio: params.videoAspectRatio
				});

				return video;
			});
	}

	function loadPlaywire(params, adSlot, imageContainer) {
		var container = doc.createElement('div');

		container.classList.add('video-player', 'hidden');
		adSlot.appendChild(container);

		params.container = container;
		params.disableAds = true;

		log(['VUAP loadPlaywire', params], log.levels.debug, logGroup);
		return playwire.show(params)
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

				return video;
			});
	}

	function loadVideoAd(params, adSlot, imageContainer) {
		var loadedPlayer,
			videoWidth = getSlotWidth(adSlot);

		params.width = videoWidth;
		params.height = getVideoHeight(videoWidth, params);
		params.vastTargeting = {
			src: params.src,
			pos: params.slotName,
			passback: 'vuap',
			uap: params.uap || uapContext.getUapId()
		};

		switch (params.player) {
			case 'playwire':
				loadedPlayer = loadPlaywire(params, adSlot, imageContainer);
				break;
			default:
				loadedPlayer = loadPorvata(params, adSlot, imageContainer);
		}

		loadedPlayer.then(function (video) {
			win.addEventListener('resize', adHelper.throttle(function () {
				var slotWidth = getSlotWidth(adSlot);
				video.resize(slotWidth, getVideoHeight(slotWidth, params));
			}));

			params.videoTriggerElement.addEventListener('click', function () {
				var slotWidth = getSlotWidth(adSlot);
				video.play(slotWidth, getVideoHeight(slotWidth, params));
			});

			return video;
		});
	}

	function isEnabled(params) {
		return params.videoTriggerElement && params.videoAspectRatio;
	}

	return {
		init: videoAdFactory.init,
		isEnabled: isEnabled,
		loadVideoAd: loadVideoAd
	};
});
