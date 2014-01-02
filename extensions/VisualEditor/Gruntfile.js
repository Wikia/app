/*!
 * Grunt file
 *
 * @package VisualEditor
 */

/*jshint node:true */
module.exports = function ( grunt ) {
	var fs = require( 'fs' ),
		exec = require( 'child_process' ).exec;

	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-csslint' );
	grunt.loadNpmTasks( 'grunt-contrib-qunit' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		jshint: {
			options: JSON.parse( grunt.file.read( '.jshintrc' )
				.replace( /\/\*(?:(?!\*\/)[\s\S])*\*\//g, '' ).replace( /\/\/[^\n\r]*/g, '' ) ),
			all: ['*.js', 'modules/**/*.js', 'wikia/**/*.js']
		},
		csslint: {
			options: {
				csslintrc: '.csslintrc'
			},
			all: ['modules/ve/**/*.css', 'wikia/**/*.css']
		},
		qunit: {
			all: ['modules/ve/test/index-phantomjs-tmp.html']
		},
		watch: {
			files: ['<%= jshint.all %>', '<%= csslint.all %>', '.{jshintrc,jshintignore,csslintrc}'],
			tasks: ['test']
		}
	} );

	grunt.registerTask( 'pre-qunit', function () {
		var done = this.async();
		grunt.file.setBase( __dirname + '/modules/ve/test' );
		exec( 'php index.php > index-phantomjs-tmp.html', function ( err, stdout, stderr ) {
			if ( err || stderr ) {
				grunt.log.error( err || stderr );
				done( false );
			} else {
				grunt.file.setBase( __dirname );
				done( true );
			}
		} );
	} );

	grunt.event.on( 'qunit.done', function () {
		fs.unlinkSync( __dirname + '/modules/ve/test/index-phantomjs-tmp.html' );
	} );

	grunt.registerTask( 'lint', ['jshint', 'csslint'] );
	grunt.registerTask( 'unit', ['pre-qunit', 'qunit'] );
	grunt.registerTask( 'test', ['lint', 'unit'] );
	grunt.registerTask( 'default', 'test' );
};
