(function() {
	var adConfig = AdConfig2(
		// regular dependencies:
		Wikia.log, Wikia, window,

		// AdProviders:
		AdProviderGamePro,
		AdProviderEvolve,
		AdProviderAdDriver2
	);

	AdEngine2(adConfig, Wikia.log, window).run();
}());
