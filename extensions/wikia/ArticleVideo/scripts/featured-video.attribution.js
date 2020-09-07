define('wikia.articleVideo.featuredVideo.attribution', [
		'wikia.mustache',
		'wikia.articleVideo.featuredVideo.templates',
		'JSMessages',
		'wikia.tracker'
	],
	function (mustache, templates, msg, tracker) {
		'use strict';

		var track = tracker.buildTrackingFunction({
				category: 'featured-video',
				action: tracker.ACTIONS.CLICK,
				trackingMethod: 'analytics'
			});

		return function (playerInstance) {
			// tracking for initial video attribution
			$('.featured-video__attribution-username, .featured-video__attribution-icon').click(function() {
				track({
					label: playerInstance.getPlaylistItem(0).username
				});
			});

			playerInstance.on('relatedVideoPlay', function (data) {
				var attributionContainer = $('.featured-video__attribution-container'),
					item = data.item;

				if (item.username && item.userUrl) {
					var params = {
							username: item.username,
							userUrl: item.userUrl,
							userAvatarUrl: item.userAvatarUrl,
							fromMsg: msg('articlevideo-attribution-from')
						},
						attributionHTML = mustache.render(templates['ArticleVideo_attribution'], params);

					if (attributionContainer.length) {
						attributionContainer.replaceWith(attributionHTML);
					} else {
						$('.featured-video').after(attributionHTML);
					}

					// tracking for attribution for videos from playlist
					$('.featured-video__attribution-username, .featured-video__attribution-icon').click(function() {
						track({
							label: item.username
						});
					});
				} else {
					attributionContainer.remove();
				}

			});
		}
	});
