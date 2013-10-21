define( 'collections.videopageadmin.category', [
		'models.videopageadmin.category'
	], function( CategoryModel ) {
		'use strict';

		var CategoryCollection = Backbone.Collection.extend({
				model: CategoryModel
		});

		return CategoryCollection;
});
