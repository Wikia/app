define('ooyala-player', function () {

	//TODO extract these variables outside
	var baseJSONSkinUrl = window.wgExtensionsPath.replace('http://', 'http://harrypotter.') + '/wikia/ArticleVideo/scripts/ooyala/skin.json?v=2';
	var pcode = 'J0MTUxOtPDJVNZastij14_v7VDRS'; // Part of an API might want to double check on the security of this
	var playerBrandingId = '6d79ed36a62a4a9885d9c961c70289a8';	//Fandom player branding ID

	function OoyalaHTML5Player(container, params, onPlayerCreate) {
		var playerWidth = container.scrollWidth;

		this.params = params;
		this.params.width = playerWidth;
		this.params.height = Math.floor((playerWidth * 9) / 16);
		this.params.pcode = pcode;
		this.params.playerBrandingId = playerBrandingId;
		this.params.onCreate = this.onCreate.bind(this);

		this.onPlayerCreated = onPlayerCreate;

		this.params.skin = {
			config: baseJSONSkinUrl
		};

		this.containerId = container.id;
		this.player = null;
	}

	OoyalaHTML5Player.prototype.setUpPlayer = function () {
		this.createPlayer();
	};

	/**
	 * @returns {void}
	 */
	OoyalaHTML5Player.prototype.createPlayer = function () {
		var self = this;
		window.OO.ready(function () {
			self.player = OO.Player.create(self.containerId, self.params.videoId, self.params);
		});
	};

	/**
	 * @param {*} player
	 * @returns {void}
	 */
	OoyalaHTML5Player.prototype.onCreate = function (player) {
		var messageBus = player.mb;
		var self = this;

		this.onPlayerCreated(player);

		messageBus.subscribe(window.OO.EVENTS.PLAYBACK_READY, 'ui-update', function () {
			self.onPlaybackReady()
		});
	};

	/**
	 * Called when the video is at the "start" state screen
	 *
	 * @returns {void}
	 */
	OoyalaHTML5Player.prototype.onPlaybackReady = function () {
		// Add video duration to start screen
		var durationElem = document.createElement('div');
		durationElem.innerHTML = mw.message('articlevideo-watch', this.getFormattedDuration(this.player.getDuration())).text().toUpperCase();
		durationElem.classList.add('video-duration');
		document.getElementById(this.containerId).querySelector('.oo-state-screen-info').appendChild(durationElem);
	};

	/**
	 * Formats milliseconds as HH:mm:ss duration
	 *
	 * @param {number}
	 * @returns {string}
	 */
	OoyalaHTML5Player.prototype.getFormattedDuration = function (millisec) {
		var seconds = parseInt(millisec / 1000, 10);
		var hours = parseInt(seconds / 3600, 10);
		seconds = seconds % 3600;
		var minutes = parseInt(seconds / 60, 10);
		seconds = seconds % 60;
		var duration = '';
		if (hours > 0) {
			duration += hours + ':';
			if (minutes < 10) {
				duration += '0';
			}
		}
		duration += minutes + ':';
		if (seconds < 10) {
			duration += '0';
		}
		return duration + seconds;
	};

	OoyalaHTML5Player.prototype.hideControls = function () {
		$('.oo-control-bar').css('visibility', 'hidden');
	};

	OoyalaHTML5Player.prototype.showControls = function () {
		$('.oo-control-bar').css('visibility', 'visible');
	};

	OoyalaHTML5Player.initHTMl5Players = function (videoElementId, videoId, onCreate) {
		var params = {
			videoId: videoId,
			autoplay: false
		};
		var html5Player = new OoyalaHTML5Player(document.getElementById(videoElementId), params, onCreate);
		html5Player.setUpPlayer();
		return html5Player;
	};

	return OoyalaHTML5Player;
});
