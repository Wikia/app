/*global define, require*/
define('ext.wikia.adEngine.template.bfaaDesktop', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
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
		return {
			width: document.body.clientWidth,
			height: document.body.clientWidth / params.videoAspectRatio
		};
	}

	function loadVideoAd(params) {
		return function () {
			try {
				var video = videoAdFactory.create(
					adSlot.querySelector('div:last-of-type'),
					getSlotSize(params),
					adSlot,
					{
						src: 'gpt',
						slotName: params.slotName,
						uap: params.uap,
						passback: 'vuap'
					}
				);

				window.addEventListener('resize', function () {
					video.updateSize(getSlotSize(params));
				});

				params.videoTriggerElement.addEventListener('click', video.play.bind(video));

			} catch (error) {
				log(['Video can\'t be loaded correctly', error.message], log.levels.warning, logGroup);
			}
		};
	}

	function show(params) {
		adSlot = doc.getElementById(params.slotName);
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
