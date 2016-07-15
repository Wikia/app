/*global define*/
define('ext.wikia.adEngine.video.dfpVastUrl', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.location',
	'wikia.log'
], function (adContext, page, loc, log) {
	'use strict';
	var adUnitId = '/5441/WIKIA_ATG',
		adSize = '640x480',
		baseUrl = 'https://pubads.g.doubleclick.net/gampad/ads?',
		correlator = Math.round(Math.random() * 10000000000),
		logGroup = 'ext.wikia.adEngine.video.dfpVastUrl';

	function getCustomParameters() {
		var pageLevelParams = page.getPageLevelParams(),
			customParameters = [];

		Object.keys(pageLevelParams).forEach(function (key) {
			customParameters.push(key + '=' + pageLevelParams[key]);
		});

		return encodeURIComponent(customParameters.join('&'));
	}

	function build() {
		var params = [
				'output=vast',
				'env=vp',
				'gdfp_req=1',
				'impl=s',
				'unviewed_position_start=1',
				'iu=' + adUnitId,
				'sz=' + adSize,
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
