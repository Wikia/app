/**
 * This code constructs adConfig2Late for use with Liftium
 * and passes it to AdEngine using AdEngine_setLateConfig
 *
 * Liftium must call AdEngine_loadLateAds to trigger showing ads
 */

/*global DartUrl, ScriptWriter, AdLogicPageLevelParams, SlotTweaker*/
/*global AdProviderNull, AdProviderRemnantGpt, AdProviderLiftium, AdProviderSevenOneMedia, SevenOneMediaHelper*/
/*global AdConfig2Late, GptSlotConfig, WikiaGptHelper, Wikia, window, document, Geo, Krux, jQuery*/
/*jslint newcap:true*/
/*jshint maxparams:false, camelcase:false, maxlen: 150*/

(function (log, tracker, window, document, Geo, Krux, $, abTest) {
	'use strict';

	var adConfig,
		scriptWriter,
		adLogicPageLevelParams,
		slotTweaker,
		wikiaFullGpt,
		fakeLiftium = {},
		adProviderRemnantGpt,
		adProviderLiftium,
		adProviderNull,
		adProviderSevenOneMedia,
		gptSlotConfig,
		sevenOneMediaHelper;

	// TODO: make Liftium and AdEngine2 rely less on order of execution
	fakeLiftium.callInjectedIframeAd = function (sizeOrSlot, iframeElement, placement) {
		return window.Liftium.callInjectedIframeAd(sizeOrSlot, iframeElement, placement);
	};

	scriptWriter = ScriptWriter(document, log, window);
	adLogicPageLevelParams = AdLogicPageLevelParams(log, window, Krux); // omitted a few optional deps
	slotTweaker = SlotTweaker(log, document, window);
	gptSlotConfig = GptSlotConfig();
	wikiaFullGpt = WikiaGptHelper(log, window, document, adLogicPageLevelParams, gptSlotConfig);

	// TODO: ad provider error
	adProviderNull = AdProviderNull(log, slotTweaker);

	sevenOneMediaHelper = SevenOneMediaHelper(adLogicPageLevelParams, scriptWriter, log, window, $, tracker);
	adProviderSevenOneMedia = AdProviderSevenOneMedia(log, window, $, sevenOneMediaHelper);

	if (window.wgEnableRHonDesktop) {
		adProviderRemnantGpt = AdProviderRemnantGpt(adTracker, log, slotTweaker, wikiaFullGpt, gptSlotConfig);
	} else {
		adProviderLiftium = AdProviderLiftium(log, document, slotTweaker, fakeLiftium, scriptWriter, window);
	}

	adConfig = AdConfig2Late(
		log,
		window,
		abTest,
		window.wgEnableRHonDesktop ? adProviderRemnantGpt : adProviderLiftium,
		adProviderNull,
		adProviderSevenOneMedia
	);

	/*
	 * TODO: this is the right approach but it does compete with AdDriver:
	 *
	 * Liftium.init(function() {
	 *   window.AdEngine_loadLateAdsNow(adConfig);
	 * });
	 *
	 * (And remove AdEngine_setLateConfig)
	 *
	 * END OF TODO
	 */
	window.AdEngine_setLateAdsConfig(adConfig);

}(Wikia.log, Wikia.Tracker, window, document, Geo, Krux, jQuery, Wikia.AbTest));
