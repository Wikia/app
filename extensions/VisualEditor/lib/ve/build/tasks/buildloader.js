/*!
 * Build a static loader file from a template
 */

/*jshint node:true */
module.exports = function ( grunt ) {

	grunt.registerMultiTask( 'buildloader', function () {
		var configScript,
			styles = [],
			scripts = [],
			loadedModules = [],
			targetFile = this.data.targetFile,
			pathPrefix = this.data.pathPrefix || '',
			i18n = this.data.i18n || [],
			demoPages = this.data.demoPages,
			indent = this.data.indent || '',
			modules = this.data.modules,
			load = this.data.load,
			run = this.data.run || [],
			env = this.data.env || {},
			placeholders = this.data.placeholders || {},
			dir = this.data.dir,
			langList = this.data.langList !== undefined ? this.data.langList : true,
			text = grunt.file.read( this.data.template ),
			done = this.async(),
			moduleUtils = require( '../moduleUtils' );

		function scriptTag( src ) {
			return indent + '<script src="' + pathPrefix + src.file + '"></script>';
		}

		function styleTag( group, src ) {
			var rtlFilepath = src.file.replace( /\.css$/, '.rtl.css' );

			if ( grunt.file.exists( rtlFilepath ) ) {
				if ( !dir ) {
					return indent + '<link rel=stylesheet href="' + pathPrefix + src.file + '" class="stylesheet-ltr' +
						( group ? ' stylesheet-' + group : '' ) + '">\n' +
						indent + '<link rel=stylesheet href="' + pathPrefix + rtlFilepath + '" class="stylesheet-rtl' +
						( group ? ' stylesheet-' + group : '' ) + '">';
				} else if ( dir === 'rtl' ) {
					return indent + '<link rel=stylesheet href="' + pathPrefix + rtlFilepath + '"' +
						( group ? ' class="stylesheet-' + group + '"' : '' ) + '>';
				}
			}
			return indent + '<link rel=stylesheet href="' + pathPrefix + src.file + '"' +
				( group ? ' class="stylesheet-' + group + '"' : '' ) + '>';
		}

		function expand( src ) {
			return typeof src === 'string' ? { file: src } : src;
		}

		function filter( type, src ) {
			if ( src.debug && !env.debug ) {
				return false;
			}
			if ( type === 'styles' && env.test && !src.test ) {
				return false;
			}

			return true;
		}

		function placeholder( input, id, replacement, callback ) {
			var output,
				rComment = new RegExp( '<!-- ' + id + ' -->', 'm' );
			if ( typeof replacement === 'function' ) {
				replacement( function ( response ) {
					output = input.replace( rComment, response );
					callback( output );
				} );
			} else {
				output = input.replace( rComment, replacement );
				callback( output );
			}
		}

		function addModules( load ) {
			var module, moduleStyles, moduleScripts, dependency, dependencies;
			dependencies = moduleUtils.buildDependencyList( modules, load );
			for ( dependency in dependencies ) {
				module = dependencies[ dependency ];
				if ( loadedModules.indexOf( module ) > -1 ) {
					continue;
				}
				loadedModules.push( module );
				if ( modules[ module ].scripts ) {
					moduleScripts = modules[ module ].scripts
						.map( expand ).filter( filter.bind( this, 'scripts' ) ).map( scriptTag )
						.join( '\n' );
					if ( moduleScripts ) {
						scripts.push( indent + '<!-- ' + module + ' -->\n' + moduleScripts );
					}
				}
				if ( modules[ module ].styles ) {
					moduleStyles = modules[ module ].styles
						.map( expand ).filter( filter.bind( this, 'styles' ) ).map( styleTag.bind( styleTag, modules[ module ].styleGroup ) )
						.join( '\n' );
					if ( moduleStyles ) {
						styles.push( indent + '<!-- ' + module + ' -->\n' + moduleStyles );
					}
				}
			}
		}

		addModules( load );

		if ( i18n.length || demoPages ) {
			configScript = indent + '<script>\n';

			if ( i18n.length ) {
				configScript += indent + '\tve.messagePaths = ' +
					JSON.stringify(
						i18n.map( function ( path ) { return pathPrefix + path; } )
					) + ';\n';

				if ( langList ) {
					configScript += indent + '\tve.availableLanguages = ' +
						JSON.stringify(
							grunt.file.expand(
								i18n.map( function ( path ) { return path + '*.json'; } )
							).map( function ( file ) {
								return file.split( '/' ).pop().slice( 0, -5 );
							} )
						) +
						';\n';
				}
			}
			if ( demoPages ) {
				configScript += indent + '\tve.demoPages = ' + JSON.stringify( demoPages ) + ';\n';
			}

			configScript += indent + '</script>';
			scripts.push( configScript );
		}

		addModules( run );

		placeholders.styles = styles.join( '\n\n' );
		placeholders.scripts = scripts.join( '\n\n' );
		placeholders.dir = dir;

		grunt.util.async.forEachSeries(
			Object.keys( placeholders ),
			function ( id, next ) {
				placeholder( text, id.toUpperCase(), placeholders[ id ], function ( newText ) {
					text = newText;
					next();
				} );
			},
			function () {
				grunt.file.write( targetFile, text );
				grunt.log.ok( 'File "' + targetFile + '" written.' );

				done();
			}
		);

	} );

};
