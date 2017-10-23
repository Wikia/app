/*global define*/
define('ext.wikia.adEngine.video.vastParser', [
	'wikia.log',
	'wikia.querystring'
], function (log, Querystring) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.vastParser';

	function updateAdInfo(adInfo) {
		var wrapperCreativeId,
			wrapperId;

		if (adInfo.imaAd) {
			adInfo.lineItemId = adInfo.imaAd.getAdId();
			adInfo.creativeId = adInfo.imaAd.getCreativeId();
			adInfo.contentType = adInfo.imaAd.getContentType();

			wrapperId = adInfo.imaAd.getWrapperAdIds();
			if (wrapperId.length) {
				adInfo.lineItemId = wrapperId[0];
			}

			wrapperCreativeId = adInfo.imaAd.getWrapperCreativeIds();
			if (wrapperCreativeId.length) {
				adInfo.creativeId = wrapperCreativeId[0];
			}
		}

		return adInfo;
	}

	function parse(vastUrl, adInfo) {
		adInfo = adInfo || {};

		var vastParams = new Querystring(vastUrl),
			customParams = '?' + vastParams.getVal('cust_params', '');

		updateAdInfo(adInfo);

		adInfo.customParams = new Querystring(customParams).getVals();
		adInfo.size = vastParams.getVal('sz', null);

		log(['Parse VAST url', adInfo], log.levels.debug, logGroup);

		return adInfo;
	}

	return {
		parse: parse
	};
});
