require([
	'wikia.pageviewsInSession',
	'CommunityPageBenefitsModal',
	'wikia.tracker',
	'wikia.cookies'
], function (pageviews, modal, tracker, cookies) {
	'use strict';

	function init() {
		if (pageviews.getPageviewsCount() === 4) {
			modal.open();
			setModalShownCookie();
			trackModalImpression();
		}
	}

	// This cookie is checked in CommunityPageSpecialHooks::onBeforePageDisplay to avoid unnecessary script loading
	function setModalShownCookie() {
		cookies.set('cpBenefitsModalShown', 1, {
			domain: mw.config.get('wgCookieDomain'),
			expires: 2592000, // 30 days
			path: mw.config.get('wgCookiePath')
		});
	}

	function trackModalImpression() {
		tracker.track({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'community-page-benefits-modal',
			label: 'benefits-modal-shown-after-pageviews',
			trackingMethod: 'analytics'
		});
	}

	init();
});
