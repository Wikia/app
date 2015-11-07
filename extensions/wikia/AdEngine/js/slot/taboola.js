/*global define*/
define('ext.wikia.adEngine.slot.taboola', [
	'ext.wikia.adEngine.adContext',
	'wikia.abTest',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, abTest, doc, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.taboola',
		context = adContext.getContext(),
		experimentName = 'NATIVE_ADS_TABOOLA';

	function getSlots() {
		var slots = [],
			abGroup = abTest.getGroup(experimentName);

		if (abGroup === 'GROUP_1' || abGroup === 'GROUP_3') {
			slots.push('NATIVE_TABOOLA_RAIL');
		}
		if (abGroup === 'GROUP_2' || abGroup === 'GROUP_3') {
			slots.push('NATIVE_TABOOLA_ARTICLE');
		}

		return slots;
	}

	function init() {
		if (!context.providers.taboola) {
			log(['init', 'Taboola provider is disabled'], 'debug', logGroup);
			return;
		}

		getSlots().forEach(function (slotName) {
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
