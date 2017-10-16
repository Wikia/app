/* jshint ignore: start */
module.exports = function (grunt) {
	'use strict';
	grunt.loadNpmTasks('grunt-mustache');

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Task to precompile mustache templates
		mustache: {
			files: {
				src: '../templates/',
				dest: 'templates.mustache.js'
			},
			options: {
				// define as an AMD module
				prefix: '/* jshint ignore:start */ define( \'embeddablediscussions.templates.mustache\', [], function() { \'use strict\'; return ',
				postfix: '; }); /* jshint ignore:end */',
				verbose: true
			}
		}
	});

	grunt.registerTask('default', ['mustache']);
};
/* jshint ignore: end */
