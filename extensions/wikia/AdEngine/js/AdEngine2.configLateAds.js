/**
 * This code constructs adConfig2Late for use with Liftium
 * and passes it to AdEngine using AdEngine_setLateConfig
 *
 * Liftium must call AdEngine_loadLateAds to trigger showing ads
 */
(function(log, tracker, window, ghostwriter, document, Geo, Krux) {
	var adConfig
		, scriptWriter
		, adLogicPageLevelParams
		, adLogicPageLevelParamsLegacy
		, dartUrl
		, slotTweaker
		, fakeLiftium = {}
		, adProviderGamePro
		, adProviderLiftium2Dom
		, adProviderNull
	;

	// TODO: make Liftium and AdEngine2 rely less on order of execution
	fakeLiftium.callInjectedIframeAd = function(sizeOrSlot, iframeElement, placement) {
		return window.Liftium.callInjectedIframeAd(sizeOrSlot, iframeElement, placement);
	};

	dartUrl = DartUrl();
	scriptWriter = ScriptWriter(log, ghostwriter, document);
	adLogicPageLevelParams = AdLogicPageLevelParams(log, window, Krux /* omiting a few optional deps */);
	adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(log, window, adLogicPageLevelParams, Krux, dartUrl);
	slotTweaker = SlotTweaker(log, document, window);

	// TODO: ad provider error
	adProviderNull = AdProviderNull(log, slotTweaker);

	adProviderGamePro = AdProviderGamePro(adLogicPageLevelParamsLegacy, scriptWriter, tracker, log, window, slotTweaker);
	adProviderLiftium2Dom = AdProviderLiftium2Dom(tracker, log, document, slotTweaker, fakeLiftium, scriptWriter, window);

	adConfig = AdConfig2Late(
		log, window

		// AdProviders:
		, adProviderGamePro
		, adProviderLiftium2Dom
		, adProviderNull
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

}(Wikia.log, Wikia.Tracker, window, ghostwriter, document, Geo, Krux));
