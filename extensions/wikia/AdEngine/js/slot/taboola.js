/*global define*/
define('ext.wikia.adEngine.slot.taboola', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.taboola',
		context = adContext.getContext(),
		slots = [
			'NATIVE_TABOOLA_ARTICLE',
			'NATIVE_TABOOLA_RAIL'
		];

	function init() {
		if (!context.providers.taboola) {
			log(['init', 'Taboola provider is disabled'], 'debug', logGroup);
			return;
		}

		slots.forEach(function (slotName) {
			if (doc.getElementById(slotName)) {
				log(['init', 'Push slot', slotName], 'debug', logGroup);
				win.adslots2.push(slotName);
			}
		});
	}

	return {
		init: init
	};
});
