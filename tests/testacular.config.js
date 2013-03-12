// Testacular configuration
// Generated on Thu Feb 28 2013 11:29:38 GMT+0100 (CET)

/*
	created by Jakub Olek <jakub.olek@wikia-inc.com>
 */

// base path, that will be used to resolve files and exclude
basePath = '../';

// list of files / patterns to load in the browser
files = [
	JASMINE,
	JASMINE_ADAPTER,
	'tests/lib/jasmine/jasmine.async.js',
	'tests/lib/jasmine/helpers.js',

	'resources/wikia/libraries/define.mock.js',

	'extensions/wikia/WikiaMobile/js/Wikia.utils.js',
	'resources/wikia/libraries/deferred/deferred.js',
	'resources/wikia/libraries/deferred/deferred.api.js',

	'resources/jquery/jquery-1.8.2.js',
	'extensions/wikia/JSMessages/js/JSMessages.js',
		'extensions/wikia/JSMessages/js/spec/*.spec.js',

	//WikiaMobile
	'extensions/wikia/WikiaMobile/js/autocomplete.js',
	'extensions/wikia/WikiaMobile/js/events.js',
	'extensions/wikia/WikiaMobile/js/features.js',
	'extensions/wikia/WikiaMobile/js/lazyload.js',
	'extensions/wikia/WikiaMobile/js/mediagallery.js',
	'extensions/wikia/WikiaMobile/js/media.js',
	'extensions/wikia/WikiaMobile/js/modal.js',
	'extensions/wikia/WikiaMobile/js/pager.js',
	'extensions/wikia/WikiaMobile/js/popover.js',
	'extensions/wikia/WikiaMobile/js/sections.js',
	'extensions/wikia/WikiaMobile/js/ads.js',
	'extensions/wikia/WikiaMobile/js/share.js',
	'extensions/wikia/WikiaMobile/js/tables.js',
	'extensions/wikia/WikiaMobile/js/throbber.js',
	'extensions/wikia/WikiaMobile/js/toast.js',
	'extensions/wikia/WikiaMobile/js/toc.js',
	'extensions/wikia/WikiaMobile/js/topbar.js',
	'extensions/wikia/WikiaMobile/js/features.js',
	'extensions/wikia/WikiaMobile/js/track.js',
		'extensions/wikia/WikiaMobile/js/spec/*.spec.js',

	//SpecialPromote
	//'extensions/wikia/SpecialPromote/js/SpecialPromote.js',

	//core modules
	'resources/wikia/modules/aim.js',
	'resources/wikia/modules/cache.js',
	'resources/wikia/modules/cookies.js',
	'resources/wikia/modules/geo.js',
	'resources/wikia/modules/lazyqueue.js',
	'resources/wikia/modules/loader.js',
	'resources/wikia/libraries/mustache/mustache.js',
	'resources/wikia/libraries/mustache/jquery.mustache.js',
	'resources/wikia/modules/nirvana.js',
	'resources/wikia/modules/querystring.js',
	'resources/wikia/modules/stringhelper.js',
	'resources/wikia/modules/thumbnailer.js',
	'resources/wikia/modules/uniqueId.js',
		'resources/wikia/modules/spec/*.spec.js',

	//Chat Tests
	//'resources/wikia/libraries/jquery/throttle-debounce/jquery.throttle-debounce.js',
	//'resources/wikia/jquery.wikia.js',
	//'extensions/wikia/Chat2/js/emoticons.js',
	//'extensions/wikia/Chat2/js/lib/underscore.js',
	//'extensions/wikia/Chat2/js/lib/backbone.js',
	//'extensions/wikia/Chat2/js/views/views.js',

	//Advertisment
	'extensions/wikia/AdEngine/js/AdConfig2.js',
	'extensions/wikia/AdEngine/js/AdConfig2Late.js',
	'extensions/wikia/AdEngine/js/AdEngine2.js',
	'extensions/wikia/AdEngine/js/AdLogicDartSubdomain.js',
	'extensions/wikia/AdEngine/js/AdLogicHighValueCountry.js',
	'extensions/wikia/AdEngine/js/AdLogicPageLevelParams.js',
	'extensions/wikia/AdEngine/js/AdLogicPageLevelParamsLegacy.js',
	'extensions/wikia/AdEngine/js/AdLogicShortPage.js',
	'extensions/wikia/AdEngine/js/AdProviderAdDriver2.js',
	'extensions/wikia/AdEngine/js/AdProviderEvolve.js',
	'extensions/wikia/AdEngine/js/AdProviderGamePro.js',
	'extensions/wikia/AdEngine/js/AdProviderLater.js',
	'extensions/wikia/AdEngine/js/AdProviderLiftium2Dom.js',
	'extensions/wikia/AdEngine/js/AdProviderNull.js',
	'extensions/wikia/AdEngine/js/DartUrl.js',
	'extensions/wikia/AdEngine/js/EvolveHelper.js',
	'extensions/wikia/AdEngine/js/WikiaDartHelper.js',
	'extensions/wikia/AdEngine/js/WikiaDartMobileHelper.js',
		'extensions/wikia/AdEngine/js/spec/*.spec.js'
];

// list of files to exclude
exclude = [];

// test results reporter to use
// possible values: 'dots', 'progress', 'junit'
reporters = ['progress'];

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

// Start these browsers, currently available:
// - Chrome
// - ChromeCanary
// - Firefox
// - Opera
// - Safari (only Mac)
// - PhantomJS
// - IE (only Windows)
browsers = ['Chrome', 'PhantomJS', 'Firefox', 'Opera', 'Safari'];

// If browser does not capture in given timeout [ms], kill it
captureTimeout = 10000;


// Continuous Integration mode
// if true, it capture browsers, run tests and exit
singleRun = false;

coverageReporter = {
	type : 'html',
	dir : 'tests/coverage/'
};

//reportSlowerThan = 100;

preprocessors = {
	'**/js/*.js': 'coverage'
};