require(['wikia.window', 'wikia.onScroll', 'wikia.tracker', 'ooyala-player'], function (window, onScroll, tracker, OoyalaPlayer) {

	$(function () {
		var $video = $('#article-related-video'),
			ooyalaVideoElementId = 'ooyala-article-related-video',
			track = tracker.buildTrackingFunction({
				category: 'article-video',
				trackingMethod: 'analytics'
			});

		function initVideo(ooyalaContainerId, videoId, onCreate) {
			var playerParams = window.wgArticleRelatedVideoData.playerParams;

			OoyalaPlayer.initHTMl5Players(ooyalaContainerId, playerParams, videoId, onCreate);
		}

		function arrangeRelatedVideo(player) {
			var $articleContent = $('#mw-content-text');
			
			$video = $video.detach();
			$articleContent.children('h2').eq(1).prev('p').before( $video );

			player.mb.subscribe(window.OO.EVENTS.PLAYBACK_READY, 'ui-title-update', function () {
				var videoTitle = $video.find('.oo-state-screen-title').text();

				$video.find('.related-video-title').text(videoTitle);
				$video.show();
			});
		}
		
		initVideo(ooyalaVideoElementId, window.wgArticleRelatedVideoData.videoId, function (player) {
			arrangeRelatedVideo(player);
			
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
