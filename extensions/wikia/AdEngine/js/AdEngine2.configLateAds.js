/**
 * This code constructs adConfig2Late for use with Liftium
 * and passes it to AdEngine using AdEngine_setLateConfig
 *
 * Liftium must call AdEngine_loadLateAds to trigger showing ads
 */
(function(log, WikiaTracker, window, ghostwriter, document, Geo, Cookies) {
	var adConfig
		, scriptWriter
		, wikiaDart
		, adProviderAdDriver2
		, adProviderAdDriver2Helper
		, adProviderGamePro
		, adProviderLiftium2
		, adProviderLiftium2Dom
		, slotTweaker
		, adProviderNull
	;

	scriptWriter = ScriptWriter(log, ghostwriter, document);
	slotTweaker = SlotTweaker(log, document);

	// TODO: ad provider error
	adProviderNull = AdProviderNull(log, slotTweaker);

	wikiaDart = WikiaDartHelper(log, window, document, Geo);

	adProviderAdDriver2Helper = AdProviderAdDriver2Helper(log, window, Cookies);
	adProviderAdDriver2 = AdProviderAdDriver2(adProviderAdDriver2Helper, wikiaDart, scriptWriter, WikiaTracker, log, window, Geo);
	adProviderGamePro = AdProviderGamePro(scriptWriter, WikiaTracker, log, window, document);
	adProviderLiftium2 = AdProviderLiftium2(scriptWriter, WikiaTracker, log, window);
	adProviderLiftium2Dom = AdProviderLiftium2Dom(WikiaTracker, log, document);

	adConfig = AdConfig2Late(
		log, window

		// AdProviders:
		, adProviderAdDriver2
		, adProviderGamePro
		, adProviderLiftium2
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

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo, Wikia.Cookies));
