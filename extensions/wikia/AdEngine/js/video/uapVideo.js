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
		positionVideoPlayerClassName = 'video-player-',
		uapTypesToMegaMap = {
			'abcd': true
		};

	function getVideoSize(slot, params, videoSettings) {
		var width = slot.clientWidth;

		// we don't want to have fullscreen (slot.clientWidth) video in case of split
		// layout or on mercury.
		// On mercury splitLayoutVideoPosition and videoPlaceholderElement will be empty
		// because we always display video in the same way there.
		if (videoSettings.isSplitLayout() && params.videoPlaceholderElement) {
			width = params.videoPlaceholderElement.offsetWidth;
		}

		return {
			width: width,
			height: width / params.videoAspectRatio
		};
	}

	function shouldUseMegaAdUnitBuilder(type) {
		return uapTypesToMegaMap[type];
	}

	function loadPorvata(params, slotContainer, providerContainer, videoSettings) {
		params.container = slotContainer;

		log(['VUAP loadPorvata', params], log.levels.debug, logGroup);

		return porvata.inject(videoSettings)
			.then(function (video) {
				video.container.style.position = 'relative';
				if (mercuryListener) {
					mercuryListener.onPageChange(function () {
						video.destroy();
					});
				}

				return video;
			})
			.then(function (video) {
				var splitLayoutVideoPosition = params.splitLayoutVideoPosition,
					template = UITemplate.selectTemplate(videoSettings);

				videoInterface.setup(video, template, {
					aspectRatio: params.aspectRatio,
					autoPlay: videoSettings.isAutoPlay(),
					container: slotContainer,
					hideWhenPlaying: params.videoPlaceholderElement || params.image,
					image: providerContainer,
					videoAspectRatio: params.videoAspectRatio
				});

				if (splitLayoutVideoPosition) {
					video.container.style.position = 'absolute';
					video.container.classList.add(positionVideoPlayerClassName + splitLayoutVideoPosition);
				}

				video.addEventListener('wikiaAdCompleted', function () {
					video.reload();
				});

				return video;
			});
	}

	function loadPlaywire(params, adSlot, providerContainer, videoSettings) {
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
					var size = getVideoSize(adSlot, params, videoSettings);
					video.resize(size.width, size.height);
				});

				if (params.autoPlay) {
					var size = getVideoSize(adSlot, params, videoSettings);
					video.play(size.width, size.height);
				}

				return video;
			});
	}

	function loadVideoAd(videoSettings) {
		var params = videoSettings.getParams(),
			loadedPlayer,
			providerContainer = adSlot.getProviderContainer(params.slotName),
			uapType = uapContext.getType(),
			videoContainer = providerContainer.parentNode,
			size;

		log(['loadVideoAd params', params], log.levels.debug, logGroup);

		size = getVideoSize(videoContainer, params, videoSettings);
		params.width = size.width;
		params.height = size.height;
		params.useMegaAdUnitBuilder = shouldUseMegaAdUnitBuilder(uapType);
		params.vastTargeting = {
			src: params.src,
			pos: params.slotName,
			passback: uapType,
			uap: uapContext.getUapId()
		};

		log(['loadVideoAd upadated params', params], log.levels.debug, logGroup);

		if (params.player === 'playwire') {
			loadedPlayer = loadPlaywire(params, videoContainer, providerContainer, videoSettings);
		} else {
			loadedPlayer = loadPorvata(params, videoContainer, providerContainer, videoSettings);
		}

		return loadedPlayer.then(function (video) {
			function playVideo() {
				var videoSize = getVideoSize(videoContainer, params, videoSettings);
				video.play(videoSize.width, videoSize.height);
			}

			function resizeVideo() {
				var videoSize = getVideoSize(videoContainer, params, videoSettings);
				video.resize(videoSize.width, videoSize.height);
			}

			if (params.videoTriggerElement) {
				params.videoTriggerElement.addEventListener('click', playVideo);
			} else if (params.videoTriggers) {
				params.videoTriggers.forEach(function (trigger) {
					trigger.addEventListener('click', playVideo);
				});
			}

			win.addEventListener('resize', throttle(resizeVideo));
			video.addEventListener('play', resizeVideo);

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
