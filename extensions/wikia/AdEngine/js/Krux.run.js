/*global require*/
/*jshint camelcase:false*/
require(['wikia.window', 'ext.wikia.adEngine.krux', 'jquery'], function (window, Krux, $) {
	'use strict';
	if (window.wgEnableKruxTargeting) {
		$(window).load(function () {
			window.AdEngine_loadKruxLater(Krux);
		});
	}
});
