(function(log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue, Cookies, Krux) {
	var module = 'AdEngine2.run'
		, adConfig
		, adEngine
		, scriptWriter
		, wikiaDart
		, evolveHelper
		, expiringStorage
		, adProviderAdDriver
		, adProviderAdDriver2
		, adProviderEvolve
		, adProviderEvolveRS
		, adProviderGamePro
		, adProviderLater
		, adProviderNull
		, slotTweaker

		, queueForLateAds
		, adConfigForLateAds
	;

	// Construct Ad Engine
	adEngine = AdEngine2(log, LazyQueue);

	// Construct Ad Providers
	slotTweaker = SlotTweaker(log, document);
	scriptWriter = ScriptWriter(log, ghostwriter, document);
	wikiaDart = WikiaDartHelper(log, window, document, Geo, Krux);
	evolveHelper = EvolveHelper(log, window);
	expiringStorage = ExpiringStorage(log, JSON);

	adProviderAdDriver2 = AdProviderAdDriver2(wikiaDart, scriptWriter, WikiaTracker, log, window, Geo, slotTweaker, expiringStorage);
	adProviderEvolve = AdProviderEvolve(scriptWriter, WikiaTracker, log, window, document, Krux, evolveHelper, slotTweaker);
	adProviderEvolveRS = AdProviderEvolveRS(scriptWriter, WikiaTracker, log, window, document, evolveHelper);
	adProviderGamePro = AdProviderGamePro(scriptWriter, WikiaTracker, log, window, document);
	adProviderNull = AdProviderNull(log, slotTweaker);

	// Special Ad Provider, to deal with the late ads
	queueForLateAds = [];
	adProviderLater = AdProviderLater(log, queueForLateAds);

	adConfig = AdConfig2(
		// regular dependencies:
		log, window, document, Geo

		// AdProviders:
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
			adEngine.run(adConfigForLateAds, queueForLateAds);
		} else {
			log('ERROR, AdEngine_loadLateAds called before AdEngine_setLateConfig!', 1, module);
			WikiaTracker.trackAdEvent('liftium.errors', {'ga_category':'errors2/no_late_config', 'ga_action':'no_late_config', 'ga_label':'adengine2 late'}, 'ga');
		}
	};

	// Load Krux asynchronously later
	// If you call AdEngine_loadKruxLater(Krux) at the end of the HTML Krux
	// or on DOM ready, it will be loaded after most (if not all) of the ads
	window.AdEngine_loadKruxLater = function(Krux) {
		if (window.wgAdsShowableOnPage) {
			scriptWriter.callLater(function() {
				log('Loading Krux code', 8, module);
				Krux.load(window.wgKruxCategoryId);
			});
		}
	};

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo, Wikia.LazyQueue, Wikia.Cookies, Krux));
