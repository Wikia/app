/*global define, JSON*/
define('ext.wikia.adEngine.tracking.videoInfoTracker',  [
	'ext.wikia.adEngine.tracking.adInfoTracker'
], function (tracker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.tracking.videoInfoTracker';

	function parseParameters(content, separator) {
		var parameters = {};

		content.split('&').forEach(function (keyVal) {
			var data = keyVal.split('=');

			if (data.length === 2) {
				parameters[data[0]] = data[1];
			}
		});

		return parameters;
	}

	function track(vastUrl, adInfo) {
		var vastParams = parseParameters(vastUrl),
			params = parseParameters(decodeURIComponent(vastParams['cust_params'])),
			slotPrices = {};

		if (params.amznbid) {
			slotPrices.a9 = params.amznbid;
		}

		tracker.track(
			params.pos,
			params,
			params,
			{
				adProduct: 'video',
				creativeId: adInfo.creativeId,
				creativeSize: vastParams.sz,
				lineItemId: adInfo.lineItemId,
				status: adInfo.status
			},
			{
				realSlotPrices: slotPrices
			});
	}

	return {
		track: track
	};
});
