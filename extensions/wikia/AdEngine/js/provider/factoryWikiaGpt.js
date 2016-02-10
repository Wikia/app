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

		if (context.opts.overrideLeaderboardSizes) {
			for (var slotName in slotMap) {
				if (slotMap.hasOwnProperty(slotName)) {
					if (slotName.indexOf('TOP_LEADERBOARD') > -1) {
						slotMap[slotName].size = '728x90';
					}
				}
			}
		}

		if (context.opts.overridePrefootersSizes) {
			slotMap.PREFOOTER_LEFT_BOXAD.size = '300x250,728x90,970x250';
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
	 * @param {function} [extra.beforeSuccess] - function to call before calling success
	 * @param {function} [extra.beforeHop]     - function to call before calling hop
	 * @param {boolean}  [extra.sraEnabled]    - whether to use Single Request Architecture
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

		function fillInSlot(slotName, slotElement, success, hop) {
			log(['fillInSlot', slotName, slotElement, success, hop], 'debug', logGroup);

			var extraParams = {
					sraEnabled: extra.sraEnabled,
					recoverableSlots: extra.recoverableSlots
				},
				pageParams = adLogicPageParams.getPageLevelParams(),
				slotTargeting = JSON.parse(JSON.stringify(slotMap[slotName])), // copy value
				slotPath = [
					'/5441', 'wka.' + pageParams.s0, pageParams.s1, '', pageParams.s2, src, slotName
				].join('/');

			extraParams.success = function (adInfo) {
				if (typeof extra.beforeSuccess === 'function') {
					extra.beforeSuccess(slotName, adInfo);
				}
				success(adInfo);
			};

			extraParams.error = function (adInfo) {
				if (typeof extra.beforeHop === 'function') {
					extra.beforeHop(slotName, adInfo);
				}
				hop(adInfo);
			};

			slotTargeting.pos = slotTargeting.pos || slotName;
			slotTargeting.src = src;

			if (lookups) {
				lookups.extendSlotTargeting(slotName, slotTargeting, providerName);
			}

			gptHelper.pushAd(slotName, slotElement, slotPath, slotTargeting, extraParams);
			log(['fillInSlot', slotName, success, hop, 'done'], 'debug', logGroup);
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
