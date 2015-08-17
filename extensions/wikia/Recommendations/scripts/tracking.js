define(
	'wikia.recommendations.tracking',
	['wikia.document', 'wikia.tracker', 'wikia.dom'],
	function (d, tracker, dom) {
		'use strict';

		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			category: 'Recommendation',
			trackingMethod: 'analytics'
		});

		/**
		 * @desc Tracking handler for recommendations
		 * @param Event e
		 */
		function trackGARecommendation (e) {
			var node = e.target,
				slot, label;

			if (node.tagName === 'A' || (node = dom.closestByTagName(node, 'A')) !== false) {
				slot = dom.closestByClassName(node, 'slot');

				if (slot !== false) {
					label = slot.dataset.type;

					track({
						label: label
					});
				}
			}
		}

		/**
		 * Init tracking
		 * @param DOMNode recommendations recommendations contrainer
		 */
		function init (recommendations) {
			recommendations.addEventListener('click', trackGARecommendation, false);
		}

		return {
			init: init
		};
});
