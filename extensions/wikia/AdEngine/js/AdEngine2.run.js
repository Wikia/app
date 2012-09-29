(function(log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue, Cookies) {
	var module = 'AdEngine2.run'
		, adConfig
		, adEngine
		, scriptWriter
		, adProviderAdDriver
		, adProviderAdDriver2
		, adProviderEvolve
		, adProviderEvolveRS
		, adProviderGamePro
		, adProviderLater
		, adProviderNull
		, adSlotsQueue
		, lazyQueue = LazyQueue()

		, queueForLateAds
		, adConfigForLateAds;

	// Construct Ad Engine
	adEngine = AdEngine2(log, lazyQueue);

	// Construct Ad Providers
	scriptWriter = ScriptWriter(log, ghostwriter, document);

	adProviderAdDriver = AdProviderAdDriver(log, window);
	adProviderAdDriver2 = AdProviderAdDriver2(scriptWriter, WikiaTracker, log, window, document, Cookies, Geo);
	adProviderEvolve = AdProviderEvolve(scriptWriter, WikiaTracker, log, window, document);
	adProviderEvolveRS = AdProviderEvolveRS(scriptWriter, WikiaTracker, log, window, document);
	adProviderGamePro = AdProviderGamePro(scriptWriter, WikiaTracker, log, window, document);
	adProviderNull = AdProviderNull(log);

	// Special Ad Provider, to deal with the late ads
	queueForLateAds = [];
	adProviderLater = AdProviderLater(log, queueForLateAds);

	adConfig = AdConfig2(
		// regular dependencies:
		log, window, document, Geo

		// AdProviders:
		, adProviderAdDriver
		, adProviderAdDriver2
		, adProviderEvolve
		, adProviderEvolveRS
		, adProviderGamePro
		, adProviderLater
		, adProviderNull
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

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue, Wikia.Cookies));
