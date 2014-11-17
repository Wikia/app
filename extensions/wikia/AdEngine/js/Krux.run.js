/*global require*/
/*jshint camelcase:false*/
require([
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.krux',
	'jquery',
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.window',
	require.optional('wikia.abTest')
], function (adContext, Krux, $, log, scriptWriter, window, abTest) {
	'use strict';

	var skinSites = {
		oasis: 'JU3_GW1b',
		wikiamobile: 'JTKzTN3f'
	};

	if (adContext.getContext().targeting.enableKruxTargeting) {
		$(window).load(function () {
			scriptWriter.callLater(function () {
				var targeting = adContext.getContext().targeting,
					useSkinSites = abTest && abTest.inGroup('KRUX_SKIN_SITES', 'YES'),
					skinSiteId = skinSites[targeting.skin],
					catSiteId = targeting.kruxCategoryId,
					siteId;

				if (useSkinSites) {
					siteId = skinSiteId;
				} else {
					siteId = catSiteId;
				}

				log('Loading Krux code', 'debug', 'Krux.run.js');

				if (siteId) {
					Krux.load(siteId);
				} else {
					log('No Krux site id', 'error', 'Krux.run.js', true);
				}
			});
		});
	}
});
