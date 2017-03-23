/*global define, require*/
define('ext.wikia.adEngine.template.bfaaDesktop', [
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slot.resolvedState',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.uapVideo',
	'ext.wikia.adEngine.video.videoSettings',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
], function (uapContext,
			 btfBlocker,
			 resolvedState,
			 slotTweaker,
			 uapVideo,
			 VideoSettings,
			 doc,
			 log,
			 throttle,
			 win,
			 recoveryTweaker) {
	'use strict';

	var breakPointWidthNotSupported = 767, // SCSS property: $breakpoint-width-not-supported
		logGroup = 'ext.wikia.adEngine.template.bfaaDesktop',
		nav,
		page,
		slotContainer,
		unblockedSlots = [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1'
		],
		wrapper;

	function updateNavBar(height) {
		var position = win.scrollY || win.pageYOffset;

		log(['updateNavBar', height, position], log.levels.info, logGroup);

		if (doc.body.offsetWidth <= breakPointWidthNotSupported || position <= height) {
			nav.classList.add('bfaa-pinned');
		} else {
			nav.classList.remove('bfaa-pinned');
		}
	}

	function runOnReady(iframe, params, videoSettings) {
		var spotlightFooter = doc.getElementById('SPOTLIGHT_FOOTER');

		nav.style.top = '';
		page.classList.add('bfaa-template');
		if (!win.ads.runtime.disableCommunitySkinOverride) {
			doc.body.classList.add('uap-skin');
		}

		log('desktopHandler::show', log.levels.info, logGroup);

		updateNavBar(slotContainer.offsetHeight);
		doc.addEventListener('scroll', throttle(function () {
			updateNavBar(slotContainer.offsetHeight);
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

		if (uapVideo.isEnabled(params)) {
			uapVideo.loadVideoAd(videoSettings);
		}
	}

	function refreshMedrecSlot() {
		var slotName = 'TOP_RIGHT_BOXAD';
		slotTweaker.hide(slotName);
		win.adslots2.push(slotName);
	}

	function show(params) {
		var videoSettings;

		slotContainer = doc.getElementById(params.slotName);
		nav = doc.getElementById('globalNavigation');
		page = doc.getElementsByClassName('WikiaSiteWrapper')[0];
		wrapper = doc.getElementById('WikiaTopAds');

		log(['show', page, wrapper, params], log.levels.info, logGroup);

		wrapper.style.opacity = '0';
		uapContext.setUapId(params.uap);

		if (params.loadMedrecFromBTF) {
			refreshMedrecSlot();
		}

		videoSettings = VideoSettings.create(params);
		resolvedState.setImage(videoSettings);

		slotTweaker.makeResponsive(params.slotName, params.aspectRatio);
		slotTweaker.onReady(params.slotName, function (iframe) {
			runOnReady(iframe, params, videoSettings);
			wrapper.style.opacity = '';
		});

		unblockedSlots.forEach(btfBlocker.unblock);
		log(['show', params.uap], log.levels.info, logGroup);
	}

	return {
		show: show
	};
});
