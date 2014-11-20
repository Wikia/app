define('wikia.recommendations.tracking', ['wikia.document', 'wikia.tracker', 'wikia.dom'], function(d, tracker, dom){
	'use strict';

	function trackGARecommendation(e) {
		var node = e.target,
			slot, label;

		if (node.tagName === 'A' || (node = dom.closestByTagName(node, 'A')) !== false) {
			slot = dom.closestByClassName(node, 'slot');

			if (slot !== false) {
				label = slot.dataset.type;

				tracker.track({
					action: tracker.ACTIONS.CLICK,
					category: 'Recommendation',
					label: label,
					trackingMethod: 'ga'
				});
			}
		}
	}

	function init(recommendations) {
		recommendations.addEventListener('click', trackGARecommendation, false);
	}

	return {
		init: init
	};
});
