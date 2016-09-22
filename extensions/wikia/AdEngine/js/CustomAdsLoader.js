/*global require*/
/*jshint maxlen:200*/
define('ext.wikia.adEngine.customAdsLoader', ['wikia.log'], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.customAdsLoader',
		templatesService;

	function registerTemplatesService(service) {
		templatesService = service;
	}
	function loadCustomAd(params) {
		log('loadCustomAd', 'debug', logGroup);

		templatesService.renderTemplate(params);
	}

	return {
		loadCustomAd: loadCustomAd,
		registerTemplatesService: registerTemplatesService
	};
});
