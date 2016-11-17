/*global define, require*/
define('ext.wikia.adEngine.template.bfaaMobile', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (
	adHelper,
	uapContext,
	DOMElementTweaker,
	btfBlocker,
	slotTweaker,
	videoAdFactory,
	doc,
	log,
	win,
	mercuryListener
) {
	'use strict';

	var adSlot,
		adsModule,
		logGroup = 'ext.wikia.adEngine.template.bfaaMobile',
		page,
		imageContainer,
		slotSizes,
		unblockedSlots = [
			'MOBILE_BOTTOM_LEADERBOARD',
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER'
		],
		wrapper;

	function getSlotSize(params) {
		var width = document.body.clientWidth;
		return {
			width: width,
			videoHeight: width / params.videoAspectRatio,
			adHeight: width / params.aspectRatio
		};
	}

	function adjustPadding(iframe, aspectRatio) {
		var viewPortWidth = Math.max(doc.documentElement.clientWidth, win.innerWidth || 0),
			height = aspectRatio ? viewPortWidth / aspectRatio : iframe.contentWindow.document.body.offsetHeight;

		page.style.paddingTop = height + 'px';
		adsModule.setSiteHeadOffset(height);
	}

	function runOnReady(iframe, params) {
		var onResize = function (aspectRatio) {
				adjustPadding(iframe, aspectRatio);
			};

		adsModule = win.Mercury.Modules.Ads.getInstance();
		page.classList.add('bfaa-template');
		adjustPadding(iframe, params.aspectRatio);
		win.addEventListener('resize', onResize.bind(null, params.aspectRatio));

		if (mercuryListener) {
			mercuryListener.onPageChange(function () {
				page.classList.remove('bfaa-template');
				page.style.paddingTop = '';
				adsModule.setSiteHeadOffset(0);
				win.removeEventListener('resize', onResize);
			});
		}

		if (videoAdFactory.isVideoAd(params)) {
			videoAdFactory.init().then(function () {
				try {
					var video = videoAdFactory.create(
						slotSizes.width,
						slotSizes.videoHeight,
						adSlot,
						{
							src: 'gpt',
							pos: params.slotName,
							uap: params.uap,
							passback: 'vuap'
						}
					);

					window.addEventListener('resize', adHelper.throttle(function () {
						slotSizes = getSlotSize(params);
						video.resize(slotSizes.width, slotSizes.videoHeight);
					}));

					params.videoTriggerElement.addEventListener('click', function () {
						video.play(showVideo, function (videoContainer) {
							hideVideo(videoContainer);
							onResize(params.aspectRatio);
						});
						onResize(params.videoAspectRatio);
					}.bind(video));

				} catch (error) {
					log(['Video can\'t be loaded correctly', error.message], log.levels.warning, logGroup);
				}
			});
		}
	}

	function showVideo(videoContainer) {
		DOMElementTweaker.hide(imageContainer, false);
		DOMElementTweaker.removeClass(videoContainer, 'hidden');
	}

	function hideVideo(videoContainer) {
		DOMElementTweaker.hide(videoContainer, false);
		DOMElementTweaker.removeClass(imageContainer, 'hidden');
	}

	function show(params) {
		adSlot = doc.getElementById(params.slotName);
		imageContainer = adSlot.querySelector('div:last-of-type');
		slotSizes = getSlotSize(params);

		page = doc.getElementsByClassName('application-wrapper')[0];
		wrapper = doc.getElementsByClassName('mobile-top-leaderboard')[0];

		log(['show', page, wrapper, params], log.levels.info, logGroup);

		wrapper.style.opacity = '0';
		slotTweaker.makeResponsive(params.slotName, params.aspectRatio);
		slotTweaker.onReady(params.slotName, function (iframe) {
			runOnReady(iframe, params);
			wrapper.style.opacity = '';
		});

		log(['show', params.uap], log.levels.info, logGroup);

		uapContext.setUapId(params.uap);
		unblockedSlots.forEach(btfBlocker.unblock);
	}

	return {
		show: show
	};
});
