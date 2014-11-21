require(['wikia.document', 'wikia.tracker'], function(d, tracker){
	'use strict';

	var recentWikiActivity = d.getElementById('recentWikiActivity');

	function trackRecentWikiActivity(e) {
		var label,
			element = e.target;

		if (e.which !== 1) {
			return;
		}

		if (element.tagName === 'A') {
			if (element.classList.contains('recent-wiki-activity-link')) {
				label = 'activity-title';
			} else if (element.classList.contains('more')) {
				label = 'activity-more';
			} else {
				label = 'activity-username';
			}
		}

		if (label) {
			tracker.track({
				action: tracker.ACTIONS.CLICK,
				trackingMethod: 'ga',
				browserEvent: e,
				category: 'recent-wiki-activity',
				label: label
			});
		}
	}

	recentWikiActivity.addEventListener('mousedown', trackRecentWikiActivity);
});
