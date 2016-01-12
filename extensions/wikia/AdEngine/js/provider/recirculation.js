/*global define*/
define('ext.wikia.adEngine.provider.recirculation', [
	'wikia.document',
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.taboolaHelper',
	require.optional('ext.wikia.recirculation.recirculation')
], function (doc, log, adContext, taboolaHelper, recirculation) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.recirculation',
		recirculationSlot = 'RECIRCULATION_RAIL';

	function canHandleSlot(slotName) {
		var properSlot = slotName === recirculationSlot;
		log(['canHandleSlot', slotName, (properSlot && recirculation)], 'debug', logGroup);

		return (properSlot && recirculation);
	}

	function fillInSlot(slotName, slotElement, success, hop) {
		log(['fillInSlot', slotName, slotElement], 'debug', logGroup);

		taboolaHelper.loadTaboola();
		recirculation.injectRecirculationModule(slotElement);
	}

	return {
		name: 'Recirculation',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
