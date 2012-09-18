(function(log, WikiaTracker, window, ghostwriter, document, LazyQueue) {
	var adConfig
		, adEngine
		, adProviderAdDriver
		, adProviderLiftium2
		, adSlotsQueue
		, lazyQueue = LazyQueue();

	adProviderAdDriver = AdProviderAdDriver(log, window);
	adProviderLiftium2 = AdProviderLiftium2(WikiaTracker, log, window, ghostwriter, document);

	adConfig = AdConfig2_later(
		// regular dependencies:
		Wikia.log, window,

		// AdProviders:
		adProviderAdDriver,
		adProviderLiftium2
	);

	adEngine = AdEngine2(adConfig, log, lazyQueue);

	log('work on window.adslots2_later according to AdConfig2_later', 1, 'AdEngine2');
	window.adslots2_later = window.adslots2_later || [];
	adEngine.run(window.adslots2_later);

}(Wikia.log, WikiaTracker, window, ghostwriter, document, LazyQueue));
