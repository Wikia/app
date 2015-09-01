/*!
 * Grunt file
 *
 * @package VisualEditor
 */

/*jshint node:true */
module.exports = function ( grunt ) {
	var modules = grunt.file.readJSON( 'build/modules.json' ),
		moduleUtils = require( './build/moduleUtils' ),
		coreBuildFiles = moduleUtils.makeBuildList( modules, [ 'visualEditor.build' ] ),
		coreBuildFilesApex = moduleUtils.makeBuildList( modules, [ 'visualEditor.build.apex' ] ),
		coreBuildFilesMediaWiki = moduleUtils.makeBuildList( modules, [ 'visualEditor.build.mediawiki' ] ),
		testFiles = moduleUtils.makeBuildList( modules, [ 'visualEditor.test' ] ).scripts,
		demoPages = ( function () {
			var pages = {},
				files = grunt.file.expand( 'demos/ve/pages/*.html' );
			files.forEach( function ( file ) {
				var matches = file.match( /^.*(pages\/(.+).html)$/ ),
					path = matches[ 1 ],
					name = matches[ 2 ];

				pages[ name ] = path;
			} );
			return pages;
		} )();

	grunt.loadNpmTasks( 'grunt-jsonlint' );
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-csslint' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-css-url-embed' );
	grunt.loadNpmTasks( 'grunt-cssjanus' );
	grunt.loadNpmTasks( 'grunt-jscs' );
	grunt.loadNpmTasks( 'grunt-karma' );
	grunt.loadTasks( 'build/tasks' );

	// We want to use `grunt watch` to start this and karma watch together.
	grunt.renameTask( 'watch', 'runwatch' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		clean: {
			dist: [ 'dist/*', 'coverage/*' ]
		},
		concat: {
			js: {
				options: {
					banner: grunt.file.read( 'build/banner.txt' )
				},
				dest: 'dist/visualEditor.js',
				src: coreBuildFiles.scripts
			},
			'css-apex': {
				options: {
					banner: grunt.file.read( 'build/banner.txt' )
				},
				dest: 'dist/visualEditor-apex.css',
				src: coreBuildFilesApex.styles
			},
			'css-mediawiki': {
				options: {
					banner: grunt.file.read( 'build/banner.txt' )
				},
				dest: 'dist/visualEditor-mediawiki.css',
				src: coreBuildFilesMediaWiki.styles
			},
			// HACK: Ideally these libraries would provide their own distribution files (T95667)
			'jquery.i18n': {
				dest: 'dist/lib/jquery.i18n.js',
				src: modules[ 'jquery.i18n' ].scripts
			},
			'jquery.uls.data': {
				dest: 'dist/lib/jquery.uls.data.js',
				src: modules[ 'jquery.uls.data' ].scripts
			}
		},
		cssjanus: {
			apex: {
				dest: 'dist/visualEditor-apex.rtl.css',
				src: 'dist/visualEditor-apex.css'
			},
			mediawiki: {
				dest: 'dist/visualEditor-mediawiki.rtl.css',
				src: 'dist/visualEditor-mediawiki.css'
			}
		},
		cssUrlEmbed: {
			options: {
				// TODO: A few image paths aren't relative to src/ui/styles
				failOnMissingUrl: false,
				baseDir: 'src/ui/styles'
			},
			dist: {
				files: {
					'dist/visualEditor-apex.css': 'dist/visualEditor-apex.css',
					'dist/visualEditor-apex.rtl.css': 'dist/visualEditor-apex.rtl.css',
					'dist/visualEditor-mediawiki.css': 'dist/visualEditor-mediawiki.css',
					'dist/visualEditor-mediawiki.rtl.css': 'dist/visualEditor-mediawiki.rtl.css'
				}
			}
		},
		copy: {
			i18n: {
				src: 'i18n/*.json',
				dest: 'dist/',
				expand: true
			},
			lib: {
				src: [ 'lib/**', '!lib/jquery.i18n/**', '!lib/jquery.uls/**' ],
				dest: 'dist/',
				expand: true
			}
		},
		buildloader: {
			iframe: {
				targetFile: '.jsduck/eg-iframe.html',
				template: '.jsduck/eg-iframe.html.template',
				modules: modules,
				load: [
					'visualEditor.standalone.apex.dist',
					'visualEditor.standalone.read'
				],
				pathPrefix: '../',
				i18n: [ 'i18n/', 'lib/oojs-ui/i18n/' ],
				indent: '\t\t',
				dir: 'ltr'
			},
			desktopDemo: {
				targetFile: 'demos/ve/desktop.html',
				template: 'demos/ve/demo.html.template',
				modules: modules,
				load: [
					'visualEditor.desktop.standalone',
					'visualEditor.standalone.read'
				],
				run: [ 'visualEditor.desktop.standalone.demo' ],
				env: {
					debug: true
				},
				pathPrefix: '../../',
				i18n: [ 'i18n/', 'lib/oojs-ui/i18n/' ],
				indent: '\t\t',
				demoPages: demoPages
			},
			desktopDemoDist: {
				targetFile: 'demos/ve/desktop-dist.html',
				template: 'demos/ve/demo.html.template',
				modules: modules,
				load: [
					'visualEditor.standalone.apex.dist',
					'visualEditor.standalone.read'
				],
				run: [ 'visualEditor.desktop.standalone.demo' ],
				pathPrefix: '../../',
				i18n: [ 'dist/i18n/', 'lib/oojs-ui/i18n/' ],
				indent: '\t\t',
				demoPages: demoPages
			},
			mobileDemo: {
				targetFile: 'demos/ve/mobile.html',
				template: 'demos/ve/demo.html.template',
				modules: modules,
				load: [
					'visualEditor.mobile.standalone',
					'visualEditor.standalone.read'
				],
				run: [ 'visualEditor.mobile.standalone.demo' ],
				env: {
					debug: true
				},
				pathPrefix: '../../',
				i18n: [ 'i18n/', 'lib/oojs-ui/i18n/' ],
				indent: '\t\t',
				demoPages: demoPages
			},
			mobileDemoDist: {
				targetFile: 'demos/ve/mobile-dist.html',
				template: 'demos/ve/demo.html.template',
				modules: modules,
				load: [
					'visualEditor.standalone.mediawiki.dist',
					'visualEditor.standalone.read'
				],
				run: [ 'visualEditor.mobile.standalone.demo' ],
				pathPrefix: '../../',
				i18n: [ 'dist/i18n/', 'lib/oojs-ui/i18n/' ],
				indent: '\t\t',
				demoPages: demoPages
			},
			minimalDemo: {
				targetFile: 'demos/ve/minimal.html',
				template: 'demos/ve/minimal.html.template',
				modules: modules,
				load: [
					'visualEditor.standalone.apex.dist',
					'visualEditor.standalone.read'
				],
				run: [ 'visualEditor.minimal.standalone.demo' ],
				pathPrefix: '../../',
				i18n: [ 'dist/i18n/', 'lib/oojs-ui/i18n/' ],
				indent: '\t\t',
				dir: 'ltr',
				langList: false
			},
			minimalDemoRtl: {
				targetFile: 'demos/ve/minimal-rtl.html',
				template: 'demos/ve/minimal.html.template',
				modules: modules,
				load: [
					'visualEditor.standalone.apex.dist',
					'visualEditor.standalone.read'
				],
				run: [ 'visualEditor.minimal.standalone.demo' ],
				pathPrefix: '../../',
				i18n: [ 'dist/i18n/', 'lib/oojs-ui/i18n/' ],
				indent: '\t\t',
				dir: 'rtl',
				langList: false
			},
			test: {
				targetFile: 'tests/index.html',
				template: 'tests/index.html.template',
				modules: modules,
				env: {
					test: true
				},
				load: [ 'visualEditor.test' ],
				pathPrefix: '../',
				indent: '\t\t'
			}
		},
		jshint: {
			options: {
				jshintrc: true
			},
			all: [
				'*.js',
				'{.jsduck,build,demos,src,tests}/*.js',
				'{.jsduck,build,demos,src,tests}/**/*.js'
			]
		},
		jscs: {
			fix: {
				options: {
					fix: true
				},
				src: [
					'<%= jshint.all %>'
				]
			},
			main: {
				src: [
					'<%= jshint.all %>'
				]
			}
		},
		csslint: {
			options: {
				csslintrc: '.csslintrc'
			},
			all: '{.jsduck,build,demos,src,tests}/**/*.css'
		},
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**'
			]
		},
		banana: {
			all: 'i18n/'
		},
		karma: {
			options: {
				files: testFiles,
				frameworks: [ 'qunit' ],
				reporters: [ 'dots' ],
				singleRun: true,
				browserDisconnectTimeout: 5000,
				browserDisconnectTolerance: 2,
				autoWatch: false
			},
			main: {
				browsers: [ 'Chrome' ],
				preprocessors: {
					'src/**/*.js': [ 'coverage' ]
				},
				reporters: [ 'dots', 'coverage' ],
				coverageReporter: { reporters: [
					{ type: 'html', dir: 'coverage/' },
					{ type: 'text-summary', dir: 'coverage/' }
				] }
			},
			others: {
				browsers: [ 'Firefox' ]
			},
			bg: {
				browsers: [ 'Chrome', 'Firefox' ],
				singleRun: false,
				background: true
			}
		},
		runwatch: {
			files: [
				'.{csslintrc,jscsrc,jshintignore,jshintrc}',
				'<%= jshint.all %>',
				'<%= csslint.all %>'
			],
			tasks: [ 'test', 'karma:bg:run' ]
		}
	} );

	grunt.registerTask( 'git-status', function () {
		var done = this.async();
		// Are there unstaged changes?
		require( 'child_process' ).exec( 'git ls-files --modified', function ( err, stdout, stderr ) {
			var ret = err || stderr || stdout;
			if ( ret ) {
				grunt.log.error( 'Unstaged changes in these files:' );
				grunt.log.error( ret );
				// Show a condensed diff
				require( 'child_process' ).exec( 'git diff -U1 | tail -n +3', function ( err, stdout, stderr ) {
					grunt.log.write( err || stderr || stdout );
					done( false );
				} );
			} else {
				grunt.log.ok( 'No unstaged changes.' );
				done();
			}
		} );
	} );

	grunt.registerTask( 'build', [ 'clean', 'concat', 'cssjanus', 'cssUrlEmbed', 'copy', 'buildloader' ] );
	grunt.registerTask( 'lint', [ 'jshint', 'jscs:main', 'csslint', 'jsonlint', 'banana' ] );
	grunt.registerTask( 'unit', [ 'karma:main' ] );
	grunt.registerTask( 'fix', [ 'jscs:fix' ] );
	grunt.registerTask( '_test', [ 'lint', 'git-build', 'build', 'unit' ] );
	grunt.registerTask( 'ci', [ '_test', 'git-status' ] );
	grunt.registerTask( 'watch', [ 'karma:bg:start', 'runwatch' ] );

	if ( process.env.JENKINS_HOME ) {
		grunt.registerTask( 'test', 'ci' );
	} else {
		grunt.registerTask( 'test', '_test' );
	}

	grunt.registerTask( 'default', 'test' );
};
