/*global define, require*/
define('ext.wikia.adEngine.provider.factory.wikiaGpt', [
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.provider.gpt.helper',
	'wikia.geo',
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.services')
], function (adLogicPageParams, gptHelper, geo, log, lookups) {
	'use strict';
	var country = geo.getCountryCode();

	function overrideSizes(slotMap, newSizes) {
		var slotName;
		for (slotName in slotMap) {
			if (slotMap.hasOwnProperty(slotName) && newSizes[slotName]) {
				slotMap[slotName].size = newSizes[slotName];
			}
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
	 * @param {function} [extra.beforeSuccess] - function to call before calling success
	 * @param {function} [extra.beforeHop]     - function to call before calling hop
	 * @param {boolean}  [extra.sraEnabled]    - whether to use Single Request Architecture
	 * @see extensions/wikia/AdEngine/js/providers/directGpt.js
	 * @returns {{name: string, canHandleSlot: function, fillInSlot: function}}
	 */
	function createProvider(logGroup, providerName, src, slotMap, extra) {
		extra = extra || {};

		if (extra.overrideSizesPerCountry && extra.overrideSizesPerCountry[country]) {
			overrideSizes(slotMap, extra.overrideSizesPerCountry[country]);
		}

		function canHandleSlot(slotName) {
			log(['canHandleSlot', slotName], 'debug', logGroup);
			var ret = !!slotMap[slotName];
			log(['canHandleSlot', slotName, ret], 'debug', logGroup);

			return ret;
		}

		function fillInSlot(slot) {
			log(['fillInSlot', slot.name], 'debug', logGroup);

			var pageParams = adLogicPageParams.getPageLevelParams(),
				slotTargeting = JSON.parse(JSON.stringify(slotMap[slot.name])), // copy value
				slotPath = [
					'/5441', 'wka.' + pageParams.s0, pageParams.s1, '', pageParams.s2, src, slot.name
				].join('/');

			slot.pre('success', function (adInfo) {
				if (typeof extra.beforeSuccess === 'function') {
					extra.beforeSuccess(slot.name, adInfo);
				}
			});
			slot.pre('hop', function (adInfo) {
				if (typeof extra.beforeHop === 'function') {
					extra.beforeHop(slot.name, adInfo);
				}
			});

			slotTargeting.pos = slotTargeting.pos || slot.name;
			slotTargeting.src = src;

			if (lookups) {
				lookups.extendSlotTargeting(slot.name, slotTargeting, providerName);
			}

			gptHelper.pushAd(slot, slotPath, slotTargeting, {
				sraEnabled: extra.sraEnabled,
				recoverableSlots: extra.recoverableSlots
			});
			log(['fillInSlot', slot.name, 'done'], 'debug', logGroup);
		}

		return {
			name: providerName,
			canHandleSlot: canHandleSlot,
			fillInSlot: fillInSlot
		};
	}

	return {
		createProvider: createProvider
	};
});
