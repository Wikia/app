define('wikia.recommendations.tracking', ['wikia.tracker', 'wikia.document'], function(tracker, d){
	'use strict';

	var recommendationSlots = d.getElementById('recommendations').getElementsByClassName('slot');

	function trackGARecommendation(e) {
		var label = e.target.dataset.type;

		tracker.track({
			action: tracker.ACTIONS.CLICK,
			category: 'Recommendation',
			label: label,
			trackingMethod: 'ga'
		});
	}

	recommendationSlots.addEventListener('click', trackGARecommendation);
});
