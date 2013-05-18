/*
 * This file is used as initializer for ad-related modules and dependency injector.
 * Once AMD is available, this file will be almost no longer needed.
 */

/*global document, window */
/*global Geo, Wikia */
/*global ghostwriter, Krux */
/*global AdConfig2, AdEngine2, DartUrl, EvolveHelper, SlotTweaker, ScriptWriter */
/*global WikiaDartHelper, WikiaGptHelper */
/*global AdProviderAdDriver2, AdProviderEvolve, AdProviderGamePro, AdProviderLater, AdProviderNull */
/*global AdLogicDartSubdomain, AdLogicHighValueCountry, AdLogicShortPage, AdLogicPageLevelParams */
/*global AdLogicPageLevelParamsLegacy */
/*jslint newcap:true */

(function (log, tracker, window, ghostwriter, document, Geo, LazyQueue, Cookies, Cache, Krux, abTest) {
	'use strict';

	var module = 'AdEngine2.run',
		adConfig,
		adEngine,
		adLogicDartSubdomain,
		adLogicHighValueCountry,
		adLogicPageLevelParams,
		adLogicPageLevelParamsLegacy,
		adLogicShortPage,
		scriptWriter,
		dartUrl,
		wikiaDart,
		wikiaGpt,
		evolveHelper,
		adProviderAdDriver2,
		adProviderEvolve,
		adProviderGamePro,
		adProviderLater,
		adProviderNull,
		slotTweaker,

		queueForLateAds,
		adConfigForLateAds;

	// Construct Ad Engine
	adEngine = AdEngine2(log, LazyQueue);

	// Construct various helpers
	dartUrl = DartUrl();
	adLogicDartSubdomain = AdLogicDartSubdomain(Geo);
	adLogicHighValueCountry = AdLogicHighValueCountry(window);
	adLogicShortPage = AdLogicShortPage(document);
	adLogicPageLevelParams = AdLogicPageLevelParams(log, window, Krux, adLogicShortPage, abTest);
	adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(log, window, adLogicPageLevelParams, Krux, dartUrl);
	slotTweaker = SlotTweaker(log, document, window);
	scriptWriter = ScriptWriter(log, ghostwriter, document);
	wikiaDart = WikiaDartHelper(log, adLogicPageLevelParams, dartUrl, adLogicDartSubdomain);
	wikiaGpt = WikiaGptHelper(log, window, document, adLogicPageLevelParams);
	evolveHelper = EvolveHelper(log, window);

	// Construct Ad Providers
	adProviderAdDriver2 = AdProviderAdDriver2(wikiaDart, scriptWriter, tracker, log, window, Geo, slotTweaker, Cache, adLogicHighValueCountry, adLogicDartSubdomain, abTest, wikiaGpt, document);
	adProviderEvolve = AdProviderEvolve(adLogicPageLevelParamsLegacy, scriptWriter, tracker, log, window, document, Krux, evolveHelper, slotTweaker);
	adProviderGamePro = AdProviderGamePro(adLogicPageLevelParamsLegacy, scriptWriter, tracker, log, window, slotTweaker);
	adProviderNull = AdProviderNull(log, slotTweaker);

	// Special Ad Provider, to deal with the late ads
	queueForLateAds = [];
	adProviderLater = AdProviderLater(log, queueForLateAds);

	adConfig = AdConfig2(
		// regular dependencies:
		log,
		window,
		document,
		Geo,
		adLogicShortPage,
		abTest,

		// AdProviders:
		adProviderAdDriver2,
		adProviderEvolve,
		adProviderGamePro,
		adProviderLater,
		adProviderNull
	);

	window.wgAfterContentAndJS.push(function () {
		log('work on window.adslots2 according to AdConfig2', 1, module);
		tracker.track({
			eventName: 'liftium.init',
			ga_category: 'init2/init',
			ga_action: 'init',
			ga_label: 'adengine2',
			trackingMethod: 'ad'
		});
		window.adslots2 = window.adslots2 || [];
		adEngine.run(adConfig, window.adslots2);
	});

	// DART API for Liftium
	window.LiftiumDART = {
		getUrl: function (slotname, slotsize, a, b) {
			return wikiaDart.getUrl({
				slotname: slotname,
				slotsize: slotsize,
				adType: 'adi',
				src: 'liftium'
			});
		}
	};

	// Register Evolve hop
	window.evolve_hop = function (slotname) {
		adProviderEvolve.hop(slotname);
	};

	/*
	 * TODO this is the right approach but it does compete with AdDriver (refactor to AdEngine2Controller?)
	 * window.LiftiumOptions = window.LiftiumOptions || {};
	 * window.LiftiumOptions.autoInit = false;
	 */

	// Set late run config
	window.AdEngine_setLateAdsConfig = function (adConfig) {
		adConfigForLateAds = adConfig;
	};

	// Load late ads now (you need to call AdEngine_setLateConfig first!)
	window.AdEngine_loadLateAds = function () {
		if (adConfigForLateAds) {
			log('launching late ads now', 1, module);
			log('work on queueForLateAds according to AdConfig2Late', 1, module);
			tracker.track({
				eventName: 'liftium.init',
				ga_category: 'init2/init',
				ga_action: 'init',
				ga_label: 'adengine2 late',
				trackingMethod: 'ad'
			});
			adEngine.run(adConfigForLateAds, queueForLateAds);
		} else {
			log('ERROR, AdEngine_loadLateAds called before AdEngine_setLateConfig!', 1, module);
			tracker.track({
				eventName: 'liftium.errors',
				ga_category: 'errors2/no_late_config',
				ga_action: 'no_late_config',
				ga_label: 'adengine2 late',
				trackingMethod: 'ad'
			});
		}
	};

	// Load Krux asynchronously later
	// If you call AdEngine_loadKruxLater(Krux) at the end of the HTML Krux
	// or on DOM ready, it will be loaded after most (if not all) of the ads
	window.AdEngine_loadKruxLater = function (Krux) {
		if (window.wgAdsShowableOnPage) {
			scriptWriter.callLater(function () {
				log('Loading Krux code', 8, module);
				Krux.load(window.wgKruxCategoryId);
			});
		}
	};

	// Register window.wikiaDartHelper so jwplayer can use it
	window.wikiaDartHelper = wikiaDart;

}(Wikia.log, Wikia.Tracker, window, ghostwriter, document, Geo, Wikia.LazyQueue, Wikia.Cookies, Wikia.Cache, Krux, Wikia.AbTest));
