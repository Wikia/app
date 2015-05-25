/*global define*/
define('ext.wikia.adEngine.adDecoratorPageDimensions', [
	'ext.wikia.adEngine.adLogicPageDimensions', 'wikia.log', 'ext.wikia.adEngine.eventDispatcher'
], function (adLogicPageDimensions, log, eventDispatcher) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adDecoratorPageDimensions';

	/**
	 * fillInSlot decorator. Returns function to call instead.
	 *
	 * @returns {function}
	 */
	function decorator(fillInSlot) {
		log(['decorator', fillInSlot], 'debug', logGroup);

		return function (slot) {
			log(['decorated', slot], 'debug', logGroup);

			var slotname = slot.slotName;

			if (adLogicPageDimensions.isApplicable(slotname)) {
				adLogicPageDimensions.addSlot(slotname, function () {
					if (eventDispatcher.trigger('ext.wikia.adEngine.adDecoratorPageDimensions fillInSlot', slot)) {
						fillInSlot(slot);
					}
				});

				log(['decorated', slot, 'deferred'], 'debug', logGroup);
				return function () { return; };
			}

			log(['decorated', slot, 'return same'], 'debug', logGroup);
			return fillInSlot(slot);
		};
	}

	return decorator;
});
