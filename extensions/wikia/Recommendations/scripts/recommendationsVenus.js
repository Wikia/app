
require(['wikia.document', 'wikia.recommendations', 'sloth'], function(d, recommendations, sloth){
	'use strict';

	var articleContainer = d.getElementById('WikiaArticle');

	function addRecommendationsModule() {
		recommendations.init(articleContainer);
	}

	sloth({
		on: articleContainer, // TODO get last visible child
		threshold: 200,
		callback: addRecommendationsModule
	});
});
