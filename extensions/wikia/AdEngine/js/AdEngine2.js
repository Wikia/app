/*global define*/
define('ext.wikia.adEngine.adEngine', [
	'wikia.document',
	'wikia.log',
	'wikia.lazyqueue',
	'ext.wikia.adEngine.adDecoratorLegacyParamFormat',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker'
], function (doc, log, lazyQueue, adDecoratorLegacyParamFormat, eventDispatcher, adSlot, slotTracker, slotTweaker) {
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

	function cleanProviderContainers(slotName) {
		var slotContainer = doc.getElementById(slotName),
			containers,
			i;

		if (!slotContainer) {
			return;
		}

		containers = slotContainer.childNodes;

		for (i = containers.length - 1; i >= 0; i -= 1) {
			if (containers[i].tagName !== 'SCRIPT') { // keep the adslots2.push script
				slotContainer.removeChild(containers[i]);
			}
		}
	}

	function prepareAdProviderContainer(providerName, slotName) {
		// TODO: remove after Liftium-era
		var providerContainerId = providerName + '_' + slotName.split('.')[0],
			adContainer = doc.getElementById(slotName),
			providerContainer = doc.getElementById(providerContainerId);

		if (!providerContainer && adContainer) {
			providerContainer = doc.createElement('div');
			providerContainer.id = providerContainerId;
			adContainer.appendChild(providerContainer);
		}

		log(['prepareAdProviderContainer', providerName, slotName, providerContainer], 'debug', logGroup);
		return providerContainer;
	}

	/**
	 * Initialize the provider before the first use
	 * Build the queue for fillInSlot and call initialize (if present)
	 *
	 * !! If initialize method is present in a provider it MUST accept a callback param
	 * and call it back once it is initialized !!
	 *
	 * TODO (if useful): support error param, so initialize can cause a provider to always hop?
	 */
	function initializeProviderOnce(provider) {
		if (!provider.fillInSlotQueue) {
			provider.fillInSlotQueue = [];
			lazyQueue.makeQueue(provider.fillInSlotQueue, function (args) {
				provider.fillInSlot.apply(provider, args);
			});

			if (provider.initialize) {
				// Only start flushing the fillInSlot queue once the provider is initialized
				provider.initialize(provider.fillInSlotQueue.start);
			} else {
				// No initialize function, let's fill in the slots immediately
				provider.fillInSlotQueue.start();
			}
		}
	}

	function run(adConfig, adslots, queueName) {
		log(['run', adslots, queueName], 'debug', logGroup);

		function fillInSlotUsingProvider(queuedSlot, provider, nextProvider) {
			log(['fillInSlotUsingProvider', provider.name, queuedSlot], 'debug', logGroup);

			var slot,
				slotName = queuedSlot.slotName,
				slotElement = prepareAdProviderContainer(provider.name, slotName),
				aSlotTracker = slotTracker(provider.name, slotName, queueName);

			slot = adSlot.create(slotName, slotElement);

			// Notify people there's the slot handled
			eventDispatcher.trigger('ext.wikia.adEngine fillInSlot', slotName, provider);

			initializeProviderOnce(provider);

			slot.post('success', function (extra) {
				log(['success', provider.name, slotName, extra], 'debug', logGroup);
				aSlotTracker.track('success', extra);
			});
			slot.post('success', queuedSlot.onSuccess);
			slot.post('hop', function (extra) {
				log(['hop', provider.name, slotName, extra], 'debug', logGroup);
				aSlotTracker.track('hop', extra);
				nextProvider();
			});

			provider.fillInSlotQueue.push([slot]);
		}

		function fillInSlot(queuedSlot) {
			log(['fillInSlot', queuedSlot], 'debug', logGroup);

			var slotName = queuedSlot.slotName,
				providerList = adConfig.getProviderList(slotName).slice(); // Get a copy of the array

			slotTweaker.show(slotName);

			log(['fillInSlot', queuedSlot, 'provider list', JSON.stringify(providerList)], 'debug', logGroup);

			function handleNoAd() {
				log(['handleNoAd', queuedSlot], 'debug', logGroup);
				slotTweaker.hide(slotName);
				if (typeof queuedSlot.onError === 'function') {
					queuedSlot.onError(queuedSlot);
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
						fillInSlotUsingProvider(queuedSlot, provider, nextProvider);
						return;
					}

					log(['fillInSlot', queuedSlot, 'skipping provider, cannot handle slot', provider], 'debug', logGroup);
				} while (provider);
			}

			cleanProviderContainers(slotName);
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
