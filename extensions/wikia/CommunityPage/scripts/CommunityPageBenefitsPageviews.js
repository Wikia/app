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

	init();
});
