(function(log, WikiaTracker, window, ghostwriter, document, Geo, LazyQueue, Cookies, Cache, Krux) {
	var module = 'AdEngine2.run'
		, adConfig
		, adEngine
		, adLogicShortPage
		, scriptWriter
		, wikiaDart
		, evolveHelper
		, adProviderAdDriver2
		, adProviderEvolve
		, adProviderGamePro
		, adProviderLater
		, adProviderNull
		, slotTweaker

		, queueForLateAds
		, adConfigForLateAds
	;

	// Construct Ad Engine
	adEngine = AdEngine2(log, LazyQueue);

	// Construct various helpers
	adLogicShortPage = AdLogicShortPage(document);
	slotTweaker = SlotTweaker(log, document);
	scriptWriter = ScriptWriter(log, ghostwriter, document);
	wikiaDart = WikiaDartHelper(log, window, document, Geo, Krux, adLogicShortPage);
	evolveHelper = EvolveHelper(log, window);

	// Construct Ad Providers
	adProviderAdDriver2 = AdProviderAdDriver2(wikiaDart, scriptWriter, WikiaTracker, log, window, Geo, slotTweaker, Cache);
	adProviderEvolve = AdProviderEvolve(scriptWriter, WikiaTracker, log, window, document, Krux, evolveHelper, slotTweaker);
	adProviderGamePro = AdProviderGamePro(scriptWriter, WikiaTracker, log, window, document);
	adProviderNull = AdProviderNull(log, slotTweaker);

	// Special Ad Provider, to deal with the late ads
	queueForLateAds = [];
	adProviderLater = AdProviderLater(log, queueForLateAds);

	adConfig = AdConfig2(
		// regular dependencies:
		log, window, document, Geo, adLogicShortPage

		// AdProviders:
		, adProviderAdDriver2
		, adProviderEvolve
		, adProviderGamePro
		, adProviderLater
		, adProviderNull
	);

	log('work on window.adslots2 according to AdConfig2', 1, module);
	WikiaTracker.trackAdEvent('liftium.init', {'ga_category':'init2/init', 'ga_action':'init', 'ga_label':'adengine2'}, 'ga');
	window.adslots2 = window.adslots2 || [];
	adEngine.run(adConfig, window.adslots2);

	// DART API for Liftium
	window.LiftiumDART = {
		getUrl: function(slotname, slotsize, a, b) {
			return wikiaDart.getUrl({
				slotname: slotname,
				slotsize: slotsize,
				adType: 'adi',
				src: 'liftium'
			});
		}
	};

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

}(Wikia.log, WikiaTracker, window, ghostwriter, document, Geo, Wikia.LazyQueue, Wikia.Cookies, Wikia.Cache, Krux));
