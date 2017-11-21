/*global define, require*/
define('ext.wikia.adEngine.provider.factory.wikiaGpt', [
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.provider.gpt.helper',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.services')
], function (
	btfBlocker,
	gptHelper,
	defaultAdUnitBuilder,
	slotRegistry,
	log,
	lookups
) {
	'use strict';

	function rewriteExtras(slotName, extra) {
		return {
			testSrc: extra.testSrc,
			sraEnabled: extra.sraEnabled,
			isInstartLogicRecoverable: extra.isInstartLogicRecoverable ? extra.isInstartLogicRecoverable(slotName) : false,
			isPageFairRecoverable: extra.isPageFairRecoverable ? extra.isPageFairRecoverable(slotName) : false,
			isSourcePointRecoverable: extra.isSourcePointRecoverable ? extra.isSourcePointRecoverable(slotName) : false
		};
	}

	/**
	 * Creates GPT provider based on given params
	 *
	 * @param {string} logGroup     - wikia.log group
	 * @param {string} providerName - name of the provider
	 * @param {string} src          - src to set in slot targeting
	 * @param {Object} slotMap      - slot map (slot name => targeting)
	 * @param {Object} [extra]      - optional extra params
	 * @param {function} [extra.getAdUnitBuilder]  - provider's ad unit builder function
	 * @param {function} [extra.afterSuccess]  - function to call before calling success
	 * @param {function} [extra.afterCollapse] - function to call before calling collapse
	 * @param {function} [extra.afterHop]      - function to call before calling hop
	 * @param {function} [extra.onSlotRendered] - function to call before calling renderEnded
	 * @param {boolean}  [extra.sraEnabled]     - whether to use Single Request Architecture
	 * @see extensions/wikia/AdEngine/js/providers/directGpt.js
	 * @returns {{name: string, canHandleSlot: function, fillInSlot: function}}
	 */
	function createProvider(logGroup, providerName, src, slotMap, extra) {
		extra = extra || {};

		function canHandleSlot(slotName) {
			log(['canHandleSlot', slotName], 'debug', logGroup);
			var ret = !!slotMap[slotName];
			log(['canHandleSlot', slotName, ret], 'debug', logGroup);

			return ret;
		}

		function addHook(slot, hookName, callback) {
			log([hookName, slot.name], 'debug', logGroup);

			slot.post(hookName, function (adInfo) {
				if (typeof callback === 'function') {
					callback(slot.name, adInfo);
				}
			});
		}

		function getAdUnit(slot) {
			if (extra.getAdUnitBuilder) {
				return extra.getAdUnitBuilder().build(slot.name, src);
			}

			return defaultAdUnitBuilder.build(slot.name, src);
		}

		function fillInSlot(slot) {
			log(['fillInSlot', slot.name, providerName], 'debug', logGroup);

			var slotPath = getAdUnit(slot),
				slotTargeting = JSON.parse(JSON.stringify(slotMap[slot.name])); // copy value

			addHook(slot, 'success', extra.afterSuccess);
			addHook(slot, 'collapse', extra.afterCollapse);
			addHook(slot, 'hop', extra.afterHop);
			addHook(slot, 'renderEnded', extra.onSlotRendered);

			slotTargeting.pos = slotTargeting.pos || slot.name;
			slotTargeting.src = src;
			slotTargeting.rv = slotRegistry.getRefreshCount(slot.name).toString();

			if (lookups) {
				lookups.storeRealSlotPrices(slot.name);
				lookups.extendSlotTargeting(slot.name, slotTargeting, providerName);
				slotRegistry.storeScrollY(slot.name);
			}

			gptHelper.pushAd(slot, slotPath, slotTargeting, rewriteExtras(slot.name, extra));
			log(['fillInSlot', slot.name, providerName, 'done'], 'debug', logGroup);
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
