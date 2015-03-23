module.exports = function (grunt) {
	'use strict';

	grunt.loadNpmTasks('grunt-email-builder');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.initConfig({
		emailBuilder: {
			test: {
				files: [
					{
						expand: true,
						src: ['../templates/src/*.mustache'],
						dest: '../templates/compiled',
						flatten: true
					}
				]
			}
		},
		watch: {
			scripts: {
				files: ['../templates/src/**/*.mustache', '../styles/*.css'],
				tasks: ['emailBuilder']
			}
		}
	});
};
