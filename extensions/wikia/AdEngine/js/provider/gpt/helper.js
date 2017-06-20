/*global define, setTimeout, require*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.helper', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.provider.gpt.adDetect',
	'ext.wikia.adEngine.provider.gpt.adElement',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.slot.service.passbackHandler',
	'ext.wikia.adEngine.slot.slotTargeting',
	'ext.wikia.aRecoveryEngine.sourcePoint.recovery',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'ext.wikia.aRecoveryEngine.adBlockRecovery',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.log',
	require.optional('ext.wikia.adEngine.provider.gpt.sraHelper'),
	require.optional('ext.wikia.aRecoveryEngine.pageFair.recovery')
], function (
	adContext,
	adLogicPageParams,
	uapContext,
	adDetect,
	AdElement,
	googleTag,
	passbackHandler,
	slotTargeting,
	sourcePoint,
	adBlockDetection,
	adBlockRecovery,
	slotTweaker,
	log,
	sraHelper,
	pageFair
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.helper',
		hiddenSlots = [
			'INCONTENT_PLAYER'
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
			isBlocking = adBlockDetection.isBlocking(),
			isRecoveryEnabled = adBlockRecovery.isEnabled(),
			adIsRecoverable = extra.isPageFairRecoverable || extra.isSourcePointRecoverable,
			adShouldBeRecovered = isRecoveryEnabled && isBlocking && adIsRecoverable,
			shouldPush = !isBlocking || adShouldBeRecovered,
			slotName = slot.name,
			uapId = uapContext.getUapId();

		log(['isRecoveryEnabled, isBlocking, adIsRecoverable',
			isRecoveryEnabled, isBlocking, adIsRecoverable], log.levels.debug, logGroup);

		// copy value
		slotTargetingData = JSON.parse(JSON.stringify(slotTargetingData));

		if (isHiddenOnStart(slotName)) {
			slotTweaker.hide(slotName);
			slot.pre('success', function () {
				slotTweaker.show(slotName);
			});
		}

		setAdditionalTargeting(slotTargetingData);

		element = new AdElement(slotName, slotPath, slotTargetingData);

		if (pageFair && extra.isPageFairRecoverable) {
			log(['Adding adonis-marker to slot', slot], log.levels.debug, logGroup);

			pageFair.addMarker(element.node);
		}

		function queueAd() {
			log(['queueAd', slotName, element], log.levels.debug, logGroup);
			slot.container.appendChild(element.getNode());

			googleTag.addSlot(element);
		}

		function shouldSetSrcPremium() {
			return adContext.getContext().opts.premiumOnly;
		}

		function setAdditionalTargeting(slotTargetingData) {
			var abId;

			if (shouldSetSrcPremium()) {
				slotTargetingData.src = 'premium';
			} else if (adShouldBeRecovered) {
				slotTargetingData.src = 'rec';
			}

			slotTargetingData.passback = passbackHandler.get(slotName) || 'none';
			slotTargetingData.wsi = slotTargeting.getWikiaSlotId(slotName, slotTargetingData.src);
			slotTargetingData.hb_si = slotTargeting.getPrebidSlotId(slotTargetingData);
			slotTargetingData.uap = uapId ? uapId.toString() : 'none';
			slotTargetingData.outstream = slotTargeting.getOutstreamData() || 'none';

			abId = slotTargeting.getAbTestId(slotTargetingData);
			if (abId) {
				slotTargetingData.abi = abId;
			}
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
			googleTag.onAdLoad(slotName, element, gptEvent, onAdLoadCallback);
		}

		if (!googleTag.isInitialized()) {
			googleTag.init();
			googleTag.setPageLevelParams(adLogicPageParams.getPageLevelParams());
		}

		if (!shouldPush) {
			log(['Push blocked', slotName], log.levels.debug, logGroup);
			slot.collapse();
			return;
		}

		log(['pushAd', slotName, slotTargetingData], log.levels.info, logGroup);
		if (!slotTargetingData.flushOnly) {
			slot.pre('renderEnded', gptCallback);
			googleTag.push(queueAd);
		}

		if (!sraHelper || !extra.sraEnabled || sraHelper.shouldFlush(slotName)) {
			log('flushing', log.levels.debug, logGroup);
			googleTag.flush();
		}

		if (slotTargetingData.flushOnly) {
			log(['flushOnly - success', slotName], log.levels.debug, logGroup);
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
