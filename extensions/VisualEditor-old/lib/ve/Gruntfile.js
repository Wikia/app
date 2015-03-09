/*!
 * Grunt file
 *
 * @package VisualEditor
 */

/*jshint node:true */
module.exports = function ( grunt ) {
	var modules = grunt.file.readJSON( 'build/modules.json' );

	function demoMenu( callback ) {
		var html = [],
			files = grunt.file.expand( 'demos/ve/pages/*.html' );
		files.forEach( function ( file ) {
			file = file.replace( /^.*(pages\/.+.html)$/, '$1' );
			var name = file.slice( 6, -5 );
			html.push(
				'\t\t\t<li><a href="#!/src/' + file + '" data-page-src="' + file +
					'">' + name + '</a></li>'
			);
		} );
		callback( html.join( '\n' ) );
	}

	grunt.loadNpmTasks( 'grunt-contrib-csslint' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-qunit' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-jscs-checker' );
	grunt.loadTasks( 'build/tasks' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		buildloader: {
			iframe: {
				targetFile: '.docs/eg-iframe.html',
				template: '.docs/eg-iframe.html.template',
				modules: modules,
				load: [ 'visualEditor.desktop.standalone' ],
				pathPrefix: '../',
				indent: '\t\t'
			},
			desktopDemo: {
				targetFile: 'demos/ve/desktop.html',
				template: 'demos/ve/demo.html.template',
				modules: modules,
				load: [ 'visualEditor.desktop.standalone.demo' ],
				env: {
					debug: true
				},
				pathPrefix: '../../',
				indent: '\t\t',
				placeholders: { menu: demoMenu }
			},
			mobileDemo: {
				targetFile: 'demos/ve/mobile.html',
				template: 'demos/ve/demo.html.template',
				modules: modules,
				load: [ 'visualEditor.mobile.standalone.demo' ],
				env: {
					debug: true
				},
				pathPrefix: '../../',
				indent: '\t\t',
				placeholders: { menu: demoMenu }
			},
			test: {
				targetFile: 'modules/ve/test/index.html',
				template: 'modules/ve/test/index.html.template',
				modules: modules,
				env: {
					test: true
				},
				load: [ 'visualEditor.test' ],
				pathPrefix: '../../../',
				indent: '\t\t'
			}
		},
		jshint: {
			options: {
				jshintrc: true
			},
			all: [
				'*.js',
				'{.docs,build,demos,modules}/**/*.js'
			]
		},
		jscs: {
			src: [
				'<%= jshint.all %>',
				'!modules/ve/test/ce/imetests/*.js'
			]
		},
		csslint: {
			options: {
				csslintrc: '.csslintrc'
			},
			all: '{.docs,build,demos,modules}/**/*.css'
		},
		banana: {
			all: 'modules/ve/i18n/'
		},
		qunit: {
			unicodejs: 'modules/unicodejs/index.html',
			ve: 'modules/ve/test/index.html'
		},
		watch: {
			files: [
				'.{csslintrc,jscsrc,jshintignore,jshintrc}',
				'<%= jshint.all %>',
				'<%= csslint.all %>',
				'<%= qunit.ve %>',
				'<%= qunit.unicodejs %>'
			],
			tasks: 'test'
		}
	} );

	grunt.registerTask( 'lint', [ 'jshint', 'jscs', 'csslint', 'banana' ] );
	grunt.registerTask( 'unit', 'qunit' );
	grunt.registerTask( 'build', 'buildloader' );
	grunt.registerTask( 'test', [ 'build', 'lint', 'unit' ] );
	grunt.registerTask( 'default', 'test' );
};
