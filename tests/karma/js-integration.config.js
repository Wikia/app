/**
 * Karma configuration
 *
 * Used to run Wikia's JS Integration tests
 *
 * created by Jakub Olek <jakub.olek@wikia-inc.com>
 */

var buildPath = 'tests/build/';

module.exports = function(config) {
	'use strict';

	config.set({
		basePath: '../../',
		frameworks: ['jasmine'/*, 'detectBrowsers'*/],
		browsers: [
			'PhantomJS'
			//'SlimerJS',
			//'Chrome',
			//'ChromeCanary',
			//'Firefox',
			//'Opera',
			//'iOS'
			//'Safari', // only Mac
			//'IE' // only Windows
		],
		detectBrowsers: {
			enabled: false
		},
		autoWatch: true,
		port: 9876,
		runnerPort: 9100,
		colors: true,
		logLevel: config.LOG_ERROR,
		captureTimeout: 5000,
		singleRun: false,
		reporters: [ 'dots', 'osx' /*, 'growl', 'coverage', 'osx' */],
		coverageReporter: {
			type : 'cobertura',
			dir : buildPath + 'jsunit-coverage'
		},
		preprocessors: {
			'**/resources/wikia/modules/*.js': ['coverage'],
			'**/js/*.js': ['coverage']
		},
		reportSlowerThan: 500,
		junitReporter: {
			outputFile: buildPath + 'test-results.xml'
		},
		files: [
			'tests/lib/jasmine/jasmine.async.js',

			'tests/lib/jasmine/helpers.js',

			'resources/jquery/jquery-1.8.2.js',
			'resources/wikia/libraries/define.mock.js',

			//JSMessages
			'extensions/wikia/JSMessages/js/JSMessages.js',

			//Chat Tests
			'extensions/wikia/Chat2/js/spec/integration/views.mocks.js',
			'extensions/wikia/Chat2/js/views/views.js',
			'extensions/wikia/Chat2/js/spec/integration/ChatController.spec.js',

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
			'resources/wikia/modules/spec/integration/*.spec.js',

			//SpecialPromote
			'extensions/wikia/SpecialPromote/js/spec/integration/SpecialPromote.mocks.js',
			'extensions/wikia/SpecialPromote/js/SpecialPromote.js',
			'extensions/wikia/SpecialPromote/js/spec/integration/SpecialPromote.spec.js'
		]
	});
};
