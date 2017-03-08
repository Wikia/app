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
				$followingSibling;

			// These callbacks return candidate for following DOM element for related video.
			// The aim is to select the best placement from these three, where the determining factor is width of
			// the following element - we want it to be wide, to have enough place for the text surrounding the video.
			// We choose from 3 placements:
			//      - last paragraph under the first header h2
			//      - first paragraph under the second header h2
			//      - last third paragraph under the first header h2
			placementCallbacks = [
				function () {
					return $articleHeaders.first().nextUntil('h2', 'p, ul').last();
				},
				function () {
					return $articleHeaders.eq(1).nextUntil('h2', 'p, ul').first();
				},
				function () {
					return $articleHeaders.first().nextUntil('h2', 'p, ul').eq(-3);
				}
			];

			placementCallbacks.forEach(function(func) {
				var $followingSiblingCandidate = func();

				if (isPlacementBetter($followingSiblingCandidate, $followingSibling)) {
					$followingSibling = $followingSiblingCandidate;
				}
			});

			if ($followingSibling && $followingSibling.length) {
				$video.insertBefore($followingSibling);

				player.mb.subscribe(window.OO.EVENTS.PLAYBACK_READY, 'ui-title-update', function () {
					var videoTitle = player.getTitle(),
						videoTime = ooyalaVideoController.getFormattedDuration(player.getDuration());

					$video.find('.video-title').text(videoTitle);
					$video.find('.video-time').text(videoTime);

					$video.show();
					
					track({
						action: tracker.ACTIONS.IMPRESSION,
						label: 'related-video'
					});
				});
			}
		}

		function isPlacementBetter($candidate, $currentBest) {
			var $fakeDiv,
				bestWidth,
				candidateWidth;

			if (!$candidate || !$candidate.length) {
				return false;
			}

			$fakeDiv = $('<div>').css({'overflow':'hidden'});
			candidateWidth = $fakeDiv.insertBefore($candidate).width();
			$fakeDiv.remove();

			// minimum width of a container that will float around the video is 500px - below this value the width
			// for the text content will be < 200px which is too narrow
			if (candidateWidth < 500) {
				return false;
			}

			if (!$currentBest || !$currentBest.length) {
				return true;
			}

			bestWidth = $fakeDiv.insertBefore($currentBest).width();
			$fakeDiv.remove();

			if (candidateWidth > bestWidth) {
				return true;
			}

			return false;
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
		});
	});
});
