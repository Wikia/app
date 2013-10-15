/**
 * Karma configuration
 *
 * Used to run Wikia's JS Integration tests
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

	'tests/lib/jasmine/helpers.js',

	'resources/jquery/jquery-1.8.2.js',
	'resources/wikia/libraries/define.mock.js',

	//JSMessages
	'extensions/wikia/JSMessages/js/JSMessages.js',

	//Chat Tests
	'extensions/wikia/Chat2/js/spec/integration/views.mocks.js',
	'extensions/wikia/Chat2/js/views/views.js',
	'extensions/wikia/Chat2/js/spec/integration/ChatController.config.spec.js',

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
	'extensions/wikia/WikiaMobile/js/track.js',
	'extensions/wikia/WikiaMobile/js/toc.js',
	'extensions/wikia/WikiaMobile/js/topbar.js',
	'extensions/wikia/WikiaMobile/js/features.js',
	'extensions/wikia/WikiaMobile/js/spec/integration/*.spec.js',


	//core modules
	'resources/wikia/modules/window.js',
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
	'resources/wikia/modules/spec/integration/*.config.spec.js',

	//SpecialPromote
	'extensions/wikia/SpecialPromote/js/spec/integration/SpecialPromote.mocks.js',
	'extensions/wikia/SpecialPromote/js/SpecialPromote.js',
	'extensions/wikia/SpecialPromote/js/spec/integration/SpecialPromote.config.spec.js',
];

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
	//'PhantomJS',
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
	dir : 'tests/build/jsintegration-coverage'
};

preprocessors = {
	'**/resources/wikia/modules/*.js': 'coverage',
	'**/js/*.js': 'coverage'
};

junitReporter = {
	outputFile: 'tests/build/test-results.xml'
};
