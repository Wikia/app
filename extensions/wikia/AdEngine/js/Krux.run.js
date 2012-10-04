(function(window, $, Krux) {
	'use strict';
	if (window.wgEnableKruxTargeting) {
		$(function() {
			window.AdEngine_loadKruxLater(Krux);
		});
	}
}(window, jQuery, Krux));
