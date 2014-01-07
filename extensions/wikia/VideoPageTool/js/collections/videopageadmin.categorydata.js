define( 'collections.videopageadmin.categorydata', [
	], function() {
		'use strict';

		var CategoryCollection = Backbone.Collection.extend({
				url: '/wikia.php',
				initialize: function() {
					// _.bindAll( this, 'setCategory', 'autocomplete' );
					this.controller = 'VideoPageAdminSpecial';
					this.method = 'getCategoryData';
				},
				fetch: function( data ) {
					return Backbone.Collection.prototype.fetch.call( this, {
						data: {
							controller: this.controller,
							method: this.method,
							categoryName: data.categoryName
						}
					});
				}
		});

		return CategoryCollection;
});
