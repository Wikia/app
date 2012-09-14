(function(log, WikiaTracker, window, ghostwriter, document, geo) {
	var adConfig
		, adEngine
		, adProviderEvolve
		, adProviderEvolveRS
		, adProviderGamePro
		, adProviderAdDriver2
		, adProviderAdDriver
		, adProviderLiftium2;

	adProviderGamePro = AdProviderGamePro(WikiaTracker, log, window, ghostwriter, document);
	adProviderEvolve = AdProviderEvolve(WikiaTracker, log, window, ghostwriter, document, geo);
	adProviderEvolveRS = AdProviderEvolveRS(WikiaTracker, log, window, ghostwriter, document, geo);
	adProviderAdDriver2 = AdProviderAdDriver2(log, window);
	adProviderAdDriver = AdProviderAdDriver(log, window);
	adProviderLiftium2 = AdProviderLiftium2(WikiaTracker, log, window, ghostwriter, document);

	adConfig = AdConfig2(
		// regular dependencies:
		Wikia.log, Wikia, window,

		// AdProviders:
		adProviderGamePro,
		adProviderEvolve,
		adProviderEvolveRS,
		adProviderAdDriver2,
		adProviderAdDriver,
		adProviderLiftium2
	);

	adEngine = AdEngine2(adConfig, log, window);

	adEngine.run();

	window.evolve_hop = function(slotname) {
		adProviderEvolve.hop(slotname);
	};

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo));
