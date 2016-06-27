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
			var spotlightFooter = document.getElementById('SPOTLIGHT_FOOTER');
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
				slotTweaker.hideByElement(spotlightFooter.parentNode, true);
			}
		}
	};

	mobileHandler =  {
		show: function (iframe) {
			var adsModule = win.Mercury.Modules.Ads.getInstance(),
				height,
				onResize = adHelper.throttle(function () {
					height = iframe.contentWindow.document.body.offsetHeight;
					page.style.paddingTop = height + 'px';
					adsModule.setSiteHeadOffset(height);
				}, 100);

			page.classList.add('bfaa-template');
			height = iframe.contentWindow.document.body.offsetHeight;
			page.style.paddingTop = height + 'px';
			adsModule.setSiteHeadOffset(height);

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
		var handler,
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
		slotTweaker.makeResponsive(params.slotName);
		slotTweaker.onReady(params.slotName, function (iframe) {
			handler.show(iframe);
			wrapper.style.opacity = '';
		});

		log('show', 'info', logGroup);

		uapContext.setUapId(params.uap);
		btfBlocker.unblock('BOTTOM_LEADERBOARD');
	}

	return {
		show: show
	};
});
