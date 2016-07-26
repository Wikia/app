/*global define, require*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.uapContext',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (
	adContext,
	adHelper,
	btfBlocker,
	slotTweaker,
	uapContext,
	doc,
	log,
	win,
	mercuryListener
) {
	'use strict';

	var breakPointWidthNotSupported = 767, // SCSS property: $breakpoint-width-not-supported
		desktopHandler,
		mobileHandler,
		logGroup = 'ext.wikia.adEngine.template.bfaa',
		nav,
		page,
		unblockedSlots = [
			'BOTTOM_LEADERBOARD',
			'INCONTENT_BOXAD_1',

			'MOBILE_BOTTOM_LEADERBOARD',
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER'
		],
		wrapper;

	desktopHandler = {
		updateNavBar: function (iframe) {
			var height = iframe.contentWindow.document.body.offsetHeight,
				position = win.scrollY || win.pageYOffset;

			if (doc.body.offsetWidth <= breakPointWidthNotSupported || position <= height) {
				wrapper.classList.add('bfaa-pinned-nav');
				nav.classList.add('bfaa-pinned');
			} else {
				wrapper.classList.remove('bfaa-pinned-nav');
				nav.classList.remove('bfaa-pinned');
			}
		},

		show: function (iframe) {
			var spotlightFooter = doc.getElementById('SPOTLIGHT_FOOTER');
			nav.style.top = '';
			page.classList.add('bfaa-template');

			this.updateNavBar(iframe);
			doc.addEventListener('scroll', adHelper.throttle(function () {
				this.updateNavBar(iframe);
			}.bind(this), 100));

			if (win.WikiaBar) {
				win.WikiaBar.hideContainer();
			}

			if (spotlightFooter) {
				spotlightFooter.parentNode.style.display = 'none';
			}
		}
	};

	mobileHandler =  {
		show: function (iframe, aspectRatio) {
			var adsModule = win.Mercury.Modules.Ads.getInstance(),
				height,
				viewPortWidth,
				adjustPadding = function () {
					viewPortWidth = Math.max(doc.documentElement.clientWidth, win.innerWidth || 0);
					height = aspectRatio ?
						viewPortWidth / aspectRatio :
						iframe.contentWindow.document.body.offsetHeight;
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
		}
	};

	function show(params) {
		var event = doc.createEvent('CustomEvent'),
			handler,
			skin = adContext.getContext().targeting.skin;

		switch (skin) {
			case 'oasis':
				nav = doc.getElementById('globalNavigation');
				page = doc.getElementsByClassName('WikiaSiteWrapper')[0];
				wrapper = doc.getElementById('WikiaTopAds');
				handler = desktopHandler;
				break;
			case 'mercury':
				page = doc.getElementsByClassName('application-wrapper')[0];
				wrapper = doc.getElementsByClassName('mobile-top-leaderboard')[0];
				handler = mobileHandler;
				break;
			default:
				return log(['show', 'not supported skin'], 'info', logGroup);
		}

		wrapper.style.opacity = '0';
		slotTweaker.makeResponsive(params.slotName, params.aspectRatio);
		slotTweaker.onReady(params.slotName, function (iframe) {
			handler.show(iframe, params.aspectRatio);
			wrapper.style.opacity = '';
		});

		log('show', 'info', logGroup);

		uapContext.setUapId(params.uap);
		unblockedSlots.forEach(btfBlocker.unblock);

		event.initCustomEvent('wikia.uap', true, true, {});
		win.dispatchEvent(event);
	}

	return {
		show: show
	};
});
