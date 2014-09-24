/**
 * Karma configuration
 *
 * Used to run Wikia's JS Unit tests
 *
 * created by Jakub Olek <jakubolek@wikia-inc.com>
 */

var base = require('./karma.base.conf.js');

module.exports = function (config) {
	'use strict';

	base(config);

	config.set({
		files: [
			'tests/lib/jasmine/jasmine.async.js',

			'resources/wikia/libraries/define.mock.js',
			'tests/lib/jasmine/helpers.js',
			'resources/jquery/jquery-1.8.2.js',

			//JSMessages
			'extensions/wikia/JSMessages/js/JSMessages.js',
			'extensions/wikia/JSMessages/js/spec/JSMessages.spec.js',

			//WikiaMobile
			'extensions/wikia/WikiaMobile/js/events.js',
			'extensions/wikia/WikiaMobile/js/mediagallery.js',
			'extensions/wikia/WikiaMobile/js/media.js',
			'extensions/wikia/WikiaMobile/js/pager.js',
			'extensions/wikia/WikiaMobile/js/share.js',
			'extensions/wikia/WikiaMobile/js/tables.js',
			'extensions/wikia/WikiaMobile/js/throbber.js',
			'extensions/wikia/WikiaMobile/js/topbar.js',
			'extensions/wikia/WikiaMobile/js/track.js',
			'extensions/wikia/WikiaMobile/js/toc.js',
			'extensions/wikia/WikiaMobile/js/spec/*.spec.js',

			//core modules
			'resources/wikia/modules/aim.js',
			'resources/wikia/modules/cache.js',
			'resources/wikia/modules/cookies.js',
			'resources/wikia/modules/geo.js',
			'resources/wikia/modules/lazyqueue.js',
			'resources/wikia/modules/loader.js',
			'resources/wikia/modules/nirvana.js',
			'resources/wikia/modules/querystring.js',
			'resources/wikia/modules/stringhelper.js',
			'resources/wikia/modules/thumbnailer.js',
			'resources/wikia/modules/uniqueId.js',
			'resources/wikia/libraries/mustache/mustache.js',
			'resources/wikia/libraries/jquery/ellipses.js',

			//UI Repo JS API
			'resources/wikia/modules/uicomponent.js',
			'resources/wikia/modules/uifactory.js',
			'resources/wikia/modules/csspropshelper.js',
			'resources/wikia/modules/spec/*.spec.js',

			//UI components
			'resources/wikia/ui_components/**/*.js',

			//Advertisement
			'extensions/wikia/AdEngine/js/AdConfig2.js',
			'extensions/wikia/AdEngine/js/AdConfig2Late.js',
			'extensions/wikia/AdEngine/js/AdConfigMobile.js',
			'extensions/wikia/AdEngine/js/AdContext.js',
			'extensions/wikia/AdEngine/js/AdDecoratorPageDimensions.js',
			'extensions/wikia/AdEngine/js/AdEngine2.js',
			'extensions/wikia/AdEngine/js/EventDispatcher.js',
			'extensions/wikia/AdEngine/js/AdLogicDartSubdomain.js',
			'extensions/wikia/AdEngine/js/AdLogicHighValueCountry.js',
			'extensions/wikia/AdEngine/js/AdLogicPageDimensions.js',
			'extensions/wikia/AdEngine/js/AdLogicPageParams.js',
			'extensions/wikia/AdEngine/js/AdLogicPageParamsLegacy.js',
			'extensions/wikia/AdEngine/js/AdProviderDirectGpt.js',
			'extensions/wikia/AdEngine/js/AdProviderEvolve.js',
			'extensions/wikia/AdEngine/js/AdProviderLater.js',
			'extensions/wikia/AdEngine/js/AdProviderLiftium.js',
			'extensions/wikia/AdEngine/js/AdProviderNull.js',
			'extensions/wikia/AdEngine/js/DartUrl.js',
			'extensions/wikia/AdEngine/js/EvolveHelper.js',
			'extensions/wikia/AdEngine/js/EvolveSlotConfig.js',
			'extensions/wikia/AdEngine/js/GptSlotConfig.js',
			'extensions/wikia/AdEngine/js/MessageListener.js',
			'extensions/wikia/AdEngine/js/WikiaDartHelper.js',
			'extensions/wikia/AdEngine/js/WikiaDartVideoHelper.js',
			'extensions/wikia/AdEngine/js/WikiaGptAdDetect.js',

			'extensions/wikia/AdEngine/js/spec/*.spec.js',

			//PhalanxII
			'extensions/wikia/PhalanxII/js/modules/phalanx.js',
			'extensions/wikia/PhalanxII/spec/*.spec.js',

			//Wikia HomePage
			'extensions/wikia/WikiaHomePage/js/spec/WikiaHomePage.mocks.js',
			'extensions/wikia/WikiaHomePage/js/WikiaHomePage.js',
			'extensions/wikia/WikiaHomePage/js/spec/WikiaHomePage.spec.js',

			/**
			 * Extension: VideoPageTool
			 * @description This extension is actually split up into a 'homepage' & an 'admin' component and is
			 * built using Backbone. Therefore, these unit tests are to be organized in a mirrored structure.
			 */

			/*
			 * Common VideoPageTool Deps
			 */
			'extensions/wikia/VideoPageTool/js/lib/lodash/dist/lodash.underscore.js',
			'extensions/wikia/VideoPageTool/js/lib/backbone/backbone.js',
			'extensions/wikia/VideoPageTool/js/shared/views/switcher.js',

			/*
			 * VideoPageTool: Admin Module
			 */

			// Collections
			'extensions/wikia/VideoPageTool/js/admin/collections/category.js',
			'extensions/wikia/VideoPageTool/js/admin/collections/categorydata.js',
			// Views
			'extensions/wikia/VideoPageTool/js/admin/views/autocomplete.js',

			/*
			 * VideoPageTool: Homepage Module
			 */
			'extensions/wikia/VideoPageTool/js/homepage/collections/featuredslides.js',

			/*
			 * VideoPageTool: Source the tests
			 */
			'extensions/wikia/VideoPageTool/js/spec/*.spec.js',
			'extensions/wikia/VideoPageTool/js/spec/**/*.spec.js',
			'extensions/wikia/VideoPageTool/js/spec/**/**/*.spec.js',

			/*
			 * Extension: VideosModule
			 */
			'extensions/wikia/VideosModule/scripts/models/videos.js',
			'extensions/wikia/VideosModule/scripts/spec/**/*.spec.js',

			//Search
			'extensions/wikia/Search/js/SearchAbTest.js',
			'extensions/wikia/Search/js/SearchAbTest.*.js',
			'extensions/wikia/Search/js/spec/*.spec.js',

			//TOC
			'extensions/wikia/TOC/js/modules/toc.js',
			'extensions/wikia/TOC/js/modules/spec/toc.spec.js',

			// LyricFind PV tracking
			'extensions/3rdparty/LyricWiki/LyricFind/js/modules/LyricFind.Tracker.js',
			'extensions/3rdparty/LyricWiki/LyricFind/js/spec/*.spec.js',

			// ImageLazyLoad
			'resources/wikia/libraries/jquery/throttle-debounce/jquery.throttle-debounce.js', // $.throttle
			'extensions/wikia/ImageLazyLoad/js/ImgLzy.module.js',
			'extensions/wikia/ImageLazyLoad/js/ImageLazyLoad.js',
			'extensions/wikia/ImageLazyLoad/spec/*.spec.js',

			// Thumbnails
			'extensions/wikia/Thumbnails/scripts/templates.mustache.js',
			'extensions/wikia/Thumbnails/scripts/views/titleThumbnail.js',
			'extensions/wikia/Thumbnails/scripts/spec/*.spec.js',

			// WikiaMaps
			'extensions/wikia/WikiaInteractiveMaps/js/intMapPoiCategories.js',
			'extensions/wikia/WikiaInteractiveMaps/js/models/intMapPoiCategoriesModel.js',
			'extensions/wikia/WikiaInteractiveMaps/js/intMapUtils.js',
			'extensions/wikia/WikiaInteractiveMaps/spec/*.spec.js'
		]
	});
};
