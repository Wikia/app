require(['venus.moduleInsertion', 'wikia.document'], function(moduleInsertion, d){
	'use strict';

	var articleContainer = d.getElementById('mw-content-text'),
		boundaryOffsetTop = 1500,
		headerSelector = 'h2',
		recommendationModule,
		header;

	recommendationModule = moduleInsertion.createModuleContainer('videoRecommendations', 'video-recommendations');
	header = moduleInsertion.findElementByOffsetTop(articleContainer, headerSelector, boundaryOffsetTop);

	if (header !== null) {
		moduleInsertion.insertModuleBeforeElement(articleContainer, recommendationModule, header);
	} else {
		moduleInsertion.insertModuleAsLastChild(articleContainer, recommendationModule);
	}
});
