/*global require*/
/*jshint camelcase:false*/
require([
	'wikia.window', 'wikia.log', 'ext.wikia.adEngine.adLogicPageParams', 'ext.wikia.adEngine.krux'
], function (window, log, adLogicPageParams, Krux) {
	'use strict';

	var param, params, value;
	// Export page level params, so Krux can read them
	params = adLogicPageParams.getPageLevelParams();
	for (param in params) {
		if (params.hasOwnProperty(param)) {
			value = params[param];
			if (value) {
				window['kruxDartParam_' + param] = value.toString();
			}
		}
	}

	if (window.wgEnableKruxTargeting) {
		log('Loading Krux code', 8, 'Krux.run.js');
		Krux.load(window.wgKruxCategoryId);
	}
});
