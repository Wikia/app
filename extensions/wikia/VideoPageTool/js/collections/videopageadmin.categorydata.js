define( 'videopageadmin.collections.categorydata', [
], function() {
	'use strict';

	var CategoryCollection = Backbone.Collection.extend( {
		url: '/wikia.php',
		initialize: function() {
			_.bindAll( this, 'setCategory', 'fetch' );
			this.controller = 'VideoPageAdminSpecial';
			this.method = 'getVideosByCategory';
			this.format = 'json';
			this.categoryName = null;
			this.response = null;
		},

		/**
		 * @method
		 * @description override fetch with our decorated version,
		 * must specify custom parse method to properly reset collection
		 */
		fetch: function() {
			return Backbone.Collection.prototype.fetch.call( this, {
				data: {
					controller: this.controller,
					format: this.format,
					method: this.method,
					categoryName: this.categoryName
				}
			} );
		},

		// custom parse to maintain collection lifecycle events
		parse: function( resp ) {
			// cache the response
			this.response = resp;
			this.reset( this.response.videos );
		},

		/**
		 * @method
		 * @description sets the category as a property on the collection then performs fetch
		 * @param { string } name name of the category
		 */
		setCategory: function( name ) {
			if ( typeof name === 'string' ) {
				this.categoryName = name;
				this.fetch();
			}
		}
	} );

	return CategoryCollection;
} );
