/*global define*/
define('ext.wikia.adEngine.video.vastBuilder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.location',
	'wikia.log'
], function (adContext, page, loc, log) {
	'use strict';
	var adSizes = {
			vertical: '320x480',
			horizontal: '640x480'
		},
		baseUrl = 'https://pubads.g.doubleclick.net/gampad/ads?',
		correlator = Math.round(Math.random() * 10000000000),
		logGroup = 'ext.wikia.adEngine.video.vastBuilder';

	function getCustomParameters(pageLevelParams) {
		var customParameters = [];

		Object.keys(pageLevelParams).forEach(function (key) {
			if (pageLevelParams[key]) {
				customParameters.push(key + '=' + pageLevelParams[key]);
			}
		});

		return encodeURIComponent(customParameters.join('&'));
	}

	function getAdUnit(pageLevelParams, src, slotName) {

		var dfpId = '5441',
			vertical = pageLevelParams.s0,
			dbName = pageLevelParams.s1,
			pageType = pageLevelParams.s2;

		return '/' + dfpId + '/wka.' + vertical + '/' + dbName + '//' + pageType + '/' + src + '/' + slotName;
	}

	function getSize(aspectRatio) {
		return aspectRatio >= 1 ? adSizes.horizontal : adSizes.vertical;
	}

	function build(src, slotName, aspectRatio) {
		var pageParams = page.getPageLevelParams();
		var params = [
				'output=vast',
				'env=vp',
				'gdfp_req=1',
				'impl=s',
				'unviewed_position_start=1',
				'iu=' + getAdUnit(pageParams, src, slotName),
				'sz=' + getSize(aspectRatio),
				'url=' + loc.href,
				'correlator=' + correlator,
				'cust_params=' + getCustomParameters(pageParams)
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
