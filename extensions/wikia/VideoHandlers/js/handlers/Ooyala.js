(function( context ) {
	'use strict';

	function ooyala() {

		var p = window.ooyalaParams;

		var loadOoyala = function(){
			$.getScript(p.jsFile).done(function() {
				window.OO.Player.create(p.playerId, p.videoId, { width: p.width + 'px', height: p.height + 'px', autoplay: p.autoPlay, onCreate: onCreate });
			});
		};
		
		var onCreate = function(player) {
			var messageBus = player.mb,
				duration,
				half,
				halfCalled = false,
				full,
				fullCalled = false;
			
// TODO: test with age gate
// TODO: reset when embed code changes (i.e. the next video is played)
// TODO: add loading image to original div
			
			messageBus.subscribe(OO.EVENTS.PLAYING, 'tracking', function() {
				console.log('playing');
				
				// Duration is not available until the video starts playing
				if(!duration) {
					duration = player.getDuration();
					half = Math.floor(duration / 2);
					full = Math.floor(duration) - 2;
				}
			});

			messageBus.subscribe(OO.EVENTS.PLAYER_CREATED, 'tracking', function(eventName, payload) {
				console.log('player created');
			});

			messageBus.subscribe(OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'tracking', function(eventName, payload) {
				if(!duration) {
					return;
				}

				var pl = Math.floor(payload);
				
				if(!halfCalled && pl > half) {
					console.log('half!');
					halfCalled = true;
					return;
				}
				
				if(!fullCalled && pl > full) {
					console.log('full!');				
					fullCalled = true;
					return;
				}
			});
			
			// Log all events and values
			messageBus.subscribe('*', 'tracking', function(eventName, payload) {
				console.log(eventName);
				console.log(payload);
			});
			
		}

		wgAfterContentAndJS.push(loadOoyala);
	}

	// Exports
	context.Wikia = context.Wikia || {};
	context.Wikia.Ooyala = ooyala( context );

	if (context.define && context.define.amd) {
		context.define('wikia.ooyala', ['wikia.window'], ooyala);
	}

})(this);