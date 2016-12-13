/*global define, google*/
define('ext.wikia.adEngine.video.player.porvata.googleImaSetup', [
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.browserDetect',
	'wikia.log',
	'wikia.window'
], function (vastUrlBuilder, browserDetect, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.porvata.googleImaSetup';

	function createRequest(vastUrl, width, height) {
		var adsRequest = new win.google.ima.AdsRequest();

		adsRequest.adTagUrl = vastUrl;
		adsRequest.linearAdSlotWidth = width;
		adsRequest.linearAdSlotHeight = height;

		log(['ads request created', adsRequest], log.levels.debug, logGroup);

		return adsRequest;
	}

	function getRenderingSettings() {
		var adsRenderingSettings = new win.google.ima.AdsRenderingSettings(),
			maximumRecommendedBitrate = 68000; // 2160p High Frame Rate

		if (!browserDetect.isMobile()) {
			adsRenderingSettings.bitrate = maximumRecommendedBitrate;
		}

		adsRenderingSettings.enablePreloading = true;
		adsRenderingSettings.uiElements = [];

		log(['ads rendering settings created', adsRenderingSettings], log.levels.debug, logGroup);

		return adsRenderingSettings;
	}

	function buildVastUrl(params) {
		var vastUrl;

		vastUrl = params.vastUrl || vastUrlBuilder.build(params.width / params.height, params.vastTargeting);

		log(['VAST URL: ', vastUrl, 'params: ', params], log.levels.debug, logGroup);

		return win._sp_.getSafeUri(vastUrl);
	}

	return {
		buildVastUrl: buildVastUrl,
		createRequest: createRequest,
		getRenderingSettings: getRenderingSettings
	};
});
