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
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener'),
	require.optional('ext.wikia.adEngine.wrappers.prebid')
], function (
	DOMElementTweaker,
	slotRegistry,
	slotTweaker,
	porvata,
	uiTemplate,
	videoInterface,
	videoFrequencyMonitor,
	videoSettings,
	browserDetect,
	doc,
	log,
	win,
	mercuryListener,
	prebid
) {
	'use strict';
	var fallbackBidders = [
			'appnexusAst',
			'rubicon'
		],
		logGroup = 'ext.wikia.adEngine.template.porvata',
		videoAspectRatio = 640 / 360;

	function callHop(params, shouldSetStatus) {
		if (shouldSetStatus) {
			slotRegistry.get(params.slotName).hop({
				adType: params.adType,
				source: 'porvata'
			});
		}
	}

	function callSuccess(params, shouldSetStatus) {
		if (shouldSetStatus) {
			slotRegistry.get(params.slotName).success({
				adType: params.adType,
				source: 'porvata'
			});
		}
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
		return contentType === 'application/javascript';
	}

	function dispatchEventWhenInViewport(video, eventName) {
		if (video.wasInViewport) {
			video.ima.dispatchEvent(eventName);
		} else {
			video.addEventListener('wikiaFirstTimeInViewport', function () {
				video.ima.dispatchEvent(eventName);
			});
		}
	}

	function enabledFallbackBidHandling(video, videoSettings, params) {
		var hasDirectAd = true,
			fallbackAdRequested = false;

		video.addEventListener('wikiaAdsManagerLoaded', function () {
			if (hasDirectAd) {
				dispatchEventWhenInViewport(video, 'wikiaInViewportWithDirect');
				callSuccess(params, params.setSlotStatusBasedOnVAST);
			}
		});

		video.addEventListener('wikiaEmptyAd', function () {
			var fallbackBid,
				offerEvent = 'wikiaInViewportWithoutOffer';

			if (fallbackAdRequested) {
				return;
			}

			hasDirectAd = false;
			fallbackBid = prebid.getWinningVideoBidBySlotName(params.slotName, fallbackBidders);
			if (fallbackBid) {
				fallbackAdRequested = true;
				params.bid = fallbackBid;

				offerEvent = 'wikiaInViewportWithFallbackBid';
				videoSettings.setMoatTracking(false);

				video.reload({
					height: params.height,
					width: params.width,
					vastResponse: fallbackBid.vastContent,
					vastUrl: fallbackBid.vastUrl
				});
				if (typeof params.fallbackBidBlockOutOfViewportPausing !== 'undefined') {
					params.blockOutOfViewportPausing = params.fallbackBidBlockOutOfViewportPausing;
				}
				if (typeof params.fallbackBidEnableInContentFloating !== 'undefined') {
					params.enableInContentFloating = params.fallbackBidEnableInContentFloating;
				}
				if (typeof params.fallbackBidEnableLeaderboardFloating !== 'undefined') {
					params.enableLeaderboardFloating = params.fallbackBidEnableLeaderboardFloating;
				}
				callSuccess(params, params.setSlotStatusBasedOnVAST);
			} else {
				callHop(params, params.setSlotStatusBasedOnVAST);
			}

			dispatchEventWhenInViewport(video, offerEvent);
		});
	}

	function onReady(video, params) {
		var slot = doc.getElementById(params.slotName),
			slotWidth;

		slot.classList.add('porvata-outstream');
		video.addEventListener('loaded', function () {
			video.container.classList.remove('hidden');
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
	 * @param {string} [params.hbAdId] - Prebid ad id of winning offer
	 * @param {function} [params.onReady] - Callback executed once player is ready
	 * @param {string} [params.useBidAsFallback] - Decides whether use bid as fallback
	 * @param {string} [params.vastUrl] - Vast URL (DFP URL with page level targeting will be used if not passed)
	 * @param {integer} [params.vpaidMode] - VPAID mode from IMA: https://developers.google.com/interactive-media-ads/docs/sdks/html5/v3/apis#ima.ImaSdkSettings.VpaidMode
	 * @param {Boolean} [params.isDynamic] - Flag defining if slot should be collapsed and expanded
	 * @param {Boolean} [params.setSlotStatusBasedOnVAST] - Decides whether slot status is dispatched manually or based on VAST response
	 */
	function show(params) {
		var imaVpaidModeInsecure = 2,
			settings;

		log(['show', params], log.levels.debug, logGroup);

		if (prebid && params.hbAdId) {
			params.bid = prebid.getBidByAdId(params.hbAdId);
			params.vastResponse = params.bid.vastContent || null;
			params.vastUrl = params.bid.vastUrl;
		}

		if (!isVideoAutoplaySupported()) {
			log(['hop', params.adProduct, params.slotName, params], log.levels.info, logGroup);
			callHop(params, true);

			return;
		}

		callSuccess(params, !params.setSlotStatusBasedOnVAST);

		if (params.vpaidMode === imaVpaidModeInsecure) {
			params.originalContainer = params.container;
			params.container = getVideoContainer(params.slotName);
		}

		if (params.isDynamic) {
			slotTweaker.collapse(params.slotName, true);
			slotTweaker.makeResponsive(params.slotName, videoAspectRatio);
		}

		settings = videoSettings.create(params);
		porvata.inject(settings).then(function (video) {
			var imaVpaidMode = win.google.ima.ImaSdkSettings.VpaidMode,
				templateName = params.isDynamic ? 'outstreamIncontent' : 'outstreamLeaderboard',
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

			onReady(video, params);

			if (prebid && params.useBidAsFallback) {
				enabledFallbackBidHandling(video, settings, params);
			}
			video.addEventListener('start', function () {
				videoFrequencyMonitor.registerLaunchedVideo();
			});

			if (mercuryListener) {
				mercuryListener.onPageChange(function () {
					video.destroy();
				});
			}

			videoInterface.setup(video, uiTemplate[templateName], {
				container: params.container,
				isDynamic: params.isDynamic,
				slotName: params.slotName
			});

			return video;
		});
	}

	return {
		show: show
	};
});
