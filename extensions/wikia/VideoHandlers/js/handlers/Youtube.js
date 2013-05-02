/**
 * Use Youtube's iframe API to play and track videos
 * https://developers.google.com/youtube/iframe_api_reference
 */

define('wikia.youtube', ['wikia.window', 'wikia.loader'], function Youtube(window, loader) {
	'use strict';

	return function(params, vb) {
		var player,
			started = false;

		function onPlayerReady() {
			vb.track('player-load');
		}

		function onPlayerStateChange(e) {
			if ( !started && e.data == 1 ) {
				vb.track('content-begin');
				started = true;
			}
		}

		params.events = {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}

		// Make sure iframe_api is fully loaded before binding onYouTubeIframeAPIReady event
		loader({
			type: loader.JS,
			resources: 'https://www.youtube.com/iframe_api'
		}).done(function() {
			window.onYouTubeIframeAPIReady = function() {
				player = new YT.Player('youtubeVideoPlayer', params);
			}
		});
	}
});