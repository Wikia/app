<?php

$VenusConfig = [];

$VenusConfig['venus_body_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/scripts/Venus.js',
		'//resources/wikia/modules/tracker.stub.js',
		'//resources/wikia/modules/tracker.js',

		//TODO evaluate if we really need it. It would be possible when we clean up VenusController
		'//resources/wikia/modules/window.js',
		'//resources/wikia/modules/document.js',
		'//resources/wikia/modules/location.js',
		'//resources/wikia/modules/localStorage.js',
		'//resources/wikia/modules/querystring.js',
		'//resources/wikia/modules/cookies.js',
		//depends on querystring.js and cookies.js
		'//resources/wikia/modules/log.js',
		'//resources/wikia/modules/abTest.js',
		'//resources/wikia/modules/geo.js',

		//TODO following groups should be removed from here and moved to extensions
		'#adengine2_js',
		'#adengine2_late_js',
		'#liftium_ads_js'
	]
];

$VenusConfig['venus_head_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/AnalyticsEngine/js/analytics_prod.js',
		'//extensions/wikia/Optimizely/scripts/OptimizelyBlocking.js'
	]
];

$VenusConfig['venus_css'] = [
	'type' => AssetsManager::TYPE_SCSS,
	'skin' => 'venus',
	'assets' => [
		'//extensions/wikia/Venus/styles/Venus.scss'
	]
];

//TODO all groups below should be moved to dedicated extensions when Venus hook is ready
$VenusConfig['adengine2_js'] = [
	'type' => AssetsManager::TYPE_JS,
	'skin' => 'venus',
	'assets' => [
		'//resources/wikia/modules/scriptwriter.js',
		'//extensions/wikia/AdEngine/js/Krux.js',
		'//extensions/wikia/AdEngine/js/SlotTweaker.js',
		'//extensions/wikia/AdEngine/js/AdEngine2.js',
		'//extensions/wikia/AdEngine/js/SlotTracker.js',
		'//extensions/wikia/AdEngine/js/LateAdsQueue.js',
		'//extensions/wikia/AdEngine/js/MessageListener.js',

		// high prio
		'//extensions/wikia/AdEngine/js/EventDispatcher.js',
		'//extensions/wikia/AdEngine/js/GptSlotConfig.js',
		'//extensions/wikia/AdEngine/js/EvolveSlotConfig.js',
		'//extensions/wikia/AdEngine/js/DartUrl.js',
		'//extensions/wikia/AdEngine/js/WikiaAdHelper.js',
		'//extensions/wikia/AdEngine/js/WikiaDartHelper.js',
		'//extensions/wikia/AdEngine/js/WikiaGptHelper.js',
		'//extensions/wikia/AdEngine/js/WikiaGptAdDetect.js',
		'//extensions/wikia/AdEngine/js/AdProviderDirectGpt.js',
		'//extensions/wikia/AdEngine/js/AdProviderEbay.js',
		'//extensions/wikia/AdEngine/js/AdProviderLater.js',
		'//extensions/wikia/AdEngine/js/AdProviderNull.js',
		'//extensions/wikia/AdEngine/js/AdProviderRemnantGpt.js',
		'//extensions/wikia/AdEngine/js/AdTemplateSkin.js',
		'//extensions/wikia/AdEngine/js/AdLogicDartSubdomain.js',
		'//extensions/wikia/AdEngine/js/AdLogicHighValueCountry.js',
		'//extensions/wikia/AdEngine/js/AdLogicPageParams.js',
		'//extensions/wikia/AdEngine/js/AdLogicPageDimensions.js',
		'//extensions/wikia/AdEngine/js/AdDecoratorPageDimensions.js',
		'//extensions/wikia/AdEngine/js/AdConfig2.js',
		'//extensions/wikia/AdEngine/js/AdEngine2.run.js',
	]
];

$VenusConfig['adengine2_late_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		// ads
		'//extensions/wikia/AdEngine/AdProviderOpenX.js',
		'//extensions/wikia/AdEngine/LazyLoadAds.js',
		'//extensions/wikia/AdEngine/js/AdLogicPageParamsLegacy.js',
		'//extensions/wikia/AdEngine/js/AdProviderEvolve.js',
		'//extensions/wikia/AdEngine/js/AdProviderLiftium.js',
		'//extensions/wikia/AdEngine/js/AdProviderSevenOneMedia.js',
		'//extensions/wikia/AdEngine/js/AdConfig2Late.js',
		'//extensions/wikia/AdEngine/js/EvolveHelper.js',
		'//extensions/wikia/AdEngine/js/OoyalaTracking.js',
		'//extensions/wikia/AdEngine/js/SevenOneMediaHelper.js',
		'//extensions/wikia/AdEngine/js/WikiaDartVideoHelper.js',
		// Needs to load after Krux.js, jQuery and AdEngine2.run.js
		'//extensions/wikia/AdEngine/js/Krux.run.js',
	),
);

$VenusConfig['liftium_ads_js'] = array(
	'type' => AssetsManager::TYPE_JS,
	'assets' => array(
		'//extensions/wikia/AdEngine/liftium/Liftium.js',
		// TODO: get rid of those:
		'//extensions/wikia/AdEngine/liftium/Wikia.Athena.js',
		'//extensions/wikia/AdEngine/liftium/Wikia.AQ.js',
		'//extensions/wikia/AdEngine/liftium/Wikia.meerkat.js',
		'//extensions/wikia/AdEngine/liftium/Wikia.ve_alternate.js',
		'//extensions/wikia/AdEngine/liftium/AdsInContent.js'
	),
);