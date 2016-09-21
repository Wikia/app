/*global define*/
define('ext.wikia.adEngine.video.vastBuilder', [
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
		logGroup = 'ext.wikia.adEngine.video.vastBuilder';

	function getCustomParameters() {
		var customParameters = [],
			pageParams = page.getPageLevelParams();

		Object.keys(pageParams).forEach(function (key) {
			if (pageParams[key]) {
				customParameters.push(key + '=' + pageParams[key]);
			}
		});

		return encodeURIComponent(customParameters.join('&'));
	}

	function getSize(aspectRatio) {
		return aspectRatio >= 1 ? adSizes.horizontal : adSizes.vertical;
	}

	function build(src, slotName, aspectRatio) {
		var params = [
				'output=vast',
				'env=vp',
				'gdfp_req=1',
				'impl=s',
				'unviewed_position_start=1',
				'iu=' + adUnitBuilder.build(slotName, src),
				'sz=' + getSize(aspectRatio),
				'url=' + loc.href,
				'correlator=' + correlator,
				'cust_params=' + getCustomParameters()
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
