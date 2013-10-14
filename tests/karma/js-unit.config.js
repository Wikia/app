/**
 * Karma configuration
 *
 * Used to run Wikia's JS Unit tests
 *
 * created by Jakub Olek <jakub.olek@wikia-inc.com>
 */

// base path, that will be used to resolve files and exclude
basePath = '../../';

// list of files / patterns to load in the browser
files = [
	JASMINE,
	JASMINE_ADAPTER,
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
	'extensions/wikia/WikiaMobile/js/ads.js',
	'extensions/wikia/WikiaMobile/js/share.js',
	'extensions/wikia/WikiaMobile/js/tables.js',
	'extensions/wikia/WikiaMobile/js/throbber.js',
	'extensions/wikia/WikiaMobile/js/topbar.js',
	'extensions/wikia/WikiaMobile/js/track.js',
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
	//UI Repo JS API
	'resources/wikia/modules/uicomponent.js',
	'resources/wikia/modules/uifactory.js',
	'resources/wikia/modules/csspropshelper.js',
	'resources/wikia/modules/spec/*.spec.js',

	//Advertisment
	'extensions/wikia/AdEngine/js/AdConfig2.js',
	'extensions/wikia/AdEngine/js/AdConfig2Late.js',
	'extensions/wikia/AdEngine/js/AdEngine2.js',
	'extensions/wikia/AdEngine/js/AdLogicDartSubdomain.js',
	'extensions/wikia/AdEngine/js/AdLogicHighValueCountry.js',
	'extensions/wikia/AdEngine/js/AdLogicPageLevelParams.js',
	'extensions/wikia/AdEngine/js/AdLogicPageLevelParamsLegacy.js',
	'extensions/wikia/AdEngine/js/AdLogicPageDimensions.js',
	'extensions/wikia/AdEngine/js/AdProviderEvolve.js',
	'extensions/wikia/AdEngine/js/AdProviderGamePro.js',
	'extensions/wikia/AdEngine/js/AdProviderGpt.js',
	'extensions/wikia/AdEngine/js/AdProviderLater.js',
	'extensions/wikia/AdEngine/js/AdProviderLiftium2Dom.js',
	'extensions/wikia/AdEngine/js/AdProviderNull.js',
	'extensions/wikia/AdEngine/js/DartUrl.js',
	'extensions/wikia/AdEngine/js/EvolveHelper.js',
	'extensions/wikia/AdEngine/js/WikiaDartHelper.js',
	'extensions/wikia/AdEngine/js/WikiaDartMobileHelper.js',
	'extensions/wikia/AdEngine/js/spec/*.spec.js',

	//PhalanxII
	'extensions/wikia/PhalanxII/js/modules/phalanx.js',
	'extensions/wikia/PhalanxII/spec/*.spec.js',

	//Wikia HomePage
	'extensions/wikia/WikiaHomePage/js/spec/WikiaHomePage.mocks.js',
	'extensions/wikia/WikiaHomePage/js/WikiaHomePage.js',
	'extensions/wikia/WikiaHomePage/js/spec/WikiaHomePage.spec.js',

	//Search
	'extensions/wikia/Search/js/SearchAbTest.js',
	'extensions/wikia/Search/js/SearchAbTest.*.js',
	'extensions/wikia/Search/js/spec/*.spec.js',

	// Video
	'extensions/wikia/VideoPageTool/js/views/jquery.switcher.js',
	'extensions/wikia/VideoPageTool/js/spec/*.spec.js'
];

