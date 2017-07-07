define('ooyala-player', function () {

	var baseJSONSkinUrl = '/wikia.php?controller=OoyalaConfig&method=skin&cb=' + window.wgStyleVersion;
	// TODO ooyala only supports font icons so we probably need to extract our DS icons to font
	var playIcon = '<svg width="22" height="30" viewBox="0 0 22 30" xmlns="http://www.w3.org/2000/svg"><path d="M21.573 15.818l-20 14c-.17.12-.372.18-.573.18-.158 0-.316-.037-.462-.112C.208 29.714 0 29.372 0 29V1C0 .625.207.283.538.11c.33-.17.73-.146 1.035.068l20 14c.268.187.427.493.427.82 0 .325-.16.63-.427.818z"/></svg>';

	function OoyalaHTML5Player(container, params, onPlayerCreate, inlineSkinConfig) {
		var playerWidth = container.scrollWidth;

		this.params = params;
		this.params.width = playerWidth;
		this.params.height = Math.floor((playerWidth * 9) / 16);
		this.params.onCreate = this.onCreate.bind(this);

		this.onPlayerCreate = onPlayerCreate;

		this.params.skin = {
			config: baseJSONSkinUrl,
			inline: inlineSkinConfig
		};

		this.containerId = container.id;
		this.player = null;
	}

	OoyalaHTML5Player.prototype.setUpPlayer = function () {
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
		var messageBus = player.mb,
			self = this;

		this.onPlayerCreate(player);

		messageBus.subscribe(window.OO.EVENTS.PLAYBACK_READY, 'ui-update', function () {
			self.onPlaybackReady();
		});
	};

	/**
	 * Called when the video is at the "start" state screen
	 *
	 * @returns {void}
	 */
	OoyalaHTML5Player.prototype.onPlaybackReady = function () {
		var durationContainer = document.createElement('div'),
			videoDuration = document.createElement('span'),
			container = document.getElementById(this.containerId),
			playButton = container.querySelector('.oo-start-screen .oo-action-icon'),
			screenInfo = container.querySelector('.oo-state-screen-info');

		// Add video duration to start screen
		videoDuration.innerHTML = this.getFormattedDuration(this.player.getDuration());
		videoDuration.classList.add('video-time');

		durationContainer.innerHTML = mw.message('articlevideo-watch').text().toUpperCase();
		durationContainer.insertBefore(videoDuration, null);
		durationContainer.classList.add('video-duration');

		screenInfo.insertBefore(durationContainer, screenInfo.firstChild);

		// Replace default play icon with ours.
		playButton.innerHTML = playIcon;
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
		$('.oo-control-bar').css('opacity', '0');
		$('.oo-action-icon').css('display', 'none');
		$('.oo-state-screen-info').css('display', 'none');
	};

	OoyalaHTML5Player.prototype.showControls = function () {
		$('.oo-control-bar').css('opacity', '');
		$('.oo-action-icon').css('display', '');
		$('.oo-state-screen-info').css('display', '');
	};
	
	OoyalaHTML5Player.initHTML5Player = function (videoElementId, playerParams, videoId, onCreate, autoplay, vastUrl, inlineSkinConfig) {
		var params = {
				videoId: videoId,
				autoplay: autoplay,
				initialVolume: autoplay ? 0 : 1,
				pcode: playerParams.ooyalaPCode,
				playerBrandingId: playerParams.ooyalaPlayerBrandingId
			},
			html5Player;

		if (vastUrl) {
			params['google-ima-ads-manager'] = {
				all_ads: [
					{
						tag_url: vastUrl
					}
				],
				useGoogleCountdown: true
			};
			params.replayAds = false;
		}

		html5Player = new OoyalaHTML5Player(document.getElementById(videoElementId), params, onCreate, inlineSkinConfig);
		html5Player.setUpPlayer();

		return html5Player;
	};

	return OoyalaHTML5Player;
});
