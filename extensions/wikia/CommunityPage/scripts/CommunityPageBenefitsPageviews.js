require([
	'wikia.pageviewsInSession',
	'CommunityPageBenefitsModal'
], function (pageviews, modal) {
	'use strict';

	function init() {
		if (pageviews.getPageviewsCount() >= 4) {
			modal.open();
		}
	}

	init();
});
