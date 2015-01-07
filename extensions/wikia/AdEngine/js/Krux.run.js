/*global require*/
/*jshint camelcase:false*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.krux',
	'jquery',
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.window'
], function (adContext, Krux, $, log, scriptWriter, window) {
	'use strict';

	var skinSites = {
		oasis: 'JU3_GW1b',
		venus: 'JU3_GW1b',
		wikiamobile: 'JTKzTN3f'
	};

	if (adContext.getContext().targeting.enableKruxTargeting) {
		$(window).load(function () {
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
