require(['wikia.document', 'wikia.recommendations', 'sloth'], function(d, recommendations, sloth){
	'use strict';

	var articleContainer = d.getElementById('WikiaArticle');

	function callback(data) {
		var moduleContainer = d.createElement('div');

		moduleContainer.id = 'recommendations';
		moduleContainer.classList.add('recommendations');

		moduleContainer.innerHTML = data;

		articleContainer.appendChild(moduleContainer);
	}

	function addRecommendationsModule() {
		recommendations.load(callback);
	}

	sloth({
		on: articleContainer, // TODO get last visible child
		threshold: 200,
		callback: addRecommendationsModule
	});
});
