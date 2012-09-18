(function(log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue) {
	var adConfig
		, adEngine
		, adProviderEvolve
		, adProviderEvolveRS
		, adProviderGamePro
		, adProviderAdDriver2
		, adProviderLater
		, adSlotsQueue
		, lazyQueue = LazyQueue();

	adProviderGamePro = AdProviderGamePro(WikiaTracker, log, window, ghostwriter, document);
	adProviderEvolve = AdProviderEvolve(WikiaTracker, log, window, ghostwriter, document);
	adProviderEvolveRS = AdProviderEvolveRS(WikiaTracker, log, window, ghostwriter, document, Geo);
	adProviderAdDriver2 = AdProviderAdDriver2(log, window);

	window.adslots2_later = window.adslots2_later || [];
	adProviderLater = AdProviderLater(log, window.adslots2_later);

	adConfig = AdConfig2(
		// regular dependencies:
		Wikia.log, window, Geo,

		// AdProviders:
		adProviderGamePro,
		adProviderEvolve,
		adProviderEvolveRS,
		adProviderAdDriver2,
		adProviderLater
	);

	adEngine = AdEngine2(adConfig, log, lazyQueue);

	log('work on window.adslots2 according to AdConfig2', 1, 'AdEngine2');
	window.adslots2 = window.adslots2 || [];
	adEngine.run(window.adslots2);

	window.evolve_hop = function(slotname) {
		adProviderEvolve.hop(slotname);
	};

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue));
