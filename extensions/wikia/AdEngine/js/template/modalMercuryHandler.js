/*global define*/
define('ext.wikia.adEngine.template.modalMercuryHandler', [
	'wikia.window'
], function (win) {
	'use strict';

	var mercuryHandler = Function;

	mercuryHandler.prototype.create = function (adContainer, modalVisible) {
		win.Mercury.Modules.Ads.getInstance().createLightbox(adContainer, modalVisible);
	};

	mercuryHandler.prototype.show = function () {
		win.Mercury.Modules.Ads.getInstance().showLightbox();
	};

	mercuryHandler.prototype.getExpansionModel = function () {
		return {
			availableHeightRatio: 1,
			availableWidthRatio: 1,
			heightSubtract: 80,
			minWidth: 100,
			minHeight: 100,
			maximumRatio: 3
		};
	};

	return mercuryHandler;
});
