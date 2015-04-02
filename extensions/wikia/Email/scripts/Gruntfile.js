module.exports = function (grunt) {
	'use strict';

	var juice = require('juice');

	grunt.loadNpmTasks('grunt-contrib-watch');

	/**
	 * Use Juice to inline css from an external style sheet
	 * @see https://github.com/Automattic/juice
	 */
	grunt.registerTask('inlineCSS', 'some logging', function () {
		var src = '../templates/src';

		grunt.file.recurse(src, function (absPath, rootDir, subDir, fileName) {
			var html = grunt.file.read(absPath);

			juice.juiceResources(html, {
					webResources: {
						relativeTo: src
					}
				},
				function (err, html) {
					var dest = rootDir + '/../compiled/' + fileName;
					grunt.file.write(dest, html);
				});
		});
	});

	grunt.initConfig({
		watch: {
			scripts: {
				files: ['../templates/src/*.mustache', '../styles/*.css'],
				tasks: ['inlineCSS']
			}
		}
	});
};
