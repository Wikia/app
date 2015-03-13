/*global define, require*/
define('ext.wikia.adEngine.provider.factory.wikiaGpt', [
	'wikia.log',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.gptHelper',
	require.optional('ext.wikia.adEngine.lookup.services')
], function (log, adLogicPageParams, gptHelper, lookups) {
	'use strict';

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
	 * @param {bool} [extra.noFlush]           - don't flush after each push
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

		function fillInSlot(slotName, success, hop) {
			log(['fillInSlot', slotName, success, hop], 'debug', logGroup);

			var pageParams = adLogicPageParams.getPageLevelParams(),
				slotTargeting = slotMap[slotName],
				slotPath = [
					'/5441', 'wka.' + pageParams.s0, pageParams.s1, '', pageParams.s2, src, slotName
				].join('/');

			function doSuccess(adInfo) {
				if (typeof extra.beforeSuccess === 'function') {
					extra.beforeSuccess(slotName, adInfo);
				}
				success(adInfo);
			}

			function doHop(adInfo) {
				if (typeof extra.beforeHop === 'function') {
					extra.beforeHop(slotName, adInfo);
				}
				hop(adInfo);
			}

			slotTargeting.pos = slotTargeting.pos || slotName;
			slotTargeting.src = src;

			if (lookups) {
				lookups.extendSlotTargeting(slotName, slotTargeting);
			}

			gptHelper.pushAd(slotName, slotPath, slotTargeting, doSuccess, doHop);

			if (extra.noFlush) {
				log(['fillInSlot', slotName, 'skipping flush'], 'debug', logGroup);
			} else {
				gptHelper.flushAds();
			}

			log(['fillInSlot', slotName, success, hop, 'done'], 'debug', logGroup);
		}

		return {
			name: providerName,
			canHandleSlot: canHandleSlot,
			fillInSlot: fillInSlot
		};
	}

	return {
		createProvider: createProvider,
		getFillInSlot: function (logGroup, src, slotMap, extra) {
			return createProvider(logGroup, '', src, slotMap, extra).fillInSlot;
		}
	};
});
