module.exports = function (grunt) {
	'use strict';

	var juice = require('juice');

	grunt.loadNpmTasks('grunt-contrib-watch');

	/**
	 * Use Juice to inline css from an external style sheet
	 * @see https://github.com/Automattic/juice
	 */
	grunt.registerTask('inlineCSS', 'Replaces css classes and IDs with style attributes', function () {
		var src = '../templates/src';

		grunt.file.recurse(src, function (absPath, rootDir, subDir, fileName) {
			var html = grunt.file.read(absPath);

			juice.juiceResources(html, {
					webResources: {
						relativeTo: src
					}
				},
				function (err, html) {
					if (err) {
						grunt.log.error(err);
					} else {
						var dest = rootDir + '/../compiled/' + fileName;
						grunt.file.write(dest, html);
					}
				});
		});
	});

	grunt.initConfig({
		watch: {
			scripts: {
				files: ['../templates/src/*.mustache', '../styles/*.css'],
				tasks: ['inlineCSS'],
				options: {
					// run tasks when grunt watch is first started
					atBegin: true
				}
			}
		}
	});
};
