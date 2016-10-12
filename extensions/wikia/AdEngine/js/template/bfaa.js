/*global define, require*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (
	adContext,
	adHelper,
	uapContext,
	DOMElementTweaker,
	btfBlocker,
	slotTweaker,
	recoveryHelper,
	browser,
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

			log(['updateNavBar', height, position], 'info', logGroup);

			if (doc.body.offsetWidth <= breakPointWidthNotSupported || position <= height) {
				nav.classList.add('bfaa-pinned');
			} else {
				nav.classList.remove('bfaa-pinned');
			}
		},

		show: function (iframe, params) {
			var spotlightFooter = doc.getElementById('SPOTLIGHT_FOOTER');
			nav.style.top = '';
			page.classList.add('bfaa-template');

			log('desktopHandler::show', 'info', logGroup);

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

			if (recoveryHelper.isRecoveryEnabled() && recoveryHelper.isBlocking()) {
				slotTweaker.removeDefaultHeight(params.slotName);
				recoverSlot(iframe, params);
			}
		}
	};

	mobileHandler =  {
		show: function (iframe, params) {
			var aspectRatio = params.aspectRatio,
				adsModule = win.Mercury.Modules.Ads.getInstance(),
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

	function isRecoveryNotSupportedBrowser() {
		return browser.isIE() || browser.isEdge();
	}

	function mirrorDOMStructure(parentNode) {
		var originalIframe = document.createElement('iframe');
		var div = document.createElement('div');

		div.appendChild(originalIframe);
		parentNode.appendChild(div);
		originalIframe.style.display = 'none';
		div.style.display = 'none';
		return originalIframe;
	}

	function recoverSlot(iframe, params) {
		var adContainer = iframe.parentNode.parentNode.parentNode.parentNode,
			originalIframe = mirrorDOMStructure(document.querySelector('#' + params.slotName + ' > div > div'));

		if (isRecoveryNotSupportedBrowser()) {
			DOMElementTweaker.hide(adContainer, true);
			return;
		}

		slotTweaker.tweakRecoveredSlot(originalIframe, iframe);
	}

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

		log(['show', page, wrapper, params], 'info', logGroup);

		wrapper.style.opacity = '0';
		slotTweaker.makeResponsive(params.slotName, params.aspectRatio);
		slotTweaker.onReady(params.slotName, function (iframe) {
			handler.show(iframe, params);
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
