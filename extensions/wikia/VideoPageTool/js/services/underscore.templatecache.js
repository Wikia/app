define( 'underscore.templatecache', [
		'underscore',
		'jquery'
	], function( _, $ ) {
	'use strict';

	var app,
			utils;
			
	app = window.Wikia || {};

	/*
	 * TODO: unofficial monkey patch to Wikia namespace, since there's no 
	 * real place to put utility functions atm
	 */

	utils = app.utils || {};

	utils.templateCache = utils.templateCache || {
		get: function( selector ) {
			if ( !this.templates ) {
				this.templates = {};
			}

			var template = this.templates[ selector ];
			if ( !template ) {
				template = $( selector ).html();
				template = _.template( template );

				this.templates[ selector ] = template;
			}

			return template;
		}
	};

	return utils.templateCache;
});
