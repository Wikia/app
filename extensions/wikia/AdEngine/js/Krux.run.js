/*global require*/
require(['wikia.window', 'ext.wikia.adEngine.krux'], function (window, Krux) {
	"use strict";
	if (window.wgEnableKruxTargeting) {
		window.wgAfterContentAndJS.push(function () {
			window.AdEngine_loadKruxLater(Krux);
		});
	}
});
