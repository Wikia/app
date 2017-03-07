require(['wikia.window', 'wikia.tracker', 'ooyala-player'], function (window, tracker, OoyalaPlayer) {

	$(function () {
		var $video = $('#article-related-video'),
			ooyalaVideoElementId = 'ooyala-article-related-video',
			ooyalaVideoController,
			track = tracker.buildTrackingFunction({
				category: 'article-video',
				trackingMethod: 'analytics'
			});

		function initVideo(ooyalaContainerId, videoId, onCreate) {
			var playerParams = window.wgOoyalaParams;

			ooyalaVideoController = OoyalaPlayer.initHTML5Player(ooyalaContainerId, playerParams, videoId, onCreate);
		}

		function placeRelatedVideo(player) {
			var $articleContent = $('#mw-content-text'),
				$articleHeaders = $articleContent.children('h2'),
				placementCallbacks,
				$followingSibling,
				rating = 0;

			// these callbacks return candidate for following DOM element for related video
			placementCallbacks = [
				function () {
					return $articleHeaders.first().nextUntil('h2', 'p').last();
				},
				function () {
					// return $articleHeaders.eq(1).nextUntil('h2', 'p').first();
				},
				function () {
					// return $articleHeaders.first().nextUntil('h2', 'p').eq(-3);
				}
			];

			placementCallbacks.forEach(function(callback) {
				var $followingSiblingCandidate, candidateRating;
				
				$followingSiblingCandidate = callback();
				candidateRating = rateVideoPlacement($followingSiblingCandidate, $followingSibling);

				if (candidateRating > rating) {
					$followingSibling = $followingSiblingCandidate;
					rating = candidateRating;
				}
			});
			
			if ($followingSibling && $followingSibling.length) {
				// $video = $video.detach().insertBefore($followingSibling);
				$video.detach().insertBefore($followingSibling);

				player.mb.subscribe(window.OO.EVENTS.PLAYBACK_READY, 'ui-title-update', function () {
					var videoTitle = player.getTitle(),
						videoTime = ooyalaVideoController.getFormattedDuration(player.getDuration());

					$video.find('.video-title').text(videoTitle);
					$video.find('.video-time').text(videoTime);

					$video.show();
				});
			}
		}

		function rateVideoPlacement($candidate, $best) {
			var $fakeDiv, bestWidth, candidateWidth;
			
			if (!$candidate || !$candidate.length) {
				return -1;
			}

			$fakeDiv = $('<div>').css({'overflow':'hidden'});
			candidateWidth = $fakeDiv.insertBefore($candidate).width();
			$fakeDiv.remove();
			
			if (candidateWidth < 500) {
				return -1;
			}

			if (!$best || !$best.length) {
				return 1;
			}

			bestWidth = $fakeDiv.detach().insertBefore($best).width();
			$fakeDiv.remove();

			if (candidateWidth > bestWidth) {
				rating += 2;
			}

			return rating;
		}
		
		initVideo(ooyalaVideoElementId, window.wgRelatedVideoId, function (player) {
			placeRelatedVideo(player);
			
			player.mb.subscribe(OO.EVENTS.PLAY, 'related-video', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'related-video-play'
				});
			});

			player.mb.subscribe(OO.EVENTS.PLAYED, 'related-video', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'related-video-played'
				});
			});

			player.mb.subscribe(OO.EVENTS.PAUSED, 'related-video', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'related-video-paused'
				});
			});

			track({
				action: tracker.ACTIONS.IMPRESSION,
				label: 'related-video'
			});
		});
	});
});
