/*global require*/
define('ext.wikia.adEngine.templatesService', ['wikia.log'], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.templatesService';

	function renderTemplate(params) {
		var templateModuleName;

		log('show template', 'debug', logGroup);

		templateModuleName = 'ext.wikia.adEngine.template.' + params.type;

		require([templateModuleName], function (templateModule) {
			log('loadCustomAd: module ' + templateModule + ' required', 'debug', logGroup);
			templateModule.show(params);
		});
	}

	return {
		renderTemplate: renderTemplate
	};
});
