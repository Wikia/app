module.exports = function (grunt) {
	'use strict';

	grunt.loadNpmTasks('grunt-mustache');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Task to precompile mustache templates
		mustache: {
			files: {
				src: '../templates/*.mustache',
				dest: 'dropdownNavigation.templates.mustache.js'
			},
			options: {
				// define as an AMD module
				prefix: 'define( \'wikia.dropdownNavigation.templates\', [], function() { \'use strict\'; return ',
				postfix: '; });',
				verbose: true
			}
		}
	});

	grunt.registerTask('default', ['mustache']);
};
