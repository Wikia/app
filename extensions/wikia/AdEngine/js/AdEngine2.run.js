(function(log, WikiaTracker, window, ghostwriter, document) {
	var adConfig
		, adEngine
		, adProviderEvolve
		, adProviderGamePro
		, adProviderAdDriver2;

	adProviderGamePro = AdProviderGamePro(WikiaTracker, log, window, ghostwriter, document);
	adProviderEvolve = AdProviderEvolve(WikiaTracker, log, window, ghostwriter, document);
	adProviderAdDriver2 = AdProviderAdDriver2(log, window);

	adConfig = AdConfig2(
		// regular dependencies:
		Wikia.log, Wikia, window,

		// AdProviders:
		adProviderGamePro,
		adProviderEvolve,
		adProviderAdDriver2
	);

	adEngine = AdEngine2(adConfig, log, window);

	adEngine.run();
}(Wikia.log, WikiaTracker, window, ghostwriter, document));
