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

	var logGroup = 'ext.wikia.adEngine.template.bfaa',
		breakPointWidthNotSupported = 767, // SCSS property: $breakpoint-width-not-supported
		desktopHandler,
		mobileHandler,
		nav,
		page,
		wrapper;

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

		handler.show(height, backgroundColor);
		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
