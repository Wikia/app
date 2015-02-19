require(['jquery', 'wikia.window', 'wikia.tracker'], function($, window, tracker) {	
	'use strict';

	var WIDTH_SAMPLING_RATIO = 1,
		ARTICLE_LENGTH_THRESHOLD = 800,
		SCALE = 100;
		
	if (Math.random() * 100 < WIDTH_SAMPLING_RATIO && window.wgIsArticle)  {
		var labelPrefix,
			trackFunction,
			$article = $('.WikiaArticle'),
			windowWidth = Math.floor($(window).width() / SCALE);
			
		trackFunction = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'articleContentLengthTest',
			trackingMethod: 'ga'
		});

		if ($article.height() > ARTICLE_LENGTH_THRESHOLD) {
			labelPrefix = 'long-';
		} else {
			labelPrefix = 'short-';
		};
		tracker.track({
			label: labelPrefix + windowWidth
		})
	}	
});
