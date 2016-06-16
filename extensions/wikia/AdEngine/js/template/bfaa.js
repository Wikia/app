/*global define*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (adContext, adHelper, doc, log, win, mercuryListener) {
	'use strict';

	var bfabSlotName = 'BOTTOM_LEADERBOARD',
		breakPointWidthNotSupported = 767, // SCSS property: $breakpoint-width-not-supported
		desktopHandler,
		disableBtf = win.ads.runtime.disableBtf,
		mobileHandler,
		logGroup = 'ext.wikia.adEngine.template.bfaa',
		nav,
		page,
		threshold = 100,
		viewPortHeight = Math.max(doc.documentElement.clientHeight, win.innerHeight || 0),
		mainContent = doc.getElementById('WikiaMainContent'),
		wrapper;

	function getTopOffset(el) {
		var topPos = 0;
		for (; el !== null; el = el.offsetParent) {
			topPos += el.offsetTop;
		}

		return topPos;
	}

	function pushBfab() {
		var scrollPosition = win.scrollY || win.pageYOffset || doc.documentElement.scrollTop,
			pushBfabPosition = getTopOffset(mainContent) + mainContent.offsetHeight - viewPortHeight - threshold;

		if (pushBfabPosition < scrollPosition) {
			win.ads.runtime.disableBtf = false;
			win.adslots2.push(bfabSlotName);
			win.ads.runtime.disableBtf = disableBtf;
			doc.removeEventListener('scroll', pushBfab);
			log(['pushBfab', 'Pushed BFAB'], 'debug', logGroup);
		}
	}

	desktopHandler = {
		updateNavBar: function (height) {
			var position = win.pageYOffset;

			if (doc.body.offsetWidth <= breakPointWidthNotSupported || position <= height) {
				wrapper.classList.add('bfaa-pinned-nav');
				nav.classList.add('bfaa-pinned');
			} else {
				wrapper.classList.remove('bfaa-pinned-nav');
				nav.classList.remove('bfaa-pinned');
			}
		},

		show: function (height, backgroundColor) {
			var bfab = doc.getElementById(bfabSlotName);

			nav.style.top = '';
			page.classList.add('bfaa-template');
			wrapper.style.background = backgroundColor;

			this.updateNavBar(height);
			doc.addEventListener('scroll', adHelper.throttle(function () {
				this.updateNavBar(height);
			}.bind(this), 100));

			if (win.WikiaBar) {
				win.WikiaBar.hideContainer();
			}

			if (!bfab) {
				log(['show', 'No BFAB slot'], 'error', logGroup);
				return;
			}

			doc.addEventListener('scroll', pushBfab);
		}
	};

	mobileHandler =  {
		show: function (height, backgroundColor) {
			var adsModule = win.Mercury.Modules.Ads.getInstance();

			adsModule.setSiteHeadOffset(height);
			page.style.paddingTop = height + 'px';
			wrapper.style.background = backgroundColor;
			wrapper.classList.add('bfaa-template');

			if (mercuryListener) {
				mercuryListener.onPageChange(function () {
					wrapper.classList.remove('bfaa-template');
					wrapper.style.background = '';
					page.style.paddingTop = '';
					adsModule.setSiteHeadOffset(0);
				});
			}
		}
	};

	function show(params) {
		var backgroundColor = params.backgroundColor ? '#' + params.backgroundColor.replace('#', '') : '#000',
			handler,
			height = params.height || 0,
			skin = adContext.getContext().targeting.skin,
			bfabLineItemId = params.uap;

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

		handler.show(height, backgroundColor);
		log('show', 'info', logGroup);

		win.ads.runtime.uap = bfabLineItemId;
		log(['show', 'uap', bfabLineItemId], 'info', logGroup);
	}

	return {
		show: show
	};
});
