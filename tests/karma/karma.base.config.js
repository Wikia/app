/**
 * Karma base configuration
 *
 * Shared across unit and integration tests
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
		logLevel: config.LOG_INFO,
		captureTimeout: 10000,
		singleRun: false,
		reporters: [ 'progress', 'coverage' /*, 'growl', 'coverage', 'osx' */],
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
		}
	});
};