notCovered = [
	//Those are for coverage purposes
	'tests/lib/coverage.mocks.js',
	//'extensions/wikia/AbTesting/js/*.js',
	'extensions/wikia/Lightbox/js/*.js',
	'extensions/wikia/WikiStats/js/wikistats.js',
	'extensions/wikia/WikiMap/js/WikiMapIndexContent.js',
	//'extensions/wikia/WikiFactory/js/*.js',
	//'extensions/wikia/WikiaQuiz/js/*.js',
	//'extensions/wikia/WikiaPoll/js/*.js',
	'extensions/wikia/WikiaPhotoGallery/js/*.js',
	'extensions/wikia/WikiaMiniUpload/js/WMU.js',
	//'extensions/wikia/WikiaHubsV2/js/*.js',
	//'extensions/wikia/WikiaHomePage/js/*.js',
	'extensions/wikia/WikiaBar/js/WikiaBar.js',
	//'extensions/wikia/Wall/js/*.js',
	'extensions/wikia/VisualStats/js/Visual*.js',
	'extensions/wikia/VideoHandlers/js/*.js',
	'extensions/wikia/VideoEmbedTool/js/*.js',
	//'extensions/wikia/UserProfilePageV3/js/UserProfilePage.js',
	//'extensions/wikia/UserLogin/js/*.js',
	//'extensions/wikia/TopLists/js/*.js',
	//'extensions/wikia/ThemeDesigner/js/*.js',
	//'extensions/wikia/TabView/js/*.js',
	//'extensions/wikia/StructuredData/js/*.js',
	'extensions/wikia/SponsorshipDashboard/js/*.js',
	//'extensions/wikia/SpecialVideos/js/*.js',
	//'extensions/wikia/SpecialMarketingToolbox/js/*.js',
	//'extensions/wikia/SpecialManageWikiaHome/js/*.js',
	//'extensions/wikia/ShareButtons/js/*.js',
	//'extensions/wikia/Search/js/*.js',
	//'extensions/wikia/RelatedVideos/js/*.js',
	//'extensions/wikia/RelatedPages/js/*.js',
	//'extensions/wikia/RecentChanges/js/*.js',
	'extensions/wikia/Places/js/*.js',
	'extensions/wikia/Phalanx/js/*.js',
	//'extensions/wikia/MiniEditor/js/*.js',
	//'extensions/wikia/MiniEditor/js/Forum/*.js',
	//'extensions/wikia/MiniEditor/js/Wall/*.js',
	'extensions/wikia/LoaderQueue/js/*.js',
	//'extensions/wikia/LinkSuggest/js/*.js',
	'extensions/wikia/JSSnippets/js/*.js',
	//'extensions/wikia/ImageReview/js/*.js',
	'extensions/wikia/ImagePlaceholder/js/*.js',
	//'extensions/wikia/ImageLazyLoad/js/*.js',
	//'extensions/wikia/Forum/js/*.js',
	//'extensions/wikia/EditPageLayout/js/**/*.js',
	'extensions/wikia/CreatePage/js/**/*.js',
	//'extensions/wikia/CreateNewWiki/js/*.js',
	'extensions/wikia/CorporatePage/js/*.js',
	'extensions/wikia/ContentWarning/js/*.js',
	//'extensions/wikia/CategorySelect/js/*.js',
	'extensions/wikia/CategoryExhibition/js/*.js',
	'extensions/wikia/Blogs/js/*.js',
	'extensions/wikia/ArticleComments/js/*.js',
	'extensions/wikia/AjaxPoll/js/*.js',
	//'extensions/wikia/AchievementsII/js/*.js',
	//'extensions/wikia/WikiFeatures/js/WikiFeatures.js',
];

//if full parameter is passed generate code coverage even for not tested files
//if( ~process.argv.indexOf('--full') ) {
//	files = files.concat(notCovered);
//}

// list of files to exclude
exclude = [];

// test results reporter to use
reporters = [
	//'dots',
	'progress',
	//'junit',
	//'coverage'
];

// web server port
port = 9876;

// cli runner port
runnerPort = 9100;

// enable / disable colors in the output (reporters and logs)
colors = true;

// level of logging
// possible values: LOG_DISABLE || LOG_ERROR || LOG_WARN || LOG_INFO || LOG_DEBUG
logLevel = LOG_INFO;

// enable / disable watching file and executing tests whenever any file changes
autoWatch = true;

// Start these browsers, to run tests:
browsers = [
	'PhantomJS'
	//'Chrome',
	//'ChromeCanary',
	//'Firefox',
	//'Opera',
	//'Safari', // only Mac
	//'IE' // only Windows
];

// If browser does not capture in given timeout [ms], kill it
captureTimeout = 10000;

// Continuous Integration mode
// if true, it capture browsers, run tests and exit
singleRun = false;

coverageReporter = {
	type : 'cobertura',
	dir : 'tests/build/jsunit-coverage'
};

reportSlowerThan = 500;

preprocessors = {
	'**/resources/wikia/modules/*.js': 'coverage',
	'**/js/*.js': 'coverage'
};

junitReporter = {
	outputFile: 'tests/build/test-results.xml'
};
