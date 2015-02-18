$(function () {
	'use strict';

	var track = Wikia.Tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.IMPRESSION,
		category: 'article-content-length-test',
		trackingMethod: 'ga'
	});
	var $ = jQuery,
		$article = $ ('.WikiaArticle'),
		windowWidth = $(window).width(),
		articleLength = $article.height(),
		lenghtLabel = 'short';

	console.log("szerokosc i wysokosc: ", windowWidth, articleLength)
	if (articleLength > 800) {
		lengthLabel = 'long';
	};
	
	track({
		label: lengthLabel
	})
});
