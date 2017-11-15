/*global define*/
define('ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory', [
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document',
	'wikia.log'
], function (DOMElementTweaker, doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory',
		autoPlayClassName = 'autoplay',
		defaultAspectRatio = 320 / 240,
		videoPlayerClassName = 'video-player',
		videoFullscreenClassName = 'video-player-fullscreen',
		stopScrollingClassName = 'stop-scrolling';

	function prepareVideoAdContainer(videoAdContainer, videoSettings) {
		DOMElementTweaker.hide(videoAdContainer);
		videoAdContainer.classList.add(videoPlayerClassName);

		if (videoSettings.isAutoPlay()) {
			videoAdContainer.classList.add(autoPlayClassName);
		}

		return videoAdContainer;
	}

	function create(videoSettings, ima) {
		var params = videoSettings.getParams(),
			width = params.width,
			height = params.height,
			mobileVideoAd = params.container.querySelector('video'),
			videoAdContainer = params.container.querySelector('div'),
			destroyCallbacks = [];

		log(['create porvata player'], log.levels.debug, logGroup);

		return {
			container: prepareVideoAdContainer(videoAdContainer, videoSettings),
			ima: ima,
			addEventListener: function (eventName, callback) {
				ima.addEventListener(eventName, callback);
			},
			computeVastMediaAspectRatio: function () {
				var adsManager = ima.getAdsManager(),
					aspectRatio = width / height,
					currentAd,
					vastHeight = 0,
					vastWidth = 0;

				if (adsManager) {
					currentAd = adsManager.getCurrentAd();
					vastHeight = currentAd.getVastMediaHeight();
					vastWidth = currentAd.getVastMediaWidth();

					aspectRatio = (vastWidth && vastHeight) ? vastWidth / vastHeight : defaultAspectRatio;
				}

				return aspectRatio;
			},
			getRemainingTime: function () {
				return ima.getAdsManager().getRemainingTime();
			},
			getVolume: function() {
				return ima.getAdsManager().getVolume();
			},
			isFloating: function () {
				return Boolean(params.floatingContext && params.floatingContext.isFloating());
			},
			isMuted: function () {
				return ima.getAdsManager().getVolume() === 0;
			},
			isMobilePlayerMuted: function () {
				var mobileVideoAd = this.container.querySelector('video');
				return mobileVideoAd && mobileVideoAd.autoplay && mobileVideoAd.muted;
			},
			isPaused: function () {
				return ima.getStatus() === 'paused';
			},
			isPlaying: function () {
				return ima.getStatus() === 'playing';
			},
			isCompleted: function () {
				return ima.getStatus() === 'completed';
			},
			pause: function () {
				ima.getAdsManager().pause();
			},
			play: function (newWidth, newHeight) {
				if (newWidth !== undefined && newHeight !== undefined) {
					width = newWidth;
					height = newHeight;
				}
				if (!width || !height) {
					width = params.container.offsetWidth;
					height = params.container.offsetHeight;
				}

				ima.playVideo(width, height);
			},
			reload: function (reloadParams) {
				ima.reload(reloadParams);
			},
			removeEventListener: function (eventName, callback) {
				ima.removeEventListener(eventName, callback);
			},
			resize: function (newWidth, newHeight) {
				width = newWidth;
				height = newHeight;

				if (params.isFullscreen) {
					ima.resize(ima.viewMode.FULLSCREEN);
				} else {
					ima.resize(ima.viewMode.NORMAL, width, height);
				}
			},
			toggleFullscreen: function () {
				if (params.isFullscreen) {
					ima.resize(ima.viewMode.NORMAL, width, height);
					this.container.classList.add(videoFullscreenClassName);
					doc.documentElement.classList.remove(stopScrollingClassName);
					params.isFullscreen = false;
				} else {
					ima.resize(ima.viewMode.FULLSCREEN);
					this.container.classList.remove(videoFullscreenClassName);
					doc.documentElement.classList.add(stopScrollingClassName);
					params.isFullscreen = true;
				}
			},
			resume: function () {
				ima.getAdsManager().resume();
			},
			mute: function () {
				return this.setVolume(0);
			},
			unmute: function () {
				return this.setVolume(0.75);
			},
			volumeToggle: function () {
				if (this.isMuted()) {
					this.unmute();
				} else {
					this.mute();
				}
			},
			setVolume: function (volume) {
				this.updateVideoDOMElement(volume);
				ima.getAdsManager().setVolume(volume);

				// This is hack for Safari, because it can't dispatch original IMA event (volumeChange)
				ima.dispatchEvent('wikiaVolumeChange');
			},
			stop: function () {
				ima.dispatchEvent('wikiaAdStop');
				ima.getAdsManager().stop();
			},
			updateVideoDOMElement: function (volume) {
				if (mobileVideoAd) {
					mobileVideoAd.muted = volume === 0;
				}
			},
			addOnDestroyCallback: function (callback) {
				destroyCallbacks.push(callback);
			},
			destroy: function () {
				var callback = destroyCallbacks.pop();

				while (callback) {
					callback(this);
					callback = destroyCallbacks.pop();
				}
			}
		};
	}

	return {
		create: create
	};
});
