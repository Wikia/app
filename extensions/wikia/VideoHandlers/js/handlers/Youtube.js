/**
 * Use Youtube's iframe API to play and track videos
 * https://developers.google.com/youtube/iframe_api_reference
 */

define('wikia.youtube', ['wikia.window', 'wikia.loader'], function Youtube(window, loader) {
	'use strict';

	return function(params, vb) {
		var player,
			started = false,
			time = new Date().getTime(),
			oId = "youtubeVideoPlayer",
			container = document.getElementById(oId),
			newId = oId + "-" + time;

		container.id = newId;

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

		if ( window.YT ) {
			player = new YT.Player(newId, params);
		} else {
			// Make sure iframe_api is fully loaded before binding onYouTubeIframeAPIReady event
			loader({
				type: loader.JS,
				resources: 'https://www.youtube.com/iframe_api'
			}).done(function() {
				window.onYouTubeIframeAPIReady = function() {
					player = new YT.Player(newId, params);
				}
			});
		}
	}
});