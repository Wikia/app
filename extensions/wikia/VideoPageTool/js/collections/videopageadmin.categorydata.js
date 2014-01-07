define( 'collections.videopageadmin.categorydata', [
	], function() {
		'use strict';

		var CategoryCollection = Backbone.Collection.extend({
				url: '/wikia.php',
				initialize: function() {
					this.controller = 'VideoPageAdminSpecial';
					this.method = 'getCategoryData';
					this.format = 'json';
					this.categoryName = null;
				},
				fetch: function() {
					return Backbone.Collection.prototype.fetch.call( this, {
						data: {
							controller: this.controller,
							format: this.format,
							method: this.method,
							categoryName: this.categoryName
						}
					});
				},
				setCategory: function( name, doFetch ) {
					console.log( 'hi', typeof name );
					if ( typeof name === 'string' ) {
						this.categoryName = name;
						this.fetch();
					}
				}
		});

		return CategoryCollection;
});
