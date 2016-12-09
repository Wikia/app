/*global define*/
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.template.porvata',
	'ext.wikia.adEngine.template.playwire',
	'ext.wikia.adEngine.video.player.ui.progressBarFactory',
	'ext.wikia.adEngine.video.uapVideoAnimation',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adHelper, uapContext, porvata, playwire, progressBarFactory, uapVideoAnimation, videoAdFactory, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.uapVideo';

	function getVideoHeight(width, params) {
		return width / params.videoAspectRatio;
	}

	function getSlotWidth(slot) {
		return slot.clientWidth;
	}

	function addProgressBar(video) {
		var progressBar = progressBarFactory.create(video);

		video.addEventListener('start', progressBar.start);
		video.addEventListener('resume', progressBar.start);
		video.addEventListener('complete', progressBar.reset);
		video.addEventListener('pause', progressBar.pause);

		video.container.appendChild(progressBar.container);
	}

	function loadPorvata(params, adSlot, imageContainer) {
		params.container = adSlot;

		log(['VUAP loadPorvata', params], log.levels.debug, logGroup);
		return porvata.show(params)
			.then(function (video) {
				addProgressBar(video);

				video.addEventListener('loaded', function () {
					uapVideoAnimation.showVideo(video, imageContainer, adSlot, params);
				});

				video.addEventListener('allAdsCompleted', function () {
					uapVideoAnimation.hideVideo(video, imageContainer, adSlot, params);
					video.stop();
				});

				return video;
			});
	}

	function loadPlaywire(params, adSlot, imageContainer) {
		var container = doc.createElement('div');

		container.id = 'playwire_player';
		container.classList.add('hidden');
		adSlot.appendChild(container);

		params.container = container;
		params.disableAds = true;

		log(['VUAP loadPlaywire', params], log.levels.debug, logGroup);
		return playwire.show(params)
			.then(function (video) {
				video.addEventListener('boltContentStarted', function () {
					uapVideoAnimation.showVideo(video, imageContainer, adSlot, params);
				});

				video.addEventListener('boltContentComplete', function () {
					uapVideoAnimation.hideVideo(video, imageContainer, adSlot, params);
					video.stop();
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
