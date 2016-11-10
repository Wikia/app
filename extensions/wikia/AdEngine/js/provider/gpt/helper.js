/*global define, setTimeout, require*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.helper', [
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.gpt.adDetect',
	'ext.wikia.adEngine.provider.gpt.adElement',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.slot.slotTargeting',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('ext.wikia.adEngine.provider.gpt.sraHelper'),
	require.optional('ext.wikia.adEngine.slot.scrollHandler')
], function (
	log,
	adContext,
	adLogicPageParams,
	uapContext,
	adDetect,
	AdElement,
	googleTag,
	slotTargeting,
	recoveryHelper,
	slotTweaker,
	sraHelper,
	scrollHandler
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.helper',
		hiddenSlots = [
			'INCONTENT_LEADERBOARD'
		];

	function isHiddenOnStart(slotName) {
		return hiddenSlots.indexOf(slotName) !== -1;
	}

	/**
	 * Push ad to queue and flush if it should be
	 *
	 * @param {Object}   slot               - slot (ext.wikia.adEngine.slot.adSlot::create instance)
	 * @param {string}   slotPath           - slot path
	 * @param {Object}   slotTargetingData  - slot targeting details
	 * @param {Object}   extra              - optional parameters
	 * @param {boolean}  extra.sraEnabled   - whether to use Single Request Architecture
	 * @param {string}   extra.forcedAdType - ad type for callbacks info
	 */
	function pushAd(slot, slotPath, slotTargetingData, extra) {
		extra = extra || {};
		var element,
			recoverableSlots = extra.recoverableSlots || [],
			shouldPushRecoverableAd = recoveryHelper.isBlocking() &&
				recoveryHelper.isRecoverable(slot.name, recoverableSlots),
			shouldPush = !recoveryHelper.isBlocking() || shouldPushRecoverableAd,
			uapId = uapContext.getUapId();

		log(['shouldPush',
			slot.name,
			recoveryHelper.isBlocking(),
			recoverableSlots,
			recoveryHelper.isRecoverable(slot.name, recoverableSlots)], 'debug', logGroup);

		slotTargetingData = JSON.parse(JSON.stringify(slotTargetingData)); // copy value

		if (isHiddenOnStart(slot.name)) {
			slotTweaker.hide(slot.name);
			slot.pre('success', function () {
				slotTweaker.show(slot.name);
			});
		}

		setAdditionalTargeting(slotTargetingData);

		element = new AdElement(slot.name, slotPath, slotTargetingData);

		function queueAd() {
			log(['queueAd', slot.name, element], 'debug', logGroup);
			slot.container.appendChild(element.getNode());

			googleTag.addSlot(element);
		}

		function setAdditionalTargeting(slotTargetingData) {
			if (scrollHandler) {
				var count = scrollHandler.getReloadedViewCount(slot.name);
				if (count !== null) {
					slotTargetingData.rv = count.toString();
				}
			}

			if (shouldPushRecoverableAd) {
				slotTargetingData.src = 'rec';
			}

			slotTargetingData.wsi = slotTargeting.getWikiaSlotId(slot.name, slotTargetingData.src);
			slotTargetingData.uap = uapId ? uapId.toString() : 'none';
		}

		function onAdLoadCallback(slotElementId, gptEvent, iframe) {
			// IE doesn't allow us to inspect GPT iframe at this point.
			// Let's launch our callback in a setTimeout instead.
			setTimeout(function () {
				log(['onAdLoadCallback', slotElementId], 'info', logGroup);
				adDetect.onAdLoad(slot, gptEvent, iframe, extra.forcedAdType);
			}, 0);
		}

		function gptCallback(gptEvent) {
			log(['gptCallback', element.getId(), gptEvent], 'info', logGroup);
			element.updateDataParams(gptEvent);
			googleTag.onAdLoad(slot.name, element, gptEvent, onAdLoadCallback);
		}

		if (!googleTag.isInitialized()) {
			googleTag.init();
			googleTag.setPageLevelParams(adLogicPageParams.getPageLevelParams());
		}

		if (!shouldPush) {
			log(['Push blocked', slot.name], 'debug', logGroup);
			slot.collapse();
			return;
		}

		log(['pushAd', slot.name], 'info', logGroup);
		if (!slotTargetingData.flushOnly) {
			googleTag.registerCallback(element.getId(), gptCallback);
			googleTag.push(queueAd);
		}

		if (!sraHelper || !extra.sraEnabled || sraHelper.shouldFlush(slot.name)) {
			log('flushing', 'debug', logGroup);
			googleTag.flush();
		}

		if (slotTargetingData.flushOnly) {
			slot.success();
		}
	}

	adContext.addCallback(function () {
		if (googleTag.isInitialized()) {
			googleTag.setPageLevelParams(adLogicPageParams.getPageLevelParams());
			uapContext.reset();
		}
	});

	return {
		pushAd: pushAd
	};
});
