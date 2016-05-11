/*global define*/
define('ext.wikia.adEngine.slot.revcontentSlots', [
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (recoveryHelper, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.revcontentSlots',
		slots = [
			'REVCONTENT_ABOVE_ARTICLE',
			'REVCONTENT_RIGHT_RAIL',
			'REVCONTENT_BELOW_ARTICLE'
		];

	function createElem(id) {
		var el = document.createElement('div');

		el.id = id;

		return el;
	}

	function init() {
		log('init', 'Init Revcontent slots', logGroup);

		recoveryHelper.addOnBlockingCallback(function () {
			var wikiaRail = doc.getElementById('WikiaRail'),
				wikiaMainContent = doc.getElementById('WikiaMainContent');

			if (wikiaMainContent) {
				wikiaMainContent.parentNode.insertBefore(createElem('REVCONTENT_ABOVE_ARTICLE'), wikiaMainContent);
				wikiaMainContent.appendChild(createElem('REVCONTENT_BELOW_ARTICLE'));
			}

			if (wikiaRail) {
				wikiaRail.insertBefore(createElem('REVCONTENT_RIGHT_RAIL'), wikiaRail.firstChild);
			}

			slots.forEach(win.adslots2.push);
		});
	}

	return {
		init: init
	};
});
