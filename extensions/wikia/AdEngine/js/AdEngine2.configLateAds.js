/**
 * This code constructs adConfig2Late for use with Liftium
 * and passes it to AdEngine using AdEngine_setLateConfig
 *
 * Liftium must call AdEngine_loadLateAds to trigger showing ads
 */

/*global DartUrl, ScriptWriter, AdLogicPageLevelParams, AdLogicPageLevelParamsLegacy, SlotTweaker, AdTracker*/
/*global AdProviderNull, AdProviderRemnantGpt, AdProviderLiftium, AdProviderGamePro, AdProviderSevenOneMedia, SevenOneMediaHelper*/
/*global AdConfig2Late, GptSlotConfig, WikiaGptHelper, Wikia, window, document, Geo, Krux, jQuery*/
/*jslint newcap:true*/
/*jshint maxparams:false, camelcase:false, maxlen: 150*/

(function (log, tracker, window, document, Geo, Krux, $) {
	'use strict';

	var adConfig,
		scriptWriter,
		adLogicPageLevelParams,
		adLogicPageLevelParamsLegacy,
		dartUrl,
		adTracker,
		slotTweaker,
		wikiaGptHelper,
		fakeLiftium = {},
		adProviderGamePro,
		adProviderRemantGpt,
		adProviderLiftium,
		adProviderNull,
		adProviderSevenOneMedia,
		gptSlotConfig,
		sevenOneMediaHelper;

	// TODO: make Liftium and AdEngine2 rely less on order of execution
	fakeLiftium.callInjectedIframeAd = function (sizeOrSlot, iframeElement, placement) {
		return window.Liftium.callInjectedIframeAd(sizeOrSlot, iframeElement, placement);
	};

	adTracker = AdTracker(log, tracker, window);
	dartUrl = DartUrl();
	scriptWriter = ScriptWriter(document, log, window);
	adLogicPageLevelParams = AdLogicPageLevelParams(log, window, Krux); // omitted a few optional deps
	adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(log, window, adLogicPageLevelParams, Krux, dartUrl);
	slotTweaker = SlotTweaker(log, document, window);
	gptSlotConfig = GptSlotConfig();
	wikiaGptHelper = WikiaGptHelper(log, window, document, adLogicPageLevelParams, gptSlotConfig);

	// TODO: ad provider error
	adProviderNull = AdProviderNull(log, slotTweaker);

	sevenOneMediaHelper = SevenOneMediaHelper(adLogicPageLevelParams, scriptWriter, log, window, $, tracker);
	adProviderSevenOneMedia = AdProviderSevenOneMedia(log, window, adTracker, $, sevenOneMediaHelper);
	adProviderGamePro = AdProviderGamePro(adLogicPageLevelParamsLegacy, scriptWriter, adTracker, log, window, slotTweaker);

	if (window.wgEnableRHonDesktop) {
		adProviderRemantGpt = AdProviderRemnantGpt(adTracker, log, slotTweaker, wikiaGptHelper, gptSlotConfig);
	} else {
		adProviderLiftium = AdProviderLiftium(log, document, slotTweaker, fakeLiftium, scriptWriter, window);
	}

	adConfig = AdConfig2Late(
		log,
		window,
		adProviderGamePro,
		window.wgEnableRHonDesktop ? adProviderRemantGpt : adProviderLiftium,
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

}(Wikia.log, Wikia.Tracker, window, document, Geo, Krux, jQuery));
