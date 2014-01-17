/* jshint strict:false */

module.exports = function(grunt) {

	grunt.initConfig({
		jshint: {
			files: ['Gruntfile.js', 'src/**/*.js', 'test/**/*.js'],
			options: {
				// options here to override JSHint defaults
				globals: {
					jQuery: true,
					console: true,
					module: true,
					document: true
				}
			}
		},
		jscs: {
			src: 'extensions/wikia/VideoPageTool/js/views/*.js',
			options: {
				config: '.jscs.json'
			}
		}
	});

	grunt.loadNpmTasks('grunt-jscs-checker');
	grunt.loadNpmTasks('grunt-contrib-jshint');

	//grunt.registerTask('test', ['jshint', 'qunit']);
};