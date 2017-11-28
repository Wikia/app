/*global define, require*/
define('ext.wikia.adEngine.template.bfaaDesktop', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.googleSlots',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slot.resolvedState',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.video.uapVideo',
	'ext.wikia.adEngine.video.videoSettings',
	'ext.wikia.adEngine.utils.mutation',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.tweaker')
], function (
	adContext,
	btfBlocker,
	googleSlots,
	helper,
	resolvedState,
	slotTweaker,
	slotRegistry,
	uapVideo,
	VideoSettings,
	mutation,
	doc,
	log,
	throttle,
	win,
	recoveryTweaker
) {
	'use strict';

	var breakPointWidthNotSupported = 767, // SCSS property: $breakpoint-width-not-supported
		logGroup = 'ext.wikia.adEngine.template.bfaaDesktop',
		nav,
		page,
		isPinned = false,
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
			isPinned = true;
			nav.classList.add('bfaa-pinned');
		} else {
			isPinned = false;
			nav.classList.remove('bfaa-pinned');
		}
	}

	function runOnReady(iframe, params, videoSettings) {
		var spotlightFooter = doc.getElementById('SPOTLIGHT_FOOTER'),
			slot = slotRegistry.get(params.slotName);

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

		if (params.sticky && resolvedState.isResolvedState()) {
			handleStickiness(slot);
		}
	}

	function stick() {
		var innerWrapper = wrapper.querySelector('.WikiaTopAdsInner'),
			adHeight = innerWrapper.offsetHeight,
			stickyClassName = 'bfaa-sticky',
			animationDurationInSeconds = 1;

		function apply() {
			page.classList.add(stickyClassName);
			nav.style.top = (isPinned ? (adHeight - win.scrollY) : 0) + 'px';
			wrapper.style.height = adHeight + 'px';
			innerWrapper.style.top = (isPinned ? -win.scrollY : -adHeight) + 'px';

			setTimeout(function () {
				mutation.assign(nav.style, {
					top: adHeight + 'px',
					transition: 'top ' + animationDurationInSeconds + 's'
				});
				mutation.assign(innerWrapper.style, {
					top: 0,
					transition: 'top ' + animationDurationInSeconds + 's'
				});
			}, 0);

			log(['stick.apply'], log.levels.info, logGroup);
		}

        function revert() {
            nav.style.top = (isPinned ? (adHeight - win.scrollY) : 0) + 'px';
			innerWrapper.style.top = (isPinned ? -win.scrollY : -adHeight) + 'px';

            setTimeout(function () {
				page.classList.remove(stickyClassName);
				mutation.assign(nav.style, {
					top: '',
					transition: ''
				});
				mutation.assign(innerWrapper.style, {
					top: '',
					transition: ''
				});
				wrapper.style.height = '';
			}, animationDurationInSeconds * 1000);

			log(['stick.revert'], log.levels.info, logGroup);
		};

		return {
			apply: apply,
			revert: revert
		};
	}

	function handleStickiness(slot) {
		var stickiness = stick();

		function onViewed() {
			var revertTimeout = setTimeout(onRevertTimeout, 10000);

			function onRevertTimeout() {
				clearTimeout(revertTimeout);
				win.removeEventListener('scroll', onRevertTimeout);
				stickiness.revert();
			}

			win.addEventListener('scroll', onRevertTimeout);

			if (isPinned) {
				onRevertTimeout();
			}
		}

		function checkViewability() {
			if (!slot.isViewed) {
				stickiness.apply();
				slot.post('viewed', onViewed);
			}
		}

		if (top.document.hidden) {
			// let's start ticking from the moment when browser tab is active
			win.addEventListener('visibilitychange', checkViewability, {once: true});
		} else {
			checkViewability();
		}
	}

	function show(params) {
		var medrecSlotName = 'TOP_RIGHT_BOXAD',
			videoSettings;

		slotContainer = doc.getElementById(params.slotName);
		nav = doc.getElementById('globalNavigation');
		page = doc.getElementsByClassName('WikiaSiteWrapper')[0];
		wrapper = doc.getElementById('WikiaTopAds');

		log(['show', page, wrapper, params], log.levels.info, logGroup);

		wrapper.style.opacity = '0';

		videoSettings = VideoSettings.create(params);
		resolvedState.setImage(videoSettings);

		slotTweaker.makeResponsive(params.slotName, params.aspectRatio);
		slotTweaker.onReady(params.slotName, function (iframe) {
			runOnReady(iframe, params, videoSettings);
			wrapper.style.opacity = '';

			if (!adContext.get('opts.disableSra') && params.loadMedrecFromBTF) {
				// refresh after uapContext.setUapId if in SRA environment
				helper.refreshSlot(medrecSlotName);
			}
		});

		if (params.adProduct !== 'abcd') {
			unblockedSlots.forEach(btfBlocker.unblock);
		}

		log(['show', params.uap], log.levels.info, logGroup);
	}

	return {
		show: show
	};
});
