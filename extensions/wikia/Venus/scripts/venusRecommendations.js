require(['wikia.document', 'wikia.recommendations'], function(d, recommendations){
	'use strict';

	// TODO add sloth and move insertion logic to lazy loaded js

	function callback(data) {
		var articleContainer = d.getElementById('WikiaArticle'),
			moduleContainer = d.createElement('div');

		moduleContainer.id = 'recommendations';
		moduleContainer.classList.add('recommendations');

		moduleContainer.innerHTML = data;

		articleContainer.appendChild(moduleContainer);
	}

	function addRecommendationsModule() {
		recommendations.load(callback);
	}

	addRecommendationsModule();
});
