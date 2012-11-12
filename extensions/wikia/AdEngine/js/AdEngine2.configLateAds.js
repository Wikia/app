/**
 * This code constructs adConfig2Late for use with Liftium
 * and passes it to AdEngine using AdEngine_setLateConfig
 *
 * Liftium must call AdEngine_loadLateAds to trigger showing ads
 */
(function(log, WikiaTracker, window, ghostwriter, document) {
	var adConfig
		, scriptWriter
		, slotTweaker
		, fakeLiftium = {}
		, adProviderGamePro
		, adProviderLiftium2Dom
		, adProviderNull
	;

	// TODO: make Liftium and AdEngine2 less reliable on order of execution
	fakeLiftium.callInjectedIframeAd = function(sizeOrSlot, iframeElement, placement) {
		return window.Liftium.callInjectedIframeAd(sizeOrSlot, iframeElement, placement);
	};

	scriptWriter = ScriptWriter(log, ghostwriter, document);
	slotTweaker = SlotTweaker(log, document);

	// TODO: ad provider error
	adProviderNull = AdProviderNull(log, slotTweaker);

	adProviderGamePro = AdProviderGamePro(scriptWriter, WikiaTracker, log, window, document);
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
