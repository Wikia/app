/*global require*/
/*jshint maxlen:200*/
define('ext.wikia.adEngine.customAdsLoader', [
	'wikia.log'
],
function (
	log
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.customAdsLoader';

	function loadCustomAd(params) {
		log('loadCustomAd', 'debug', logGroup);

		var adModule = 'ext.wikia.adEngine.template.' + params.type;
		log('loadCustomAd: loading ' + adModule, 'debug', logGroup);

		require([adModule], function (adTemplate) {
			log('loadCustomAd: module ' + adModule + ' required', 'debug', logGroup);
			adTemplate.show(params);
		});
	}

	return {
		loadCustomAd: loadCustomAd
	};
});
