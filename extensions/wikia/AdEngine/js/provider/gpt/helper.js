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
	'ext.wikia.aRecoveryEngine.recovery.sourcePoint',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('ext.wikia.adEngine.provider.gpt.sraHelper'),
	require.optional('ext.wikia.adEngine.slot.scrollHandler'),
	require.optional('ext.wikia.aRecoveryEngine.recovery.pageFair')
], function (
	log,
	adContext,
	adLogicPageParams,
	uapContext,
	adDetect,
	AdElement,
	googleTag,
	slotTargeting,
	sourcePoint,
	slotTweaker,
	sraHelper,
	scrollHandler,
	pageFair
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
	 * @param {Object}  slot                   - slot (ext.wikia.adEngine.slot.adSlot::create instance)
	 * @param {string}  slotPath               - slot path
	 * @param {Object}  slotTargetingData      - slot targeting details
	 * @param {Object}  extra                  - optional parameters
	 * @param {boolean} extra.sraEnabled       - whether to use Single Request Architecture
	 * @param {string}  extra.forcedAdType     - ad type for callbacks info
	 * @param {array}   extra.isSourcePointRecoverable - true if currently processed slot is recovered by SP
	 * @param {bool}    extra.isPageFairRecoverable - true if currently processed slot is recovered by PF
	 */
	function pushAd(slot, slotPath, slotTargetingData, extra) {
		extra = extra || {};
		var element,
			isRecoveryEnabled = sourcePoint.isEnabled() || (pageFair && pageFair.isEnabled()),
			isBlocking = sourcePoint.isBlocking(),
			adIsRecoverable = extra.isPageFairRecoverable || extra.isSourcePointRecoverable,
			adShouldBeRecovered = isRecoveryEnabled && isBlocking && adIsRecoverable,
			shouldPush = !isBlocking || adShouldBeRecovered,
			uapId = uapContext.getUapId();

		log(['sourcePoint - isBlocking, isRecoverable: ',
			sourcePoint.isBlocking(),
			extra.isSourcePointRecoverable], log.levels.debug, logGroup);

		log(['pageFair - isRecoverable: ', extra.isPageFairRecoverable], log.levels.debug, logGroup);

		log(['slot name, isBlocking, adIsRecoverable: ',
			slot.name,
			isBlocking,
			adIsRecoverable], log.levels.debug, logGroup);

		// copy value
		slotTargetingData = JSON.parse(JSON.stringify(slotTargetingData));

		if (isHiddenOnStart(slot.name)) {
			slotTweaker.hide(slot.name);
			slot.pre('success', function () {
				slotTweaker.show(slot.name);
			});
		}

		setAdditionalTargeting(slotTargetingData);

		element = new AdElement(slot.name, slotPath, slotTargetingData);

		function queueAd() {
			log(['queueAd', slot.name, element], log.levels.debug, logGroup);
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

			if (adShouldBeRecovered) {
				slotTargetingData.src = 'rec';
			}

			if (adShouldBeRecovered && pageFair && pageFair.isEnabled()) {
				slotTargetingData.rec = 'pagefair';
			}

			slotTargetingData.wsi = slotTargeting.getWikiaSlotId(slot.name, slotTargetingData.src);
			slotTargetingData.uap = uapId ? uapId.toString() : 'none';
		}

		function onAdLoadCallback(slotElementId, gptEvent, iframe) {
			// IE doesn't allow us to inspect GPT iframe at this point.
			// Let's launch our callback in a setTimeout instead.
			setTimeout(function () {
				log(['onAdLoadCallback', slotElementId], log.levels.info, logGroup);
				adDetect.onAdLoad(slot, gptEvent, iframe, extra.forcedAdType);
			}, 0);
		}

		function gptCallback(gptEvent) {
			log(['gptCallback', element.getId(), gptEvent], log.levels.info, logGroup);
			element.updateDataParams(gptEvent);
			googleTag.onAdLoad(slot.name, element, gptEvent, onAdLoadCallback);
			slot.renderEnded(gptEvent);
		}

		if (!googleTag.isInitialized()) {
			googleTag.init();
			googleTag.setPageLevelParams(adLogicPageParams.getPageLevelParams());
		}

		if (!shouldPush) {
			log(['Push blocked', slot.name], log.levels.debug, logGroup);
			slot.collapse();
			return;
		}

		log(['pushAd', slot.name, slotTargetingData], log.levels.info, logGroup);
		if (!slotTargetingData.flushOnly) {
			googleTag.registerCallback(element.getId(), gptCallback);
			googleTag.push(queueAd);
		}

		if (!sraHelper || !extra.sraEnabled || sraHelper.shouldFlush(slot.name)) {
			log('flushing', log.levels.debug, logGroup);
			googleTag.flush();
		}

		if (slotTargetingData.flushOnly) {
			log(['flushOnly - success', slot.name], log.levels.debug, logGroup);
			slot.success();
		}
	}

	function refreshSlot(slot) {
		log(['Refresh slot', slot.name, slot], log.levels.debug, logGroup);
		refreshTargetingData(slot);
		googleTag.refreshSlot(slot);
	}

	function refreshTargetingData(slot) {
		slot.setTargeting('uap', uapContext.getUapId().toString());
		return slot;
	}

	adContext.addCallback(function () {
		if (googleTag.isInitialized()) {
			googleTag.setPageLevelParams(adLogicPageParams.getPageLevelParams());
			uapContext.reset();
		}
	});

	return {
		refreshSlot: refreshSlot,
		pushAd: pushAd
	};
});
