$(function () {
	'use strict';

	var $article = $ ('.WikiaArticle'),
		articleLength = $article.height(),
		label = '',
		lengthBorder = 800,
		sampling = 1,
		scale = 100,
		track,
		windowWidth = $(window).width(),
		widthCategory = Math.floor(windowWidth/scale);
		
	console.log("szerokosc i wysokosc: ", windowWidth, articleLength)

	if (articleLength > lengthBorder) {
		label = 'long-' + widthCategory;
	} else {
		label = 'short-' + widthCategory;
	};
	console.log("label:", label)

	if (Math.random() * 100 < sampling) {
		track = Wikia.Tracker.buildTrackingFunction({
			action: Wikia.Tracker.ACTIONS.IMPRESSION,
			category: 'article-content-length-test',
			trackingMethod: 'ga'
		});
		track({
			label: label
		})
	}
});
