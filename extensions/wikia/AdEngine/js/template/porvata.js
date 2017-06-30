/*global define, require, setTimeout*/
define('ext.wikia.adEngine.template.porvata', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.player.porvata',
	'ext.wikia.adEngine.video.player.uiTemplate',
	'ext.wikia.adEngine.video.player.ui.videoInterface',
	'ext.wikia.adEngine.video.videoFrequencyMonitor',
	'ext.wikia.adEngine.video.videoSettings',
	'ext.wikia.adEngine.wrappers.prebid',
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.prebid.adapters.veles'),
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (
	DOMElementTweaker,
	slotRegistry,
	slotTweaker,
	porvata,
	uiTemplate,
	videoInterface,
	videoFrequencyMonitor,
	videoSettings,
	prebid,
	browserDetect,
	doc,
	log,
	win,
	veles,
	mercuryListener
) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.template.porvata',
		videoAspectRatio = 640 / 360;

	function loadVeles(params) {
		params.vastResponse = params.vastResponse || params.bid.ad;
		veles.markBidsAsUsed(params.hbAdId);
	}

	function createInteractiveArea() {
		var controlBar = doc.createElement('div'),
			controlBarItems = doc.createElement('div'),
			interactiveArea = doc.createElement('div');

		controlBar.classList.add('control-bar');
		controlBarItems.classList.add('control-bar-items');
		interactiveArea.classList.add('interactive-area');

		controlBar.appendChild(controlBarItems);
		interactiveArea.appendChild(controlBar);

		return {
			controlBar: controlBar,
			controlBarItems: controlBarItems,
			interactiveArea: interactiveArea
		};
	}

	function getVideoContainer(slotName) {
		var container = doc.createElement('div'),
			displayWrapper = doc.createElement('div'),
			providerContainer = doc.querySelector('#' + slotName + ' > .provider-container');

		container.classList.add('video-overlay');
		displayWrapper.classList.add('video-display-wrapper');

		container.appendChild(displayWrapper);
		providerContainer.appendChild(container);

		return displayWrapper;
	}

	function isVpaid(contentType) {
		return contentType.indexOf('application/') === 0;
	}

	function onReady(video, params) {
		var slot = doc.getElementById(params.slotName),
			slotExpanded = false,
			slotWidth;

		video.addEventListener('loaded', function () {
			var adsManager = video.ima.getAdsManager(),
				videoContainer = video.container || video.ima.container;

			setTimeout(function () {
				adsManager.setVolume(0);
			});
			videoContainer.classList.remove('hidden');

			if (!params.hasUiControls) {
				params.container.addEventListener('mouseenter', function () {
					adsManager.setVolume(1);
				});
				params.container.addEventListener('mouseleave', function () {
					adsManager.setVolume(0);
				});
			}
		});

		video.addEventListener('start', function () {
			setTimeout(function () {
				video.ima.getAdsManager().setVolume(0);
			});

			if (params.isDynamic && !slotExpanded) {
				slotTweaker.expand(params.slotName);
				slotExpanded = true;
				video.ima.dispatchEvent('wikiaSlotExpanded');
			}

			if (params.isDynamic) {
				slotWidth = slot.scrollWidth;
				video.resize(slotWidth, slotWidth / videoAspectRatio);
			}
		});

		video.addEventListener('allAdsCompleted', function () {
			video.ima.getAdsManager().pause();
			if (params.isDynamic) {
				slotTweaker.collapse(params.slotName);
			}
		});

		if (params.isDynamic) {
			win.addEventListener('resize', function () {
				if (!(video.isFloating && video.isFloating())) {
					slotWidth = slot.clientWidth;
					video.resize(slotWidth, slotWidth / videoAspectRatio);
				}
			});
		}
	}

	function isVideoAutoplaySupported() {
		return !browserDetect.isAndroid() ||
			(browserDetect.getBrowser().indexOf('Chrome') !== -1 && browserDetect.getBrowserVersion() >= 54);
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
	 * @param {integer} [params.vpaidMode] - VPAID mode from IMA: https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.ImaSdkSettings.VpaidMode
	 * @param {Boolean} [params.isDynamic] - Flag defining if slot should be collapsed and expanded
	 */
	function show(params) {
		var imaVpaidModeInsecure = 2,
			settings;

		log(['show', params], log.levels.debug, logGroup);

		if (params.hbAdId) {
			params.bid = prebid.getBidByAdId(params.hbAdId);
			params.vastResponse = params.bid.vastContent || null;
			params.vastUrl = params.bid.vastUrl;
		}

		if (params.bid && params.adProduct === 'veles') {
			loadVeles(params);
		}

		if (!isVideoAutoplaySupported()) {
			log(['hop', params.adProduct, params.slotName, params], log.levels.info, logGroup);
			slotRegistry.get(params.slotName).hop({
				adType: params.adType,
				source: 'porvata'
			});

			return;
		} else {
			slotRegistry.get(params.slotName).success({
				adType: params.adType,
				source: 'porvata'
			});
		}

		if (params.vpaidMode === imaVpaidModeInsecure) {
			params.originalContainer = params.container;
			params.container = getVideoContainer(params.slotName);
		}

		if (params.isDynamic) {
			slotTweaker.collapse(params.slotName);
			slotTweaker.makeResponsive(params.slotName, videoAspectRatio);
		}

		settings = videoSettings.create(params);
		porvata.inject(settings).then(function (video) {
			if (typeof params.onReady === 'function') {
				params.onReady(video);
			} else {
				onReady(video, params);
			}

			video.addEventListener('start', function () {
				videoFrequencyMonitor.registerLaunchedVideo();
			});

			return video;
		}).then(function (video) {
			var imaVpaidMode = win.google.ima.ImaSdkSettings.VpaidMode,
				videoPlayer;

			if (params.vpaidMode === imaVpaidMode.INSECURE) {
				videoPlayer = params.container.querySelector('.video-player');

				video.addEventListener('loaded', function () {
					var ad = video.ima.getAdsManager().getCurrentAd();

					if (ad && isVpaid(ad.getContentType() || '')) {
						params.container.classList.add('vpaid-enabled');
						DOMElementTweaker.show(videoPlayer);
					}
				});

				video.addEventListener('allAdsCompleted', function () {
					DOMElementTweaker.hide(params.container);
				});
			}

			if (mercuryListener) {
				mercuryListener.onPageChange(function () {
					video.destroy();
				});
			}

			return video;
		}).then(function (video) {
			if (settings.hasUiControls()) {
				var elements = createInteractiveArea();

				video.container.appendChild(elements.interactiveArea);

				videoInterface.setup(video, uiTemplate.featureVideo, elements);
			}
		});
	}

	return {
		show: show
	};
});
