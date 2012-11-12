/**
 * This code constructs adConfig2Late for use with Liftium
 * and passes it to AdEngine using AdEngine_setLateConfig
 *
 * Liftium must call AdEngine_loadLateAds to trigger showing ads
 */
(function(log, WikiaTracker, window, ghostwriter, document) {
	var adConfig
		, scriptWriter
		, wikiaDart
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

	scriptWriter = ScriptWriter(log, ghostwriter, document);
	wikiaDart = WikiaDartHelper(log, window, document, /* Geo */ null, /* Krux */ null); // TODO FIXME Geo and Krux are not needed for GamePro
	slotTweaker = SlotTweaker(log, document);

	// TODO: ad provider error
	adProviderNull = AdProviderNull(log, slotTweaker);

	adProviderGamePro = AdProviderGamePro(wikiaDart, scriptWriter, WikiaTracker, log, window, document);
	adProviderLiftium2Dom = AdProviderLiftium2Dom(WikiaTracker, log, document, slotTweaker, fakeLiftium, scriptWriter);

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

}(Wikia.log, WikiaTracker, window, ghostwriter, document));
