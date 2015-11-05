/*global require*/
/*jshint maxlen:200*/
define('ext.wikia.adEngine.customAdsLoader', ['wikia.log'], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.customAdsLoader';

	function loadCustomAd(params) {
		var adModule = 'ext.wikia.adEngine.template.' + params.type,
			adTemplate;

		log('loadCustomAd', 'debug', logGroup);
		log('loadCustomAd: loading ' + adModule, 'debug', logGroup);

		adTemplate = require(adModule);

		log('loadCustomAd: module ' + adModule + ' required', 'debug', logGroup);
		adTemplate.show(params);
	}

	return {
		loadCustomAd: loadCustomAd
	};
});
