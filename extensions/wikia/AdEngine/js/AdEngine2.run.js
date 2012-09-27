(function(log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue) {
	var module = 'AdEngine2.run'
		, adConfig
		, adEngine
		, scriptWriter
		, adProviderNull
		, adProviderEvolve
		, adProviderEvolveRS
		, adProviderGamePro
		, adProviderAdDriver2
		, adProviderAdDriver
		, adProviderLater
		, adSlotsQueue
		, lazyQueue = LazyQueue()

		, queueForLateAds
		, adConfigForLateAds;

	// Construct Ad Engine
	adEngine = AdEngine2(log, lazyQueue);

	// Construct Ad Providers
	scriptWriter = ScriptWriter(log, ghostwriter, document);
	adProviderNull = AdProviderNull(log);
	adProviderGamePro = AdProviderGamePro(scriptWriter, WikiaTracker, log, window, document);
	adProviderEvolve = AdProviderEvolve(scriptWriter, WikiaTracker, log, window, document);
	adProviderEvolveRS = AdProviderEvolveRS(scriptWriter, WikiaTracker, log, window, document, Geo);
	adProviderAdDriver2 = AdProviderAdDriver2(log, window);
	adProviderAdDriver = AdProviderAdDriver(log, window);

	// Special Ad Provider, to deal with the ads Late
	queueForLateAds = [];
	adProviderLater = AdProviderLater(log, queueForLateAds);

	adConfig = AdConfig2(
		// regular dependencies:
		log, window, document, Geo,

		// AdProviders:
		adProviderNull,
		adProviderGamePro,
		adProviderEvolve,
		adProviderEvolveRS,
		adProviderAdDriver2,
		adProviderAdDriver,
		adProviderLater
	);

	log('work on window.adslots2 according to AdConfig2', 1, module);
	WikiaTracker.trackAdEvent('liftium.init', {'ga_category':'init2/init', 'ga_action':'init', 'ga_label':'adengine2'}, 'ga');
	window.adslots2 = window.adslots2 || [];
	adEngine.run(adConfig, window.adslots2);

	// Register Evolve hop
	window.evolve_hop = function(slotname) {
		adProviderEvolve.hop(slotname);
	};

	/*
	 * TODO this is the right approach but it does compete with AdDriver (refactor to AdEngine2Controller?)
	 * window.LiftiumOptions = window.LiftiumOptions || {};
	 * window.LiftiumOptions.autoInit = false;
	 */

	// Set late run config
	window.AdEngine_setLateAdsConfig = function(adConfig) {
		adConfigForLateAds = adConfig;
	};

	// Load late ads now (you need to call AdEngine_setLateConfig first!)
	window.AdEngine_loadLateAds = function() {
		if (adConfigForLateAds) {
			log('launching late ads now', 1, module);
			log('work on queueForLateAds according to AdConfig2Late', 1, module);
			WikiaTracker.trackAdEvent('liftium.init', {'ga_category':'init2/init', 'ga_action':'init', 'ga_label':'adengine2 late'}, 'ga');
			adEngine.run(adConfigForLateAds, queueForLateAds)
		} else {
			log('ERROR, AdEngine_loadLateAds called before AdEngine_setLateConfig!', 1, module);
			WikiaTracker.trackAdEvent('liftium.errors', {'ga_category':'errors2/no_late_config', 'ga_action':'no_late_config', 'ga_label':'adengine2 late'}, 'ga');
		}
	};

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue));
