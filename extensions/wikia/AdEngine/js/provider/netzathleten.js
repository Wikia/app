/*global define, require*/
define('ext.wikia.adEngine.provider.netzathleten', [
	'wikia.document',
	'wikia.scriptwriter'
], function (doc, scriptWriter) {
	'use strict';

	var libraryUrl = '//s.adadapter.netzathleten-media.de/API-1.0/NA-828433-1/naMediaAd.js',
		supportedSlots = [
			'SUPERBANNER'
		];

	function init() {
		scriptWriter.injectScriptByUrl(doc.body, libraryUrl, function () {
			window.naMediaAd.setValue('homesite', false);
		});
	}

	function canHandleSlot(slotName) {
		return supportedSlots.indexOf(slotName) !== -1;
	}

	function fillInSlot(slot) {
		var container = doc.createElement('div');

		container.id = 'naMediaAd_' + slot.name;
		slot.container.appendChild(container);

		window.naMediaAd.includeAd(slot.name);
	}

	return {
		name: 'NetzAthleten',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
