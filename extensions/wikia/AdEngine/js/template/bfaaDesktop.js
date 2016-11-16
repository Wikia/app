/*global define, require*/
define('ext.wikia.adEngine.template.bfaaDesktop', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.video.videoAdFactory',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.tweaker')
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
	recoveryTweaker
) {
	'use strict';

	var adSlot,
		animationDuration = 400,
		breakPointWidthNotSupported = 767, // SCSS property: $breakpoint-width-not-supported
		logGroup = 'ext.wikia.adEngine.template.bfaaDesktop',
		nav,
		page,
		imageContainer,
		slotSizes,
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

	function runOnReady(iframe, params) {
		var spotlightFooter = doc.getElementById('SPOTLIGHT_FOOTER');

		nav.style.top = '';
		page.classList.add('bfaa-template');

		log('desktopHandler::show', log.levels.info, logGroup);

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

		if (params.videoTriggerElement && params.videoAspectRatio) {
			videoAdFactory.init()
				.then(loadVideoAd(params));
		}
	}

	function getSlotSize(params) {
		var width = document.body.clientWidth;
		return {
			width: width,
			videoHeight: width / params.videoAspectRatio,
			adHeight: width / params.aspectRatio
		};
	}

	function loadVideoAd(params) {
		return function () {
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

				params.videoTriggerElement.addEventListener('click', function() {
					video.play(showVideo, hideVideo);
				});

			} catch (error) {
				log(['Video can\'t be loaded correctly', error.message], log.levels.warning, logGroup);
			}
		};
	}

	function showVideo(videoContainer) {
		adSlot.style.height = slotSizes.adHeight + 'px';
		DOMElementTweaker.hide(imageContainer, false);
		DOMElementTweaker.removeClass(videoContainer, 'hidden');
		setTimeout(function () {
			adSlot.style.height = slotSizes.videoHeight + 'px';
		}, 0);

		setTimeout(function () {
			adSlot.style.height = '';
		}, animationDuration);
	}

	function hideVideo(videoContainer) {
		adSlot.style.height = slotSizes.videoHeight + 'px';
		setTimeout(function () {
			adSlot.style.height = slotSizes.adHeight + 'px';
		}, 0);

		setTimeout(function () {
			DOMElementTweaker.hide(videoContainer, false);
			DOMElementTweaker.removeClass(imageContainer, 'hidden');
		}, animationDuration);

		setTimeout(function () {
			adSlot.style.height = '';
		}, animationDuration);
	}

	function show(params) {
		adSlot = doc.getElementById(params.slotName);
		imageContainer = adSlot.querySelector('div:last-of-type');
		slotSizes = getSlotSize(params);
		nav = doc.getElementById('globalNavigation');
		page = doc.getElementsByClassName('WikiaSiteWrapper')[0];
		wrapper = doc.getElementById('WikiaTopAds');

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
