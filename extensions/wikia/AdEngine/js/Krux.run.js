/*global require*/
/*jshint camelcase:false*/
require([
	'wikia.window', 'wikia.log', 'wikia.scriptwriter', 'ext.wikia.adEngine.krux', 'jquery'
], function (window, log, scriptWriter, Krux, $) {
	'use strict';
	if (window.wgEnableKruxTargeting) {
		$(window).load(function () {
			scriptWriter.callLater(function () {
				log('Loading Krux code', 8, 'Krux.run.js');
				Krux.load(window.wgKruxCategoryId);
			});
		});
	}
});
