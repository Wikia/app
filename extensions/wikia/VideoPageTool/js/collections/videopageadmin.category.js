define( 'collections.videopageadmin.category', [
		'models.videopageadmin.category'
	], function( CategoryModel ) {
		'use strict';

		var CategoryCollection = Backbone.Collection.extend({
				model: CategoryModel,
				initialize: function() {
					_.bindAll( this, 'setCategory' );
				},
				setCategory: function( category ) {
					this.trigger( 'category:chosen', category );
				}
		});

		return CategoryCollection;
});
