/*global define, require*/
define('ext.wikia.adEngine.template.bfaaDesktop', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.videoAd',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (
	adHelper,
	uapContext,
	btfBlocker,
	slotTweaker,
	videoAd,
	doc,
	log,
	win,
	recoveryTweaker
) {
	'use strict';

	var adSlot,
		breakPointWidthNotSupported = 767, // SCSS property: $breakpoint-width-not-supported
		logGroup = 'ext.wikia.adEngine.template.bfaaDesktop',
		nav,
		page,
		unblockedSlots = [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1'
		],
		wrapper;


	function updateNavBar(height) {
		var position = win.scrollY || win.pageYOffset;

		log(['updateNavBar', height, position], 'info', logGroup);

		if (doc.body.offsetWidth <= breakPointWidthNotSupported || position <= height) {
			nav.classList.add('bfaa-pinned');
		} else {
			nav.classList.remove('bfaa-pinned');
		}
	}

	function runOnReady(iframe, params) {
		var spotlightFooter = doc.getElementById('SPOTLIGHT_FOOTER');

		nav.style.top = '';
		page.classList.add('bfaa-template');

		log('desktopHandler::show', 'info', logGroup);

		updateNavBar(adSlot.offsetHeight);
		doc.addEventListener('scroll', adHelper.throttle(function () {
			updateNavBar(adSlot.offsetHeight);
		}, 100));

		if (win.WikiaBar) {
			win.WikiaBar.hideContainer();
		}

		if (spotlightFooter) {
			spotlightFooter.parentNode.style.display = 'none';
		}

		if (recoveryTweaker && recoveryTweaker.isTweakable()) {
			slotTweaker.removeDefaultHeight(params.slotName);
			recoveryTweaker.tweakSlot(params.slotName, iframe);
		}

		if (videoEnabled(params)) {
			videoAd.onLibraryReady(function () {
				var playTrigger = videoAd.setupVideo(
					adSlot.querySelector('div:last-of-type'),
					document.body.clientWidth,
					document.body.clientWidth / params.videoAspectRatio,
					adSlot,
					{
						src: 'gpt',
						slotName: params.slotName,
						uap: params.uap
					}
				);

				params.videoTriggerElement.addEventListener('click', playTrigger);
			});
		}
	}

	function videoEnabled(params) {
		return params.videoTriggerElement && params.videoAspectRatio;
	}

	function show(params) {
		adSlot = doc.getElementById(params.slotName);
		nav = doc.getElementById('globalNavigation');
		page = doc.getElementsByClassName('WikiaSiteWrapper')[0];
		wrapper = doc.getElementById('WikiaTopAds');

		if (videoEnabled(params)) {
			videoAd.init();
		}

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
