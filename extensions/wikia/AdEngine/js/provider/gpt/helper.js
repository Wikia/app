/*global define, setTimeout, require*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.helper', [
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.provider.gpt.adDetect',
	'ext.wikia.adEngine.provider.gpt.adElement',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.recovery.helper',
	'ext.wikia.adEngine.slotTweaker',
	require.optional('ext.wikia.adEngine.provider.gpt.sraHelper'),
	require.optional('ext.wikia.adEngine.slot.scrollHandler')
], function (
	log,
	adContext,
	adLogicPageParams,
	adDetect,
	AdElement,
	GoogleTag,
	recoveryHelper,
	slotTweaker,
	sraHelper,
	scrollHandler
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.helper',
		googleApi = new GoogleTag(),
		hiddenSlots = [
			'INCONTENT_LEADERBOARD'
		],
		recoveryInitialized = false;

	function loadRecovery() {
		if (recoveryInitialized) {
			return;
		}
		log('SourcePoint recovery enabled', 'debug', logGroup);
		recoveryInitialized = true;
		googleApi = recoveryHelper.createSourcePointTag();
		recoveryHelper.recoverSlots();
	}

	function loadSourcePoint() {
		if (recoveryHelper.isBlocking()) {
			loadRecovery();
		} else {
			recoveryHelper.addOnBlockingCallback(function () {
				loadRecovery();
			});
		}
	}

	function collapseElement(element) {
		slotTweaker.hide(
			element.getSlotName(),
			recoveryHelper.isBlocking() && recoveryHelper.isRecoveryEnabled()
		);
	}

	function isHiddenOnStart(slotName) {
		return hiddenSlots.indexOf(slotName) !== -1;
	}

	/**
	 * Push ad to queue and flush if it should be
	 *
	 * @param {Object}   slot               - slot (ext.wikia.adEngine.slot.adSlot::create instance)
	 * @param {string}   slotPath           - slot path
	 * @param {Object}   slotTargeting      - slot targeting details
	 * @param {Object}   extra              - optional parameters
	 * @param {boolean}  extra.sraEnabled   - whether to use Single Request Architecture
	 * @param {string}   extra.forcedAdType - ad type for callbacks info
	 */
	function pushAd(slot, slotPath, slotTargeting, extra) {
		extra = extra || {};
		var count,
			element,
			recoverableSlots = extra.recoverableSlots || [],
			shouldPush = !recoveryHelper.isBlocking() ||
				(recoveryHelper.isBlocking() && recoveryHelper.isRecoverable(slot.name, recoverableSlots));

		slotTargeting = JSON.parse(JSON.stringify(slotTargeting)); // copy value

		if (isHiddenOnStart(slot.name)) {
			slotTweaker.hide(slot.name);
			slot.pre('success', function () {
				slotTweaker.show(slot.name);
			});
		}
		if (scrollHandler) {
			count = scrollHandler.getReloadedViewCount(slot.name);
			if (count !== null) {
				slotTargeting.rv = count.toString();
			}
		}

		element = new AdElement(slot.name, slotPath, slotTargeting);

		slot.pre('collapse', function () {
			collapseElement(element);
		});
		slot.pre('hop', function () {
			slotTweaker.hide(
				element.getSlotContainerId(),
				recoveryHelper.isBlocking() && recoveryHelper.isRecoveryEnabled()
			);
		});

		function queueAd() {
			log(['queueAd', slot.name, element], 'debug', logGroup);
			slot.container.appendChild(element.getNode());

			googleApi.addSlot(element);
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
			googleApi.onAdLoad(slot.name, element, gptEvent, onAdLoadCallback);
		}

		if (!googleApi.isInitialized()) {
			googleApi.init(loadSourcePoint);
			googleApi.setPageLevelParams(adLogicPageParams.getPageLevelParams());
		}

		if (!shouldPush) {
			log(['Push blocked', slot.name], 'debug', logGroup);
			slotTweaker.removeDefaultHeight(slot.name);
			return;
		}

		log(['pushAd', slot.name], 'info', logGroup);
		if (!slotTargeting.flushOnly) {
			googleApi.registerCallback(element.getId(), gptCallback);
			googleApi.push(queueAd);
		}

		if (!sraHelper || !extra.sraEnabled || sraHelper.shouldFlush(slot.name)) {
			log('flushing', 'debug', logGroup);
			googleApi.flush();
		}

		if (slotTargeting.flushOnly) {
			slot.success();
		}
	}

	adContext.addCallback(function () {
		if (googleApi.isInitialized()) {
			googleApi.setPageLevelParams(adLogicPageParams.getPageLevelParams());
		}
	});

	return {
		pushAd: pushAd
	};
});
