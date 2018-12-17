/*global define*/
define('ext.wikia.adEngine.video.vastParser', [
	'wikia.log',
	'wikia.querystring'
], function (log, Querystring) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.vastParser';

	function getFirstNumber(possibleValues) {
		var i, value;

		for (i = 0; i < possibleValues.length; i++) {
			value = possibleValues[i];

			if (value && !isNaN(value)) {
				return value;
			}
		}

		return '';
	}

	function getAdInfo(imaAd) {
		var adInfo = {};

		if (imaAd) {
			adInfo.lineItemId = imaAd.getAdId();
			adInfo.creativeId = imaAd.getCreativeId();
			adInfo.contentType = imaAd.getContentType();

			var wrapperAdIds = imaAd.getWrapperAdIds(),
				wrapperCreativeIds = imaAd.getWrapperCreativeIds();
console.error(imaAd.getAdId(), imaAd.getCreativeId(), wrapperAdIds, wrapperCreativeIds);
			if (wrapperAdIds && wrapperAdIds.length) {
				adInfo.lineItemId = getFirstNumber(wrapperAdIds);
			}

			if (wrapperCreativeIds && wrapperCreativeIds.length) {
				adInfo.creativeId = getFirstNumber(wrapperCreativeIds);
			}
		}

		return adInfo;
	}

	function parse(vastUrl, extra) {
		extra = extra || {};

		var adInfo,
			currentAd = getAdInfo(extra.imaAd),
			vastParams = new Querystring(vastUrl),
			customParams = encodeURI('?' + vastParams.getVal('cust_params', ''));

		adInfo = {
			contentType: currentAd.contentType || extra.contentType,
			creativeId: currentAd.creativeId || extra.creativeId,
			customParams:  new Querystring(customParams).getVals(),
			lineItemId: currentAd.lineItemId || extra.lineItemId,
			position: vastParams.getVal('vpos', null),
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
