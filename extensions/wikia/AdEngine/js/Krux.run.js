/*global require*/
/*jshint camelcase:false*/
require([
	'wikia.window',
	'wikia.log',
	'wikia.scriptwriter',
	'ext.wikia.adEngine.krux',
	'ext.wikia.adEngine.adContext',
	'jquery'
], function (window, log, scriptWriter, Krux, adContext, $) {
	'use strict';
	if (adContext.getContext().targeting.enableKruxTargeting) {
		$(window).load(function () {
			scriptWriter.callLater(function () {
				log('Loading Krux code', 8, 'Krux.run.js');
				Krux.load(adContext.getContext().targeting.kruxCategoryId);
			});
		});
	}
});
