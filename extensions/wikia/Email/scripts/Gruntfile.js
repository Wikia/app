module.exports = function (grunt) {
	'use strict';

	grunt.loadNpmTasks('grunt-email-builder');

	grunt.initConfig({
		emailBuilder: {
			test: {
				files: [{
					expand: true,
					src: ['../templates/src/*.mustache'],
					dest: '../templates/compiled',
					flatten: true
				}]
			}
		}
	});
};
