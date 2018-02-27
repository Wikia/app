define('wikia.articleVideo.featuredVideo.attribution', ['wikia.mustache', 'wikia.articleVideo.featuredVideo.templates'], function (mustache, templates) {
	'use strict';

	return function (playerInstance) {
		playerInstance.on('relatedVideoPlay', function (data) {
			var attributionContainer = $('.featured-video__attribution-container'),
				item = data.item;

			if (item.username && item.userUrl && item.userAvatarUrl) {
				var params = {
						username: item.username,
						userUrl: item.userUrl,
						userAvatarUrl: item.userAvatarUrl
					},
					attributionHTML = mustache.render(templates['ArticleVideo_attribution'], params);

				if (attributionContainer.length) {
					attributionContainer.replaceWith(attributionHTML);
				} else {
					$('featured-video').after(attributionHTML);
				}
			} else {
				attributionContainer.remove();
			}
		});
	}
});