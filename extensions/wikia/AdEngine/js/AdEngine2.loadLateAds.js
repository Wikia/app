(function(log, WikiaTracker, window, ghostwriter, document) {
	var adConfig
		, scriptWriter
		, adProviderAdDriver
		, adProviderLiftium2;

	scriptWriter = ScriptWriter(log, ghostwriter, document);
	adProviderAdDriver = AdProviderAdDriver(log, window);
	adProviderLiftium2 = AdProviderLiftium2(scriptWriter, WikiaTracker, log, window);

	adConfig = AdConfigLate2(
		log,
		// AdProviders:
		adProviderAdDriver,
		adProviderLiftium2
	);

	/*
	 * TODO: this is the right approach but it does compete with AdDriver:
	 *
	 * Liftium.init(function() {
	 *   window.AdEngine_loadLateAdsNow(adConfig);
	 * });
	 *
	 * END OF TODO
	 */
	window.AdEngine_loadLateAds(adConfig);

}(Wikia.log, WikiaTracker, window, ghostwriter, document));
