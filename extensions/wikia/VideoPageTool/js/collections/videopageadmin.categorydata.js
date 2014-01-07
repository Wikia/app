define( 'collections.videopageadmin.categorydata', [
	], function() {
		'use strict';

		var CategoryCollection = Backbone.Collection.extend({
				url: '/wikia.php',
				initialize: function() {
					this.controller = 'VideoPageAdminSpecial';
					this.method = 'getCategoryData';
					this.format = 'json';
				},
				fetch: function( data ) {
					return Backbone.Collection.prototype.fetch.call( this, {
						data: {
							controller: this.controller,
							format: this.format,
							method: this.method,
							categoryName: data.categoryName
						}
					});
				}
		});

		return CategoryCollection;
});
