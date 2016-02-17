/*global define*/
define('ext.wikia.adEngine.provider.recirculation', [
	'wikia.document',
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	require.optional('ext.wikia.recirculation.recirculation')
], function (doc, log, adContext, recirculation) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.recirculation',
		recirculationSlot = 'RECIRCULATION_RAIL';

	function canHandleSlot(slotName) {
		var properSlot = slotName === recirculationSlot;
		log(['canHandleSlot', slotName, (properSlot && recirculation)], 'debug', logGroup);

		return (properSlot && recirculation);
	}

	function fillInSlot(slot) {
		log(['fillInSlot', slot.name], 'debug', logGroup);

		recirculation.injectRecirculationModule(slot.container);

		slot.success();
	}

	return {
		name: 'Recirculation',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
});
