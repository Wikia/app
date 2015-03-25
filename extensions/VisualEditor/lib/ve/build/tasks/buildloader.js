/*!
 * Build a static loader file from a template
 */

/*jshint node:true */
module.exports = function ( grunt ) {

	grunt.registerMultiTask( 'buildloader', function () {
		var i, len,
			module,
			dependency,
			dependencies,
			moduleStyles,
			moduleScripts,
			i18nScript,
			styles = [],
			scripts = [],
			targetFile = this.data.targetFile,
			pathPrefix = this.data.pathPrefix || '',
			i18n = this.data.i18n || [],
			indent = this.data.indent || '',
			modules = this.data.modules,
			load = this.data.load,
			env = this.data.env || {},
			placeholders = this.data.placeholders || {},
			text = grunt.file.read( this.data.template ),
			done = this.async(),
			moduleUtils = require( '../moduleUtils' );

		function scriptTag( src ) {
			return indent + '<script src="' + pathPrefix + src.file + '"></script>';
		}

		function styleTag( src ) {
			var rtlFilepath = src.file.replace( /\.css$/, '.rtl.css' );

			if ( grunt.file.exists( rtlFilepath ) ) {
				return indent + '<link rel=stylesheet href="' + pathPrefix + src.file + '" class="stylesheet-ltr">\n' +
					indent + '<link rel=stylesheet href="' + pathPrefix + rtlFilepath + '" class="stylesheet-rtl" disabled>';
			}
			return indent + '<link rel=stylesheet href="' + pathPrefix + src.file + '">';
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

		dependencies = moduleUtils.buildDependencyList( modules, load );
		for ( dependency in dependencies ) {
			module = dependencies[dependency];
			if ( modules[module].scripts ) {
				moduleScripts = modules[module].scripts
					.map( expand ).filter( filter.bind( this, 'scripts' ) ).map( scriptTag )
					.join( '\n' );
				if ( moduleScripts ) {
					scripts.push( indent + '<!-- ' + module + ' -->\n' + moduleScripts );
				}
			}
			if ( modules[module].styles ) {
				moduleStyles = modules[module].styles
					.map( expand ).filter( filter.bind( this, 'styles' ) ).map( styleTag )
					.join( '\n' );
				if ( moduleStyles ) {
					styles.push( indent + '<!-- ' + module + ' -->\n' + moduleStyles );
				}
			}
		}

		if ( i18n.length ) {
			i18nScript = indent + '<script>\n';
			for ( i = 0, len = i18n.length; i < len; i++ ) {
				i18nScript += indent + '\tve.init.platform.addMessagePath( \'' + pathPrefix + i18n[i] + '\' );\n';
			}
			i18nScript += indent + '\tve.availableLanguages = ' +
				JSON.stringify(
					grunt.file.expand(
						i18n.map( function ( path ) { return path + '*.json'; } )
					).map( function ( file ) {
						return file.split( '/' ).pop().slice( 0, -5 );
					} )
				) +
				';\n';
			i18nScript += indent + '</script>';
			scripts.push( i18nScript );
		}

		placeholders.styles = styles.join( '\n\n' );
		placeholders.scripts = scripts.join( '\n\n' );

		grunt.util.async.forEachSeries(
			Object.keys( placeholders ),
			function ( id, next ) {
				placeholder( text, id.toUpperCase(), placeholders[id], function ( newText ) {
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
