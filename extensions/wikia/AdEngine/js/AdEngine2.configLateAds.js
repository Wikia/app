/**
 * This code constructs adConfig2Late for use with Liftium
 * and passes it to AdEngine using AdEngine_setLateConfig
 *
 * Liftium must call AdEngine_loadLateAds to trigger showing ads
 */

/*global DartUrl, ScriptWriter, AdLogicPageLevelParams, AdLogicPageLevelParamsLegacy, SlotTweaker*/
/*global AdProviderNull, AdProviderLiftium2Dom, AdProviderGamePro, AdProviderSevenOneMedia, SevenOneMediaHelper*/
/*global AdConfig2Late, Wikia, window, document, Geo, Krux, jQuery*/
/*jslint newcap: true*/

(function (log, tracker, window, document, Geo, Krux, $) {
	'use strict';

	var adConfig,
		scriptWriter,
		adLogicPageLevelParams,
		adLogicPageLevelParamsLegacy,
		dartUrl,
		slotTweaker,
		fakeLiftium = {},
		adProviderGamePro,
		adProviderLiftium2Dom,
		adProviderNull,
		adProviderSevenOneMedia,
		sevenOneMediaHelper;

	// TODO: make Liftium and AdEngine2 rely less on order of execution
	fakeLiftium.callInjectedIframeAd = function (sizeOrSlot, iframeElement, placement) {
		return window.Liftium.callInjectedIframeAd(sizeOrSlot, iframeElement, placement);
	};

	dartUrl = DartUrl();
	scriptWriter = ScriptWriter(document, log, window);
	adLogicPageLevelParams = AdLogicPageLevelParams(log, window, Krux); // omitted a few optional deps
	adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(log, window, adLogicPageLevelParams, Krux, dartUrl);
	slotTweaker = SlotTweaker(log, document, window);

	// TODO: ad provider error
	adProviderNull = AdProviderNull(log, slotTweaker);

	sevenOneMediaHelper = SevenOneMediaHelper(adLogicPageLevelParams, scriptWriter, log, window, $, tracker);
	adProviderSevenOneMedia = AdProviderSevenOneMedia(log, window, tracker, $, sevenOneMediaHelper);
	adProviderGamePro = AdProviderGamePro(adLogicPageLevelParamsLegacy, scriptWriter, tracker, log, window, slotTweaker);
	adProviderLiftium2Dom = AdProviderLiftium2Dom(tracker, log, document, slotTweaker, fakeLiftium, scriptWriter, window);

	adConfig = AdConfig2Late(
		log,
		window,
		adProviderGamePro,
		adProviderLiftium2Dom,
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
