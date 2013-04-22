require(['wikia.window'], function (window) {
	'use strict';
	if (window.wgEnableKruxTargeting) {
		window.AdEngine_loadKruxLater();
	}
});
