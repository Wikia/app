/*global define, require*/
define('ext.wikia.adEngine.template.bfaaMobile', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.uapVideoAd',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (
	adHelper,
	uapContext,
	btfBlocker,
	slotTweaker,
	uapVideoAd,
	doc,
	log,
	win,
	mercuryListener
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfaaMobile',
		page,
		unblockedSlots = [
			'MOBILE_BOTTOM_LEADERBOARD',
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER'
		],
		wrapper;

	function runOnReady(iframe, params) {
		var adContainer = doc.getElementById(params.slotName),
			aspectRatio = params.aspectRatio,
			adsModule = win.Mercury.Modules.Ads.getInstance(),
			adjustPadding = function () {
				var viewPortWidth = Math.max(doc.documentElement.clientWidth, win.innerWidth || 0),
					height = aspectRatio ?
						viewPortWidth / aspectRatio : iframe.contentWindow.document.body.offsetHeight;
				page.style.paddingTop = height + 'px';
				adsModule.setSiteHeadOffset(height);
			},
			onResize = adHelper.throttle(adjustPadding, 100);

		page.classList.add('bfaa-template');
		adjustPadding();

		win.addEventListener('resize', onResize);
		if (mercuryListener) {
			mercuryListener.onPageChange(function () {
				page.classList.remove('bfaa-template');
				page.style.paddingTop = '';
				adsModule.setSiteHeadOffset(0);
				win.removeEventListener('resize', onResize);
			});
		}

		if (params.videoUrl && params.videoTriggerElement) {
			slotTweaker.onReady(params.slotName, function() {
				var divs = doc.querySelectorAll('#' + params.slotName + ' > div'),
					imageContainer = divs[divs.length - 1],
					video = uapVideoAd.init(adContainer, imageContainer, params.videoUrl);

				params.videoTriggerElement.addEventListener('click', function () {
					uapVideoAd.playAndToggle(adContainer, video, imageContainer);
					aspectRatio = video.videoWidth / video.videoHeight;
					onResize();
				});

				video.addEventListener('ended', function () {
					aspectRatio = params.aspectRatio;
					onResize();
				});
			});
		}
	}

	function show(params) {
		page = doc.getElementsByClassName('application-wrapper')[0];
		wrapper = doc.getElementsByClassName('mobile-top-leaderboard')[0];

		log(['show', page, wrapper, params], 'info', logGroup);

		wrapper.style.opacity = '0';
		slotTweaker.makeResponsive(params.slotName, params.aspectRatio);
		slotTweaker.onReady(params.slotName, function (iframe) {
			runOnReady(iframe, params);
			wrapper.style.opacity = '';
		});

		log(['show', params.uap], 'info', logGroup);

		uapContext.setUapId(params.uap);
		unblockedSlots.forEach(btfBlocker.unblock);
	}

	return {
		show: show
	};
});
