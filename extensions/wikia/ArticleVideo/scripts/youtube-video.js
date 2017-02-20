define('youtubeVideo', ['jquery', 'wikia.window'], function ($, window) {

	function YouTubeVideo(elementId, videoId, onCreate) {
		var self = this;

		this.elementId = elementId;
		this.videoId = videoId;
		this.videoProvider = 'youtube';
		this.inFullscreenMode = false;

		if (window.YT && window.YT.Player) {
			this.createPlayer(onCreate);
		} else {
			window.onYouTubeIframeAPIReady = function () {
				self.createPlayer(onCreate);
			};
		}

		// workaround to check if youtube video is in fullscreen mode
		$(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e)
		{
			if (e.target === document.getElementById(self.elementId)) {
				self.inFullscreenMode = true;
			} else {
				self.inFullscreenMode = false;
			}
		});
	}

	YouTubeVideo.create = function (elementId, videoId, onCreate) {
		new YouTubeVideo(elementId, videoId, onCreate);
	};

	YouTubeVideo.prototype.createPlayer = function (onCreate) {
		var self = this;
		this.player = new YT.Player(this.elementId, {
			height: '100%',
			width: '100%',
			videoId: this.videoId,
			events: {
				'onReady': function () {
					onCreate(self);
				}
			}
		});
	};

	YouTubeVideo.prototype.inFullscreen = function () {
		return this.inFullscreenMode;
	};

	YouTubeVideo.prototype.play = function () {
		this.player.playVideo();
	};

	YouTubeVideo.prototype.pause = function () {
		this.player.pauseVideo();
	};


	YouTubeVideo.prototype.isPlaying = function () {
		return this.player.getPlayerState() === 1;
	};

	YouTubeVideo.prototype.isReadyToPlay = function () {
		return this.player.getPlayerState() === YT.PlayerState.ENDED || this.player.getPlayerState() === YT.PlayerState.PAUSED || this.player.getPlayerState() === -1;
	};

	YouTubeVideo.prototype.onPlay = function (callback) {
		this.player.addEventListener('onStateChange', function (e) {
			if(e.data === YT.PlayerState.PLAYING) {
				callback();
			}
		});
	};

	YouTubeVideo.prototype.onPlayed = function (callback) {
		this.player.addEventListener('onStateChange', function (e) {
			if(e.data === YT.PlayerState.ENDED) {
				callback();
			}
		});
	};

	YouTubeVideo.prototype.onPause = function (callback) {
		this.player.addEventListener('onStateChange', function (e) {
			if(e.data === YT.PlayerState.PAUSED) {
				callback();
			}
		});
	};

	return YouTubeVideo;

});
