require(['wikia.document', 'venus.moduleInsertion', 'wikia.recommendations'], function(d, moduleInsertion, recommendations){
	'use strict';

	var articleContainer = d.getElementById('WikiaArticle'),
		contentContainer = d.getElementById('mw-content-text');

	function addVideoRecommendations() {
		var boundaryOffsetTop = 1500,
			headerSelector = 'h2',
			videoRecommendations, header;

		videoRecommendations = moduleInsertion.createModuleContainer('videoRecommendations', 'video-recommendations');
		header = moduleInsertion.findElementByOffsetTop(contentContainer, headerSelector, boundaryOffsetTop);

		if (header !== null) {
			moduleInsertion.insertModuleBeforeElement(contentContainer, videoRecommendations, header);
		} else {
			moduleInsertion.insertModuleAsLastChild(contentContainer, videoRecommendations);
		}
	}

	function callback(data) {
		var moduleContainer = moduleInsertion.createModuleContainer('recommendations', 'recommendations');

		moduleContainer.innerHTML = data;

		moduleInsertion.insertModuleAsLastChild(articleContainer, moduleContainer);
	}

	function addRecommendationsModule() {
		recommendations.loadTemplate(callback);
	}

	addVideoRecommendations();
	addRecommendationsModule();
});
