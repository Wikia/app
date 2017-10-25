define('ooyala-player', [
	'wikia.browserDetect',
	require.optional('ext.wikia.adEngine.utils.eventDispatcher'),
	require.optional('ext.wikia.adEngine.video.player.ooyala.ooyalaTracker'),
	require.optional('ext.wikia.adEngine.video.vastParser')
], function (browserDetect, eventDispatcher, ooyalaTracker, vastParser) {
	'use strict';
	var baseJSONSkinUrl = '/wikia.php?controller=OoyalaConfig&method=skin&cb=' + window.wgStyleVersion,
	// TODO ooyala only supports font icons so we probably need to extract our DS icons to font
		playIcon = '<svg width="22" height="30" viewBox="0 0 22 30" xmlns="http://www.w3.org/2000/svg"><path d="M21.573 15.818l-20 14c-.17.12-.372.18-.573.18-.158 0-.316-.037-.462-.112C.208 29.714 0 29.372 0 29V1C0 .625.207.283.538.11c.33-.17.73-.146 1.035.068l20 14c.268.187.427.493.427.82 0 .325-.16.63-.427.818z"/></svg>';

	function OoyalaHTML5Player(container, params, onPlayerCreate, inlineSkinConfig) {
		var playerWidth = container.scrollWidth;

		this.adIndex = 0;
		this.params = params;
		this.params.width = playerWidth;
		this.params.height = Math.floor((playerWidth * 9) / 16);
		this.params.onCreate = this.onCreate.bind(this);
		this.params.initialBitrate = {
			level: 0.8,
			duration: 2
		};

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
		var adTrackingParams = this.params.adTrackingParams,
			messageBus = player.mb,
			self = this;

		if (ooyalaTracker && adTrackingParams) {
			ooyalaTracker.register(player, adTrackingParams);
		}

		this.onPlayerCreate(player);

		messageBus.subscribe(window.OO.EVENTS.PLAYBACK_READY, 'ui-update', function () {
			self.onPlaybackReady();
		});

		messageBus.subscribe(OO.EVENTS.ADS_PLAYED, 'video-tracker', function () {
			self.adIndex += 1;
		});

		messageBus.subscribe(window.OO.EVENTS.PLAYED, 'ads', function () {
			// Reset line item id and creative id after the video is finished
			adTrackingParams.lineItemId = undefined;
			adTrackingParams.creativeId = undefined;
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
	 * Formats seconds as HH:mm:ss duration
	 *
	 * @param seconds
	 * @returns {string}
	 */
	OoyalaHTML5Player.prototype.getFormattedDuration = function (seconds) {
		seconds = parseInt(seconds, 10);
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

	OoyalaHTML5Player.prototype.updateAdSet = function (adSet) {
		var controller = this.player.modules && this.player.modules.find(function (module) {
			return module.name === 'adManagerController';
		});

		this.adIndex = 0;
		if (controller && controller.instance &&
			controller.instance.pageSettings &&
			controller.instance.pageSettings['google-ima-ads-manager']) {
			controller.instance.pageSettings['google-ima-ads-manager'].all_ads = adSet;
		}
	};

	OoyalaHTML5Player.initHTML5Player = function (videoElementId, options, onCreate) {
		var params = {
				videoId: options.videoId,
				adTrackingParams: options.adTrackingParams,
				autoplay: options.autoplay,
				initialVolume: options.autoplay ? 0 : 1,
				pcode: options.pcode,
				playerBrandingId: options.playerBrandingId,
				platform: 'html5'
			},
			html5Player;


		if (ooyalaTracker && params.adTrackingParams) {
			ooyalaTracker.track(params.adTrackingParams, 'init');
		}

		if (options.recommendedLabel) {
			params.discoveryApiAdditionalParams = {
				discovery_profile_id: 0,
				where: 'labels INCLUDES \'' + options.recommendedLabel + '\''
			};
		}

		if (options.vastUrl || options.adSet) {
			params['google-ima-ads-manager'] = {
				all_ads: options.adSet ? options.adSet : [{ tag_url: options.vastUrl }],
				useGoogleAdUI: true,
				useGoogleCountdown: false,
				onBeforeAdsManagerStart: function (IMAAdsManager) {
					// mutes VAST ads from the very beginning
					// FIXME with VPAID it causes volume controls to be in incorrect state
					IMAAdsManager.setVolume(params.initialVolume);
				},
				onAdRequestSuccess: function (IMAAdsManager, uiContainer) {

					require([
						'ext.wikia.adEngine.adContext',
						'ext.wikia.adEngine.video.player.porvata.moatVideoTracker'
					], function(adContext, moatVideoTracker) {
						if (adContext.getContext().opts.isMoatTrackingForFeaturedVideoEnabled) {
							moatVideoTracker.init(IMAAdsManager, uiContainer, google.ima.ViewMode.NORMAL, 'ooyala', 'featured-video');
						}
					});

					IMAAdsManager.addEventListener('loaded', function (eventData) {
						var player = html5Player.player,
							adData = eventData.getAdData(),
							currentAd;

						if (adData && vastParser) {
							currentAd = vastParser.getAdInfo(IMAAdsManager.getCurrentAd());

							options.adTrackingParams.creativeId = currentAd.creativeId || adData.creativeId;
							options.adTrackingParams.lineItemId = currentAd.lineItemId || adData.adId;
						}

						if (eventDispatcher && options.adSet && options.adSet[html5Player.adIndex]) {
							eventDispatcher.dispatch('adengine.video.status', {
								vastUrl: options.adSet[html5Player.adIndex].tag_url,
								creativeId: options.adTrackingParams.creativeId,
								lineItemId: options.adTrackingParams.lineItemId,
								status: 'success'
							});
						}

						if (eventData.getAdData().vpaid === true) {
							player.mb.publish(OO.EVENTS.WIKIA.SHOW_AD_TIME_LEFT, false);
							player.mb.publish(OO.EVENTS.WIKIA.SHOW_AD_FULLSCREEN_TOGGLE, false);
						} else if (browserDetect.isIPad()) {
							// Ads aren't visible on fullscreen when using iPad, let's hide the toggle
							player.mb.publish(OO.EVENTS.WIKIA.SHOW_AD_FULLSCREEN_TOGGLE, false);
						}
					}, false, this);
				}
			};

			params.replayAds = options.replayAds || false;
		}

		html5Player = new OoyalaHTML5Player(document.getElementById(videoElementId), params, onCreate, options.inlineSkinConfig);
		html5Player.setUpPlayer();

		return html5Player;
	};

	return OoyalaHTML5Player;
});
