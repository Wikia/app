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
			var wikiaArticleFooter = doc.getElementById('WikiaArticleFooter'),
				wikiaMainContent = doc.getElementById('WikiaMainContent'),
				wikiaRail = doc.getElementById('WikiaRail');

			if (wikiaMainContent) {
				wikiaMainContent.parentNode.insertBefore(createElem('REVCONTENT_ABOVE_ARTICLE'), wikiaMainContent);
			}

			if (wikiaRail) {
				wikiaRail.insertBefore(createElem('REVCONTENT_RIGHT_RAIL'), wikiaRail.firstChild);
			}

			if (wikiaArticleFooter) {
				wikiaArticleFooter.insertBefore(createElem('REVCONTENT_BELOW_ARTICLE'), wikiaArticleFooter.firstChild);
			}

			slots.forEach(function (slotName) {
				win.adslots2.push(slotName);
			});
		});
	}

	return {
		init: init
	};
});
