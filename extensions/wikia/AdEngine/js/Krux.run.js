/*global require*/
/*jshint camelcase:false*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'jquery',
	'wikia.krux',
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.window'
], function (adContext, adLogicPageParams, $, krux, log, scriptWriter, win) {
	'use strict';

	var skinSites = {
			oasis: 'JU3_GW1b',
			venus: 'JU3_GW1b',
			wikiamobile: 'JTKzTN3f'
		};

	$(win).on('load', function () {
		var targeting = adContext.getContext().targeting,
			siteId = skinSites[targeting.skin];

		if (siteId) {
			log('Loading Krux code, site id: ' + siteId, 'debug', 'Krux.run.js');
			krux.load(siteId);
		} else {
			log('No Krux site id', 'error', 'Krux.run.js', true);
		}
	});
});
