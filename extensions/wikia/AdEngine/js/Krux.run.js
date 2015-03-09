/*global require*/
/*jshint camelcase:false*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.krux',
	'ext.wikia.adEngine.adLogicPageParams',
	'jquery',
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.window'
], function (adContext, Krux, adLogicPageParams, $, log, scriptWriter, window) {
	'use strict';

	var skinSites = {
			oasis: 'JU3_GW1b',
			venus: 'JU3_GW1b',
			wikiamobile: 'JTKzTN3f'
		},
		params,
		value;

	if (adContext.getContext().targeting.enableKruxTargeting) {

		// Export page level params, so Krux can read them
		params = adLogicPageParams.getPageLevelParams();
		Object.keys(params).forEach(function (key) {
			value = params[key];
			if (value) {
				window['kruxDartParam_' + key] = value.toString();
			}
		});

		$(window).on('load', function () {
			scriptWriter.callLater(function () {
				var targeting = adContext.getContext().targeting,
					siteId = skinSites[targeting.skin];

				if (siteId) {
					log('Loading Krux code, site id: ' + siteId, 'debug', 'Krux.run.js');
					Krux.load(siteId);
				} else {
					log('No Krux site id', 'error', 'Krux.run.js', true);
				}
			});
		});
	}
});
