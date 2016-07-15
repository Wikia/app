require([
	'wikia.pageviewsInSession',
	'CommunityPageBenefitsModal',
	'wikia.tracker'
], function (pageviews, modal, tracker) {
	'use strict';

	function init() {
		if (pageviews.getPageviewsCount() >= 4) {
			modal.open();
			trackModalImpression();
		}
	}

	function trackModalImpression() {
		tracker.track({
			action: tracker.ACTIONS.OPEN,
			category: 'community-page-benefits-modal',
			label: 'benefits-modal-fired-after-pageviews',
			trackingMethod: 'analytics'
		});
	}

	init();
});
