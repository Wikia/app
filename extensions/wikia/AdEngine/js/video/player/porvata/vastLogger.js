/*global define*/
define('ext.wikia.adEngine.video.player.porvata.vastLogger', [
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (instantGlobals, log, win) {
	'use strict';

	var config = instantGlobals.wgPorvataVastLoggerConfig || [],
		trackEndpoint = '/wikia.php?controller=AdEngine2Api&method=postPorvataInfo',
		logGroup = 'ext.wikia.adEngine.lookup.rubicon.rubiconVulcanTracking';

	function createConfigKey(data) {
		var eventName = data['event_name'] || '',
			vulcanAdvertiser = data['vulcan_advertiser'] || '',
			vulcanNetwork = data['vulcan_network'] || '';

		return [ vulcanNetwork, vulcanAdvertiser, eventName ].join('_');
	}

	function getNestedVastUrl(vastResponse) {
		var parser = new win.DOMParser(),
			vast = parser.parseFromString(vastResponse || '', 'text/xml'),
			nestedVastTag;

		nestedVastTag = vast.querySelector('VASTAdTagURI');

		if (nestedVastTag && nestedVastTag.childNodes.length) {
			return encodeURIComponent(nestedVastTag.childNodes[0].nodeValue);
		}

		return '';
	}

	function prepareData(data, playerParams) {
		return [
			'advertiser_id=' + data['vulcan_advertiser'] || '',
			'network_id=' + data['vulcan_network'] || '',
			'event_name=' + data['event_name'] || '',
			'ad_error_code=' + data['ad_error_code'] || '',
			'position=' + data['position'] || '',
			'browser=' + data['browser'] || '',
			'vast_url=' + getNestedVastUrl(playerParams.vastResponse) || ''
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
		var configKey = createConfigKey(data),
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
