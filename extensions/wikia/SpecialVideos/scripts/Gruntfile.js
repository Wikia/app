module.exports = function (grunt) {
	'use strict';
	grunt.loadNpmTasks('grunt-mustache');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Task to precompile mustache templates
		mustache: {
			files: {
				src: '../templates/*.mustache',
				dest: 'templates.mustache.js'
			},
			options: {
				// define as an AMD module
				prefix: 'define( \'specialVideos.templates.mustache\', [], function() { \'use strict\'; return ',
				postfix: '; });',
				verbose: true
			}
		}
	});

	grunt.registerTask('default', ['mustache']);
};
