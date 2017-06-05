/*global define, require*/
define('ext.wikia.adEngine.provider.factory.wikiaGpt', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.adEngine.slot.service.passbackHandler',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.services')
], function (
	adContext,
	btfBlocker,
	gptHelper,
	adUnitBuilder,
	passbackHandler,
	slotRegistry,
	log,
	lookups
) {
	'use strict';

	function overrideSizes(slotMap) {
		var context = adContext.getContext();

		if (context.opts.overridePrefootersSizes) {
			slotMap.PREFOOTER_LEFT_BOXAD.size = '300x250,468x60,728x90';
			delete slotMap.PREFOOTER_RIGHT_BOXAD;
		}
	}

	/**
	 * Creates GPT provider based on given params
	 *
	 * @param {string} logGroup     - wikia.log group
	 * @param {string} providerName - name of the provider
	 * @param {string} src          - src to set in slot targeting
	 * @param {Object} slotMap      - slot map (slot name => targeting)
	 * @param {Object} [extra]      - optional extra params
	 * @param {function} [extra.adUnitBuilder]  - provider's ad unit builder object
	 * @param {function} [extra.beforeSuccess]  - function to call before calling success
	 * @param {function} [extra.beforeCollapse] - function to call before calling collapse
	 * @param {function} [extra.beforeHop]      - function to call before calling hop
	 * @param {function} [extra.onSlotRendered] - function to call before calling renderEnded
	 * @param {boolean}  [extra.sraEnabled]     - whether to use Single Request Architecture
	 * @see extensions/wikia/AdEngine/js/providers/directGpt.js
	 * @returns {{name: string, canHandleSlot: function, fillInSlot: function}}
	 */
	function createProvider(logGroup, providerName, src, slotMap, extra) {
		extra = extra || {};

		overrideSizes(slotMap);

		function canHandleSlot(slotName) {
			log(['canHandleSlot', slotName], 'debug', logGroup);
			var ret = !!slotMap[slotName];
			log(['canHandleSlot', slotName, ret], 'debug', logGroup);

			return ret;
		}

		function addHook(slot, hookName, callback) {
			log([hookName, slot.name], 'debug', logGroup);

			slot.pre(hookName, function (adInfo) {
				if (typeof callback === 'function') {
					callback(slot.name, adInfo);
				}
			});
		}

		function getAdUnit(slot) {
			if (extra.adUnitBuilder) {
				return extra.adUnitBuilder.build(slot.name, src, passbackHandler.get(slot.name));
			}

			return adUnitBuilder.build(slot.name, src);
		}

		function fillInSlot(slot) {
			log(['fillInSlot', slot.name], 'debug', logGroup);

			var slotPath = getAdUnit(slot),
				slotTargeting = JSON.parse(JSON.stringify(slotMap[slot.name])); // copy value

			addHook(slot, 'success', extra.beforeSuccess);
			addHook(slot, 'collapse', extra.beforeCollapse);
			addHook(slot, 'hop', extra.beforeHop);
			addHook(slot, 'renderEnded', extra.onSlotRendered);

			slotTargeting.pos = slotTargeting.pos || slot.name;
			slotTargeting.src = src;
			slotTargeting.rv = slotRegistry.getRefreshCount(slot.name).toString();

			if (lookups) {
				lookups.storeRealSlotPrices(slot.name);
				lookups.extendSlotTargeting(slot.name, slotTargeting, providerName);
			}

			gptHelper.pushAd(slot, slotPath, slotTargeting, {
				sraEnabled: extra.sraEnabled,
				isPageFairRecoverable: extra.isPageFairRecoverable ? extra.isPageFairRecoverable(slot.name) : false,
				isSourcePointRecoverable: extra.isSourcePointRecoverable ? extra.isSourcePointRecoverable(slot.name) : false
			});
			log(['fillInSlot', slot.name, 'done'], 'debug', logGroup);
		}

		return {
			name: providerName,
			canHandleSlot: canHandleSlot,
			fillInSlot: extra.atfSlots ? btfBlocker.decorate(fillInSlot, extra) : fillInSlot
		};
	}

	return {
		createProvider: createProvider
	};
});
