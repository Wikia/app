/*global define*/
define('ext.wikia.adEngine.video.vastUrlBuilder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'wikia.location',
	'wikia.log'
], function (adContext, page, adUnitBuilder, loc, log) {
	'use strict';
	var adSizes = {
			vertical: '320x480',
			horizontal: '640x480'
		},
		baseUrl = 'https://pubads.g.doubleclick.net/gampad/ads?',
		correlator = Math.round(Math.random() * 10000000000),
		defaultAdUnit = '/5441/VIDEO_ATG',
		logGroup = 'ext.wikia.adEngine.video.vastUrlBuilder';

	function getCustomParameters(slotName, src) {
		var customParameters = [],
			params = page.getPageLevelParams();

		params.pos = slotName;
		params.src = src;

		Object.keys(params).forEach(function (key) {
			if (params[key]) {
				customParameters.push(key + '=' + params[key]);
			}
		});

		return encodeURIComponent(customParameters.join('&'));
	}

	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}

	function getSize(aspectRatio) {
		return aspectRatio >= 1 || !isNumeric(aspectRatio) ? adSizes.horizontal : adSizes.vertical;
	}

	function build(src, slotName, aspectRatio) {
		var params = [
				'output=vast',
				'env=vp',
				'gdfp_req=1',
				'impl=s',
				'unviewed_position_start=1',
				'iu=' + (src && slotName ?  adUnitBuilder.build(slotName, src) : defaultAdUnit),
				'sz=' + getSize(aspectRatio),
				'url=' + loc.href,
				'correlator=' + correlator,
				'cust_params=' + getCustomParameters(slotName, src)
			],
			url = baseUrl + params.join('&');

		log(['build', url], 'debug', logGroup);

		return url;
	}

	adContext.addCallback(function () {
		correlator = Math.round(Math.random() * 10000000000);
	});

	return {
		build: build
	};
});

// TODO: ADEN-4128 - remove me
// ext.wikia.adEngine.video.vastBuilder is used in Mercury
define('ext.wikia.adEngine.video.vastBuilder', [
	'ext.wikia.adEngine.video.vastUrlBuilder'
], function (vastUrlBuilder) {
	'use strict';
	return vastUrlBuilder;
});
