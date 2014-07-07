/*!
 * Grunt file
 *
 * @package VisualEditor
 */

/*jshint node:true */
module.exports = function ( grunt ) {
	var modules = grunt.file.readJSON( 'lib/ve/build/modules.json' );

	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-csslint' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-jscs-checker' );
	grunt.loadTasks( 'lib/ve/build/tasks' );
	grunt.loadTasks( 'build/tasks' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		jsduckcatconfig: {
			main: {
				target: '.docs/categories.json',
				from: [
					'.docs/mw-categories.json',
					{
						file: 'lib/ve/.docs/categories.json',
						aggregate: {
							'VisualEditor (core)': [
								'General',
								'Initialization',
								'DataModel',
								'ContentEditable',
								'User Interface',
								'Tests'
							]
						},
						include: ['UnicodeJS', 'OOJS UI', 'Upstream']
					}
				]
			}
		},
		buildloader: {
			egiframe: {
				target: '.docs/eg-iframe.html',
				template: '.docs/eg-iframe.html.template',
				modules: modules,
				pathPrefix: 'lib/ve/',
				indent: '\t\t'
			}
		},
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'*.js',
				'{.docs,build}/**/*.js',
				'modules/**/*.js'
			]
		},
		jscs: {
			src: [
				'<%= jshint.all %>'
			]
		},
		csslint: {
			options: {
				csslintrc: '.csslintrc'
			},
			all: [
				'modules/*/**/*.css'
			],
		},
		banana: {
			all: 'modules/ve-{mw,wmf}/i18n/'
		},
		watch: {
			files: [
				'.{jshintrc,jscs.json,jshintignore,csslintrc}',
				'<%= jshint.all %>',
				'<%= csslint.all %>'
			],
			tasks: ['test']
		}
	} );

	grunt.registerTask( 'build', ['jsduckcatconfig', 'buildloader'] );
	grunt.registerTask( 'lint', ['jshint', 'jscs', 'csslint', 'banana' ] );
	grunt.registerTask( 'test', ['build', 'lint'] );
	grunt.registerTask( 'default', ['test'] );
};
