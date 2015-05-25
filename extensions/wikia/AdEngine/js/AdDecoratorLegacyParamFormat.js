/*global define*/
define('ext.wikia.adEngine.adDecoratorLegacyParamFormat', ['wikia.log'], function (log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adDecoratorLegacyParamFormat';

	function convertSimpleParamsForFillInSlot(slot) {
		if (slot instanceof Array) {
			slot = slot[0];
		}

		if (typeof slot === 'string') {
			slot = {
				slotName: slot
			};
		}

		if (slot && slot.slotName) {
			return slot;
		}
	}

	/**
	 * fillInSlot decorator. Returns function to call instead.
	 *
	 * @returns {function}
	 */
	function decorator(fillInSlot) {
		function enhancedFillInSlot(slot) {
			var param = convertSimpleParamsForFillInSlot(slot);
			if (param) {
				fillInSlot(param);
			} else {
				log(['Incorrect fillInSlot param:', param], 'error', logGroup);
			}
		}
		return enhancedFillInSlot;
	}

	return decorator;
});
