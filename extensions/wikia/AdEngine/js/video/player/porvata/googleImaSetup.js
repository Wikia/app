/*global define*/
define('ext.wikia.adEngine.video.player.porvata.googleImaSetup', [
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.browserDetect',
	'wikia.log',
	'wikia.window'
], function (vastUrlBuilder, recoveryHelper, browserDetect, log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata.googleImaSetup';

	function buildVastUrl(params) {
		var vastUrl;

		vastUrl = params.vastUrl || vastUrlBuilder.build(params.width / params.height, params.vastTargeting);

		log(['build vast url', vastUrl, params], log.levels.debug, logGroup);

		return recoveryHelper.getSafeUri(vastUrl);
	}

	function createRequest(params) {
		var adsRequest = new win.google.ima.AdsRequest();

		adsRequest.adTagUrl = buildVastUrl(params);
		adsRequest.linearAdSlotWidth = params.width;
		adsRequest.linearAdSlotHeight = params.height;

		log(['ads request created', adsRequest], log.levels.debug, logGroup);

		return adsRequest;
	}

	function getRenderingSettings(params) {
		var adsRenderingSettings = new win.google.ima.AdsRenderingSettings(),
			maximumRecommendedBitrate = 68000; // 2160p High Frame Rate

		params = params || {};

		if (!browserDetect.isMobile()) {
			adsRenderingSettings.bitrate = maximumRecommendedBitrate;
		}

		adsRenderingSettings.loadVideoTimeout = params.loadVideoTimeout || 15000;
		adsRenderingSettings.enablePreloading = true;
		adsRenderingSettings.uiElements = [];

		log(['ads rendering settings created', adsRenderingSettings], log.levels.debug, logGroup);

		return adsRenderingSettings;
	}

	return {
		createRequest: createRequest,
		getRenderingSettings: getRenderingSettings
	};
});
