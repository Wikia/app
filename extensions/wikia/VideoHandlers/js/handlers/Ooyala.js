(function( context ) {
	'use strict';

	function ooyala() {

		/*if(!(this instanceof ooyala)) {
			return new ooyala();
		}

		if(typeof context.Wikia.Ooyala == 'object') {
			return;
		}

		var that = this;*/


		function Ooyala(params) {
			window.OO.Player.create(params.playerId, params.videoId, { width: params.width + 'px', height: params.height + 'px', autoplay: params.autoPlay/*, onCreate: onCreate*/ });
		}


		/*var resetTracking = function() {
			this.duration = null;
			this.timeAtHalf = null;
			this.halfAchieved = false;
			this.timeAtFull = null;
			this.fullAchieved = false;
		};

		resetTracking.call(this);

		var onCreate = function(player) {
			var messageBus = player.mb;

			messageBus.subscribe(OO.EVENTS.PLAYING, 'tracking', function() {
				console.log('playing');

				// Duration is not available until the video starts playing
				if(!that.duration) {
					that.duration = player.getDuration();
					that.timeAtHalf = Math.floor(that.duration / 2);
					// Subtract 1 from duration so we're sure to catch the event
					that.timeAtFull = Math.floor(that.duration) - 1;
				}
			});

			messageBus.subscribe(OO.EVENTS.PLAYER_CREATED, 'tracking', function(eventName, payload) {
				console.log('player created');
			});

			messageBus.subscribe(OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'tracking', function(eventName, payload) {
				if(!that.duration) {
					return;
				}
				var pl = Math.floor(payload);

				if(!that.halfAchieved && pl > that.timeAtHalf) {
					console.log('half!');
					that.halfAchieved = true;
					return;
				}

				if(!that.fullAchieved && pl > that.timeAtFull) {
					console.log('full!');
					that.fullAchieved = true;
					return;
				}
			});

			// Log all events and values
			messageBus.subscribe('*', 'tracking', function(eventName, payload) {
				console.log(eventName);
				console.log(payload);
			});

		}*/

		return Ooyala;
	}


	if (context.define && context.define.amd) {
		context.define('wikia.ooyala', [], ooyala);
	}

})(this);