require(['jquery', 'wikia.window', 'wikia.tracker'], function($, win, tracker) {
	'use strict';

	var ARTICLE_LENGTH_THRESHOLD = 800,
		SCALE = 100,
		WIDTH_SAMPLING_RATIO = 1,
		$article,
		labelPrefix,
		trackFunction,
		windowWidth;

	if (Math.random() * 100 < WIDTH_SAMPLING_RATIO && win.wgIsArticle)  {
		$article = $('.WikiaArticle');
		trackFunction = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'articleContentLengthTest',
			trackingMethod: 'analytics'
		});
		windowWidth = Math.floor($(win).width() / SCALE);

		if ($article.height() > ARTICLE_LENGTH_THRESHOLD) {
			labelPrefix = 'long-';
		} else {
			labelPrefix = 'short-';
		}
		trackFunction({
			label: labelPrefix + windowWidth
		})
	}
});
