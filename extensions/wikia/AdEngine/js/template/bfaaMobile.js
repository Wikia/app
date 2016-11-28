/*global define, require*/
define('ext.wikia.adEngine.template.bfaaMobile', [
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.uapVideo',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (
	uapContext,
	btfBlocker,
	slotTweaker,
	uapVideo,
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
		unblockedSlots = [
			'MOBILE_BOTTOM_LEADERBOARD',
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER'
		],
		wrapper;

	function adjustPadding(iframe, aspectRatio) {
		var viewPortWidth = Math.max(doc.documentElement.clientWidth, win.innerWidth || 0),
			height = aspectRatio ? viewPortWidth / aspectRatio : iframe.contentWindow.document.body.offsetHeight;

		page.style.paddingTop = height + 'px';
		adsModule.setSiteHeadOffset(height);
	}

	function runOnReady(iframe, params) {
		function onResize(aspectRatio) {
			adjustPadding(iframe, aspectRatio);
		}

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

		if (uapVideo.isEnabled(params)) {
			uapVideo.init()
				.then(function () {
					var video = uapVideo.loadVideoAd(params, adSlot, imageContainer);

					video.addEventListener(win.google.ima.AdEvent.Type.LOADED, function () {
						onResize(params.videoAspectRatio);

						hideLearnMore();
					});

					video.addEventListener(win.google.ima.AdEvent.Type.ALL_ADS_COMPLETED, function () {
						onResize(params.aspectRatio);
					});
				});
		}
	}

	function hideLearnMore() {
		var imaIframe = doc.querySelector('.video-ima-container iframe');
		if (imaIframe) {
			imaIframe.style['z-index'] = -1;
		}
	}

	function show(params) {
		adSlot = doc.getElementById(params.slotName);
		imageContainer = adSlot.querySelector('div:last-of-type');

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
