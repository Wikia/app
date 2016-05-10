/*global define, require*/
define('ext.wikia.adEngine.provider.factory.wikiaGpt', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.provider.gpt.helper',
	'wikia.log',
	require.optional('ext.wikia.adEngine.lookup.services')
], function (adContext, adLogicPageParams, gptHelper, log, lookups) {
	'use strict';

	function overrideSizes(slotMap) {
		var context = adContext.getContext();

		if (context.opts.overridePrefootersSizes) {
			slotMap.PREFOOTER_LEFT_BOXAD.size = '300x250,468x60,728x90';
			delete slotMap.PREFOOTER_RIGHT_BOXAD;
		}

		if (!!slotMap.INCONTENT_LEADERBOARD && context.slots.incontentLeaderboardAsOutOfPage) {
			delete slotMap.INCONTENT_LEADERBOARD.size;
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
	 * @param {function} [extra.beforeSuccess]  - function to call before calling success
	 * @param {function} [extra.beforeCollapse] - function to call before calling collapse
	 * @param {function} [extra.beforeHop]      - function to call before calling hop
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
			slot.pre('collapse', function (adInfo) {
				if (typeof extra.beforeCollapse === 'function') {
					extra.beforeCollapse(slot.name, adInfo);
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
