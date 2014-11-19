require(['wikia.document', 'wikia.recommendations', 'wikia.recommendations.tracking'], function(d, recommendations, tracking){
	'use strict';

	// TODO add sloth and move insertion logic to lazy loaded js

	function callback(data) {
		var articleContainer = d.getElementById('WikiaArticle'),
			moduleContainer = d.createElement('div');

		moduleContainer.id = 'recommendations';
		moduleContainer.classList.add('recommendations');

		moduleContainer.innerHTML = data;

		articleContainer.appendChild(moduleContainer);

		tracking.init(moduleContainer);
	}

	function addRecommendationsModule() {
		recommendations.loadTemplate(callback);
	}

	addRecommendationsModule();
});
