/*global define*/
define('ext.wikia.adEngine.video.player.porvata.googleImaSetup', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.browserDetect',
	'wikia.log',
	'wikia.window'
], function (adContext, adUnitBuilder, vastUrlBuilder, browserDetect, log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata.googleImaSetup';

	function getPosBasedOnProduct(params) {
		if (params.adProduct === 'abcd') {
			return params.adProduct.toUpperCase();
		}

		if (params.adProduct === 'vuap') {
			return 'UAP_' + params.type.toUpperCase();
		}

		return params.vastTargeting.pos;
	}

	function buildVastUrl(params) {
		var vastUrlBuilderOptions = {},
			vastUrl;

		if (params.vastTargeting && params.vastTargeting.src && (params.adProduct || params.vastTargeting.pos)) {
			vastUrlBuilderOptions.adUnit = adUnitBuilder.build(getPosBasedOnProduct(params), params.vastTargeting.src);
		}

		vastUrl = params.vastUrl ||
			vastUrlBuilder.build(params.width / params.height, params.vastTargeting, vastUrlBuilderOptions);

		log(['build vast url', vastUrl, params], log.levels.debug, logGroup);

		return vastUrl;
	}

	function getOverriddenVast() {
		if (win.location.href.indexOf('porvata_override_vast=1') !== -1) {
			return win.localStorage.getItem('porvata_vast');
		}
	}

	function createRequest(params) {
		var adsRequest = new win.google.ima.AdsRequest(),
			overriddenVast = getOverriddenVast();

		if (params.vastResponse || overriddenVast) {
			adsRequest.adsResponse = overriddenVast || params.vastResponse;
		}

		adsRequest.adTagUrl = buildVastUrl(params);
		adsRequest.linearAdSlotWidth = params.width;
		adsRequest.linearAdSlotHeight = params.height;
		adsRequest.nonLinearAdSlotWidth = params.width;
		adsRequest.nonLinearAdSlotHeight = params.height;

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
