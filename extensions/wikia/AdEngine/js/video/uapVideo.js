/*global define*/
define('ext.wikia.adEngine.video.uapVideo', [
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.video.player.porvata',
	'ext.wikia.adEngine.video.player.playwire',
	'ext.wikia.adEngine.video.player.ui.videoInterface',
	'ext.wikia.adEngine.video.player.uiTemplate',
	'ext.wikia.adEngine.video.videoSettings',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (uapContext, adSlot, porvata, playwire, videoInterface, UITemplate, VideoSettings, doc, log, throttle, win, mercuryListener) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.uapVideo',
		positionVideoPlayerClassName = 'video-player-';

	function getVideoSize(slot, params) {
		var width = slot.clientWidth;

		// we don't want to have fullscreen (slot.clientWidth) video in case of split
		// layout or on mercury.
		// On mercury splitLayoutVideoPosition and videoPlaceholderElement will be empty
		// because we always display video in the same way there.
		if (params.splitLayoutVideoPosition && params.videoPlaceholderElement) {
			width = params.videoPlaceholderElement.offsetWidth;
		}

		return {
			width: width,
			height: width / params.videoAspectRatio
		};
	}

	function loadPorvata(params, slotContainer, providerContainer, videoSettings) {
		params.container = slotContainer;
		videoSettings = videoSettings || VideoSettings.create(params);

		log(['VUAP loadPorvata', params], log.levels.debug, logGroup);

		return porvata.inject(params, videoSettings)
			.then(function (video) {
				if (mercuryListener) {
					mercuryListener.onPageChange(function () {
						video.destroy();
					});
				}

				return video;
			})
			.then(function (video) {
				var splitLayoutVideoPosition = params.splitLayoutVideoPosition,
					template = UITemplate.defaultLayout;

				if (params.splitLayoutVideoPosition) {
					template = UITemplate.splitLayout;
				} else if (videoSettings.isAutoPlay()) {
					template = UITemplate.autoPlayLayout;
				}

				log(['VUAP UI elements', template], log.levels.debug, logGroup);

				videoInterface.setup(video, template, {
					image: providerContainer,
					container: slotContainer,
					aspectRatio: params.aspectRatio,
					videoAspectRatio: params.videoAspectRatio,
					hideWhenPlaying: params.videoPlaceholderElement || params.image
				});

				if (splitLayoutVideoPosition) {
					video.container.style.position = 'absolute';
					video.container.classList.add(positionVideoPlayerClassName + splitLayoutVideoPosition);
				}

				video.addEventListener('allAdsCompleted', function () {
					video.reload();
				});

				return video;
			});
	}

	function loadPlaywire(params, adSlot, providerContainer) {
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
					image: providerContainer,
					container: adSlot,
					aspectRatio: params.aspectRatio,
					videoAspectRatio: params.videoAspectRatio
				});

				video.addEventListener('wikiaAdStarted', function () {
					var size = getVideoSize(adSlot, params);
					video.resize(size.width, size.height);
				});

				if (params.autoPlay) {
					var size = getVideoSize(adSlot, params);
					video.play(size.width, size.height);
				}

				return video;
			});
	}

	function loadVideoAd(params, videoSettings) {
		var loadedPlayer,
			providerContainer = adSlot.getProviderContainer(params.slotName),
			videoContainer = providerContainer.parentNode,
			size;

		log(['loadVideoAd params', params], log.levels.debug, logGroup);

		size = getVideoSize(videoContainer, params);
		params.width = size.width;
		params.height = size.height;
		params.adProduct = 'vuap';
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
			loadedPlayer = loadPorvata(params, videoContainer, providerContainer, videoSettings);
		}

		return loadedPlayer.then(function (video) {
			function playVideo() {
				var videoSize = getVideoSize(videoContainer, params);
				video.play(videoSize.width, videoSize.height);
			}

			win.addEventListener('resize', throttle(function () {
				var videoSize = getVideoSize(videoContainer, params);
				video.resize(videoSize.width, videoSize.height);
			}));

			if (params.videoTriggerElement) {
				params.videoTriggerElement.addEventListener('click', playVideo);
			} else if (params.videoTriggers) {
				params.videoTriggers.forEach(function (trigger) {
					trigger.addEventListener('click', playVideo);
				});
			}

			return video;
		});
	}

	/**
	 * Check if all required params are present
	 *
	 * @param params
	 * @returns bool
	 */
	function isEnabled(params) {
		return !!params.videoAspectRatio && (params.videoTriggerElement || params.videoTriggers);
	}

	return {
		isEnabled: isEnabled,
		loadVideoAd: loadVideoAd
	};
});
