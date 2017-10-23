/*global define*/
define('ext.wikia.adEngine.video.vastParser', [
	'wikia.log',
	'wikia.querystring'
], function (log, Querystring) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.vastParser';

	function getAdInfo(imaAd) {
		var adInfo = {},
			wrapperCreativeId,
			wrapperId;

		if (imaAd) {
			adInfo.lineItemId = imaAd.getAdId();
			adInfo.creativeId = imaAd.getCreativeId();
			adInfo.contentType = imaAd.getContentType();

			wrapperId = imaAd.getWrapperAdIds();
			if (wrapperId.length) {
				adInfo.lineItemId = wrapperId[0];
			}

			wrapperCreativeId = imaAd.getWrapperCreativeIds();
			if (wrapperCreativeId.length) {
				adInfo.creativeId = wrapperCreativeId[0];
			}
		}

		return adInfo;
	}

	function parse(vastUrl, extra) {
		extra = extra || {};

		var adInfo,
			currentAd = getAdInfo(extra.imaAd),
			vastParams = new Querystring(vastUrl),
			customParams = '?' + vastParams.getVal('cust_params', '');

		adInfo = {
			contentType: currentAd.contentType || extra.contentType,
			creativeId: currentAd.creativeId || extra.creativeId,
			customParams:  new Querystring(customParams).getVals(),
			lineItemId: currentAd.lineItemId || extra.lineItemId,
			size: vastParams.getVal('sz', null)
		};

		log(['Parse VAST url', adInfo], log.levels.debug, logGroup);

		return adInfo;
	}

	return {
		getAdInfo: getAdInfo,
		parse: parse
	};
});
