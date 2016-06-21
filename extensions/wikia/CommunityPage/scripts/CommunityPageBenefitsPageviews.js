require([
	'wikia.pageviewsInSession',
	'CommunityPageBenefitsModal',
	'wikia.tracker',
	'wikia.cookies'
], function (pageviews, modal, tracker, cookies) {
	'use strict';

	var wikiaDomain = mw.config.get('wgDevelEnvironment') ? '.wikia-dev.com' : '.wikia.com',
		// This cookie is check in CommunityPageSpecialHooks::onBeforePageDisplay to avoid unnecessary script loading
		modalShownCookieName = 'cpBenefitsModalShown',
		modalShownExpirationTime = 2592000; // 30 days


	function init() {
		if (pageviews.getPageviewsCount() === 4) {
			modal.open();
			setModalShownCookie();
			trackModalImpression();
		}
	}

	function setModalShownCookie() {
		cookies.set(modalShownCookieName, 1, { domain: wikiaDomain, expires: modalShownExpirationTime });
	}

	function trackModalImpression() {
		tracker.track({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'community-page',
			label: 'community-page-benefits-modal',
			trackingMethod: 'analytics'
		});
	}

	(init)();
});
