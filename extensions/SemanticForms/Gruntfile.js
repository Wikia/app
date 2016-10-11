/*jshint node:true */
module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-jsonlint' );
	// grunt.loadNpmTasks( 'grunt-banana-checker' );

	grunt.initConfig( {
		jshint: {
			options: {
				jshintrc: true
			},
			all: [
				'**/*.js',
				'!node_modules/**',
				'!libs/jquery.browser.js',
				'!libs/jquery.dynatree.js',
				'!libs/jquery.fancybox.js',
				'!libs/select2.js',
				'!libs/SF_maps.js'
			]
		},
		// banana: {
			// all: 'i18n/'
		// },
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**'
			]
		}
	} );

	grunt.registerTask( 'test', [ 'jshint', 'jsonlint' /* 'banana' */ ] );
	grunt.registerTask( 'default', 'test' );
};
