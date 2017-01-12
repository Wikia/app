/*global define*/
define('ext.wikia.adEngine.video.vastUrlBuilder', [
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.adEngine.slot.slotTargeting',
	'wikia.location',
	'wikia.log'
], function (page, adUnitBuilder, slotTargeting, loc, log) {
	'use strict';
	var adSizes = {
			vertical: '320x480',
			horizontal: '640x480'
		},
		baseUrl = 'https://pubads.g.doubleclick.net/gampad/ads?',
		logGroup = 'ext.wikia.adEngine.video.vastUrlBuilder';

	function getCustomParameters(slotParams) {
		var customParameters,
			params = page.getPageLevelParams(),
			wsi = slotTargeting.getWikiaSlotId(slotParams.pos, slotParams.src);

		customParameters = ['wsi=' + wsi];

		Object.keys(params).forEach(function (key) {
			if (params[key]) {
				customParameters.push(key + '=' + params[key]);
			}
		});

		Object.keys(slotParams).forEach(function (key) {
			if (slotParams[key]) {
				customParameters.push(key + '=' + slotParams[key]);
			}
		});

		return encodeURIComponent(customParameters.join('&'));
	}

	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}

	function getSizeByAspectRatio(aspectRatio) {
		return aspectRatio >= 1 || !isNumeric(aspectRatio) ? adSizes.horizontal : adSizes.vertical;
	}

	function build(aspectRatio, slotParams) {
		slotParams = slotParams || {};
		var correlator = Math.round(Math.random() * 10000000000),
			params = [
				'output=vast',
				'env=vp',
				'gdfp_req=1',
				'impl=s',
				'unviewed_position_start=1',
				'iu=' + adUnitBuilder.build(slotParams.pos, slotParams.src),
				'sz=' + getSizeByAspectRatio(aspectRatio),
				'url=' + loc.href,
				'correlator=' + correlator,
				'cust_params=' + getCustomParameters(slotParams)
			],
			url = baseUrl + params.join('&');

		log(['build', url], 'debug', logGroup);

		return url;
	}

	return {
		build: build
	};
});
