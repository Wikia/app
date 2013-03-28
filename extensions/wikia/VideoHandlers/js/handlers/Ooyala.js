define('wikia.ooyala', ['wikia.window'], function(window) {
	'use strict';

	var videoTitle,
		onCreate = function(player) {
			var messageBus = player.mb;

			// Player has loaded
			messageBus.subscribe(OO.EVENTS.PLAYER_CREATED, 'tracking', function(eventName, payload) {
				track('player-load');
			});

			// Actual content starts playing (past any ads or age-gates)
			messageBus.subscribe(OO.EVENTS.PLAYING, 'tracking', function() {
				track('content-begin');

			});

			// Ad starts
			messageBus.subscribe(OO.EVENTS.WILL_PLAY_ADS, 'tracking', function(eventName, payload) {
				track('ad-start');
			});

			// Ad has been fully watched
			messageBus.subscribe(OO.EVENTS.ADS_PLAYED, 'tracking', function(eventName, payload) {
				track('ad-finish');
			});

			// Log all events and values (for debugging)
			/*messageBus.subscribe('*', 'tracking', function(eventName, payload) {
				console.log(eventName);
				console.log(payload);
			});*/

		},
		track = function(action) {
			Wikia.Tracker.track({
				action: action,
				category: 'video-player-stats',
				label: 'ooyala',
				trackingMethod: 'internal',
				value: 0
			}, {
				title: videoTitle
			});
		};


	return function(params) {
		var time = new Date().getTime(),
			container = document.getElementById(params.playerId),
			newId = params.playerId + time;

		videoTitle = params.title;

		container.id = newId;

		window.OO.Player.create(newId, params.videoId, { width: params.width + 'px', height: params.height + 'px', autoplay: params.autoPlay, onCreate: onCreate });
	}
});