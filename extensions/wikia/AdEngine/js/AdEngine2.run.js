(function(log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue) {
	var adConfig
		, adEngine
		, adProviderEvolve
		, adProviderEvolveRS
		, adProviderGamePro
		, adProviderAdDriver2
		, adProviderAdDriver
		, adProviderLiftium2
		, adSlotsQueue
		, lazyQueue = LazyQueue();

	adProviderGamePro = AdProviderGamePro(WikiaTracker, log, window, ghostwriter, document);
	adProviderEvolve = AdProviderEvolve(WikiaTracker, log, window, ghostwriter, document);
	adProviderEvolveRS = AdProviderEvolveRS(WikiaTracker, log, window, ghostwriter, document, Geo);
	adProviderAdDriver2 = AdProviderAdDriver2(log, window);
	adProviderAdDriver = AdProviderAdDriver(log, window);
	adProviderLiftium2 = AdProviderLiftium2(WikiaTracker, log, window, ghostwriter, document);

	adConfig = AdConfig2(
		// regular dependencies:
		Wikia.log, window, Geo,

		// AdProviders:
		adProviderGamePro,
		adProviderEvolve,
		adProviderEvolveRS,
		adProviderAdDriver2,
		adProviderAdDriver,
		adProviderLiftium2
	);

	adEngine = AdEngine2(adConfig, log, lazyQueue);

	// Make sure the adslots2 is defined
	window.adslots2 = window.adslots2 || [];

	// Show ads now :-)
	adEngine.run(window.adslots2);

	window.evolve_hop = function(slotname) {
		adProviderEvolve.hop(slotname);
	};

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue));
