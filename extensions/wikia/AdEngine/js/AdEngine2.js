/*global define*/
define('ext.wikia.adEngine.adEngine', [
	'wikia.log',
	'wikia.lazyqueue',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.provider.null'
], function (log, LazyQueue, slotTracker, eventDispatcher, adProviderNull) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adEngine';

	function decorate(func, decorators) {
		log(['decorate', func, decorators], 'debug', logGroup);

		var i, len;

		if (decorators && decorators.length) {
			for (i = 0, len = decorators.length; i < len; i += 1) {
				func = decorators[i](func);
			}
		}

		return func;
	}

	function run(adConfig, adslots, queueName) {
		var decorators = adConfig.getDecorators();

		log(['run', adslots, queueName], 'debug', logGroup);

		function fillInSlotUsingProvider(slotname, provider, nextProvider) {
			log(['fillInSlotUsingProvider', provider.name, slotname], 'debug', logGroup);

			var aSlotTracker = slotTracker(provider.name, slotname, queueName);

			// Notify people there's the slot handled
			eventDispatcher.trigger('ext.wikia.adEngine fillInSlot', slotname, provider);

			provider.fillInSlot(slotname, function (extra) {
				// Success callback
				log(['success', provider.name, slotname, extra], 'debug', logGroup);
				aSlotTracker.track('success', extra);
			}, function (extra) {
				// Hop callback
				log(['hop', provider.name, slotname, extra], 'debug', logGroup);
				aSlotTracker.track('hop', extra);
				nextProvider();
			});
		}

		function fillInSlot(slot) {
			log(['fillInSlot', slot], 'debug', logGroup);

			var slotname = slot[0],
				providerList = adConfig.getProviderList(slotname).slice(); // Get a copy of the array

			log(['fillInSlot', slot, 'provider list', JSON.stringify(providerList)], 'debug', logGroup);

			function noop() {
				return;
			}

			function nextProvider() {
				var provider;

				do {
					provider = providerList.shift();

					if (!provider) {
						return fillInSlotUsingProvider(slotname, adProviderNull, noop);
					}

					if (provider.canHandleSlot(slotname)) {
						return fillInSlotUsingProvider(slotname, provider, nextProvider);
					}

					log(['fillInSlot', slot, 'skipping provider, cannot handle slot', provider], 'debug', logGroup);
				} while (provider);
			}

			nextProvider();
		}

		log(['run', 'initializing LazyQueue on the queue'], 'debug', logGroup);
		LazyQueue.makeQueue(adslots, decorate(fillInSlot, decorators));

		log(['run', 'launching queue on adslots'], 'debug', logGroup);
		adslots.start();

		log(['run', 'initial queue handled'], 'debug', logGroup);
	}

	return {run: run};
});
