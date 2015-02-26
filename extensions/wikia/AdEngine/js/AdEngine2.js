/*global define*/
define('ext.wikia.adEngine.adEngine', [
	'wikia.log',
	'wikia.lazyqueue',
	'ext.wikia.adEngine.adDecoratorLegacyParamFormat',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker'
], function (log, lazyQueue, adDecoratorLegacyParamFormat, eventDispatcher, slotTracker, slotTweaker) {
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
		log(['run', adslots, queueName], 'debug', logGroup);

		function fillInSlotUsingProvider(slot, provider, nextProvider) {
			log(['fillInSlotUsingProvider', provider.name, slot], 'debug', logGroup);

			var slotName = slot.slotName,
				aSlotTracker = slotTracker(provider.name, slotName, queueName);

			// Notify people there's the slot handled
			eventDispatcher.trigger('ext.wikia.adEngine fillInSlot', slotName, provider);

			provider.fillInSlot(slotName, function (extra) {
				// Success callback
				log(['success', provider.name, slotName, extra], 'debug', logGroup);
				aSlotTracker.track('success', extra);
				if (typeof slot.onSuccess === 'function') {
					slot.onSuccess();
				}
			}, function (extra) {
				// Hop callback
				log(['hop', provider.name, slotName, extra], 'debug', logGroup);
				aSlotTracker.track('hop', extra);
				nextProvider();
			});
		}

		function fillInSlot(slot) {
			log(['fillInSlot', slot], 'debug', logGroup);

			var slotName = slot.slotName,
				providerList = adConfig.getProviderList(slotName).slice(); // Get a copy of the array

			slotTweaker.show(slotName);

			log(['fillInSlot', slot, 'provider list', JSON.stringify(providerList)], 'debug', logGroup);

			function handleNoAd() {
				log(['handleNoAd', slot], 'debug', logGroup);
				slotTweaker.hide(slotName);
				if (typeof slot.onError === 'function') {
					slot.onError(slot);
				}
			}

			function nextProvider() {
				var provider;

				do {
					provider = providerList.shift();

					if (!provider) {
						handleNoAd();
						return;
					}

					if (provider.canHandleSlot(slotName)) {
						fillInSlotUsingProvider(slot, provider, nextProvider);
						return;
					}

					log(['fillInSlot', slot, 'skipping provider, cannot handle slot', provider], 'debug', logGroup);
				} while (provider);
			}

			nextProvider();
		}

		var decorators = adConfig.getDecorators() || [];
		if (adDecoratorLegacyParamFormat) {
			decorators.push(adDecoratorLegacyParamFormat);
		}

		log(['run', 'initializing lazyQueue on the queue'], 'debug', logGroup);
		lazyQueue.makeQueue(adslots, decorate(fillInSlot, decorators));

		log(['run', 'launching queue on adslots'], 'debug', logGroup);
		adslots.start();

		log(['run', 'initial queue handled'], 'debug', logGroup);
	}

	return {run: run};
});
