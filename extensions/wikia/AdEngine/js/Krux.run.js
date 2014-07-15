/*global require*/
/*jshint camelcase:false*/
require([
	'wikia.window', 'wikia.log', 'ext.wikia.adEngine.krux'
], function (window, log, Krux) {
	'use strict';
	if (window.wgEnableKruxTargeting) {
		log('Loading Krux code', 8, 'Krux.run.js');
		Krux.load(window.wgKruxCategoryId);
	}
});
