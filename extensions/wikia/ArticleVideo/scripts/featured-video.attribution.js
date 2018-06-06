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
				trackingMethod: 'analytics',
			});

		return function (playerInstance) {
			$('.featured-video__attribution-username, .featured-video__attribution-icon').click(function() {
				track({
					action: 'aaa',//playerInstance.getPlaylistItem(0).username,
					label: 'bbb',//playerInstance.getPlaylistItem(0).userUrl
				});
			});

			playerInstance.on('relatedVideoPlay', function (data) {
				var attributionContainer = $('.featured-video__attribution-container'),
					item = data.item;

				if (item.username && item.userUrl && item.userAvatarUrl) {
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

					$('.featured-video__attribution-username, .featured-video__attribution-icon').click(function() {
						console.log('aaa');
						track({
							action: item.username,
							label: item.userUrl
						});
					});
				} else {
					attributionContainer.remove();
				}

			});
		}
	});
