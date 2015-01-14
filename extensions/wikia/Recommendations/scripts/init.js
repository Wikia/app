/*global require*/
require(
	['wikia.document', 'wikia.recommendations', 'wikia.nodeFinder', 'sloth'],
	function (d, recommendations, nodeFinder, sloth) {
		'use strict';

		function addRecommendationsModule() {
			recommendations.init(d.querySelector('#WikiaPage main'));
		}

		sloth({
			on: nodeFinder.getLastVisibleChild(d.getElementById('mw-content-text')),
			threshold: 200,
			callback: addRecommendationsModule
		});
	}
);
