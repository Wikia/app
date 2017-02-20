/*
 * If we want to continue using ooyala player for "premium videos"
 * we should merge this with ooyala handler (Ooyala.js from VideoHandlers dir)
 */
define('ooyalaVideo', ['jquery', 'wikia.window'], function ($, window) {

	function OoyalaVideo(elementId, ooyalaVideoId, onCreate) {
		var self = this,
			ooyalaPlayerOptions = {
				autoplay: false,
				width: '100%',
				height: '100%',
				onCreate: function (player) {
					self.player = player;
					self.$controls = $('#' + elementId + ' .oo_controls');
					onCreate(self);
				}
			};

		this.videoProvider = 'ooyala';

		window.OO.ready(function () {
			window.OO.Player.create(elementId, ooyalaVideoId, ooyalaPlayerOptions);
		});
	}

	OoyalaVideo.create = function (elementId, ooyalaVideoId, onCreate) {
		new OoyalaVideo(elementId, ooyalaVideoId, onCreate);
	};

	OoyalaVideo.prototype.sizeChanged = function () {
		if (this.player) {
			this.player.mb.publish(OO.EVENTS.SIZE_CHANGED);
		}
	};

	OoyalaVideo.prototype.hideControls = function () {
		if (this.$controls) {
			this.$controls.hide();
		}
	};

	OoyalaVideo.prototype.showControls = function () {
		if (this.$controls) {
			this.$controls.show();
		}
	};

	OoyalaVideo.prototype.inFullscreen = function () {
		if (this.player) {
			return this.player.getFullscreen();
		}
		return false;
	};

	OoyalaVideo.prototype.play = function () {
		if (this.player) {
			this.player.play();
		}
	};

	OoyalaVideo.prototype.pause = function () {
		if (this.player) {
			this.player.pause();
		}
	};

	OoyalaVideo.prototype.isPlaying = function () {
		if (this.player) {
			return this.player.getState() === OO.STATE.PLAYING;
		}
		return false;
	};

	OoyalaVideo.prototype.isReadyToPlay = function () {
		if (this.player) {
			return this.player.getState() === OO.STATE.PAUSED || this.player.getState() === OO.STATE.READY;
		}
		return false;
	};

	OoyalaVideo.prototype.onPlay = function (callback) {
		this.player.mb.subscribe(OO.EVENTS.PLAY, 'featured-video', callback);
	};

	OoyalaVideo.prototype.onPlayed = function (callback) {
		this.player.mb.subscribe(OO.EVENTS.PLAYED, 'featured-video', callback);
	};

	OoyalaVideo.prototype.onPause = function (callback) {
		this.player.mb.subscribe(OO.EVENTS.PAUSED, 'featured-video', callback);
	};

	return OoyalaVideo;

});
