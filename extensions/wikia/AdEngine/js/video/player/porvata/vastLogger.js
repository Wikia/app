/*global define*/
define('ext.wikia.adEngine.video.player.porvata.vastLogger', [
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (instantGlobals, log, win) {
	'use strict';

	var config = instantGlobals.wgPorvataVastLoggerConfig || [],
		trackEndpoint = '/wikia.php?controller=AdEngine2Api&method=postPorvataInfo',
		logGroup = 'ext.wikia.adEngine.video.player.porvata.vastLogger';

	function createConfigKey(advertiserId, eventName) {
		return [ advertiserId, eventName ].join('_');
	}

	function prepareData(data, playerParams) {
		return [
			'advertiser_id=' + playerParams.bid.rubiconAdvertiserId || '',
			'event_name=' + data['event_name'] || '',
			'ad_error_code=' + data['ad_error_code'] || '',
			'position=' + data['position'] || '',
			'browser=' + data['browser'] || '',
			'vast_url=' + encodeURIComponent(playerParams.vastUrl || '')
		];
	}

	function addCurrentAdDetails(player, postData) {
		var ad = player && player.ima.getAdsManager() && player.ima.getAdsManager().getCurrentAd();

		if (ad) {
			postData.push('ad_system=' + ad.getAdSystem() || '');
			postData.push('advertiser=' + ad.getAdvertiserName() || '');
			postData.push('content_type=' + ad.getContentType() || '');
			postData.push('media_url=' + encodeURIComponent(ad.getMediaUrl()) || '');
		}
	}

	function sendRequest(data) {
		var request = new win.XMLHttpRequest();

		request.open('POST', trackEndpoint, true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send(data);
	}

	function logVast(player, params, data) {
		if (!params.bid) {
			return;
		}

		var configKey = createConfigKey(params.bid.rubiconAdvertiserId, data['event_name']),
			postData;

		if (config.indexOf(configKey) === -1) {
			return;
		}

		postData = prepareData(data, params);
		addCurrentAdDetails(player, postData);

		log(['Track', postData], log.levels.debug, logGroup);
		sendRequest(postData.join('&'));
	}

	return {
		logVast: logVast
	};
});
