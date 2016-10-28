require([
	'wikia.pageviewsInSession',
	'CommunityPageBenefitsModal',
	'wikia.cookies'
], function (pageviews, modal, cookies) {
	'use strict';

	function init() {
		if (!cookies.get('cpBenefitsModalShown') && pageviews.getPageviewsCount() >= 4) {
			modal.open();
		}
	}

	init();
});
