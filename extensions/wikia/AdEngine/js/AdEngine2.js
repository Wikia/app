/*global define*/
define('ext.wikia.adEngine.adEngine', [
	'ext.wikia.adEngine.adDecoratorLegacyParamFormat',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.hooks',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.log'
], function (
	adDecoratorLegacyParamFormat,
	eventDispatcher,
	adSlot,
	slotTracker,
	slotTweaker,
	registerHooks,
	doc,
	lazyQueue,
	log
) {
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

	function createSlot(queuedSlot, container, callbacks) {
		var slot = adSlot.create(queuedSlot.slotName, container, callbacks);
		registerHooks(slot, ['success', 'collapse', 'hop']);
		slot.post('success', queuedSlot.onSuccess);

		return slot;
	}

	function run(adConfig, adslots, queueName) {
		bla bla bla
	}

	return {run: run};
});
