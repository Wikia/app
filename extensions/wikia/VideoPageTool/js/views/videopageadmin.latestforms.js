define( 'views.videopageadmin.latestforms', [
		'jquery',
		'views.videopageadmin.autocomplete',
		'collections.videopageadmin.category'
	], function( $, AutocompleteView, CategoryCollection ) {
		'use strict';
		var FormGroupView = Backbone.View.extend({
				initialize: function() {
					this.autocomplete = new AutocompleteView({
							el: this.el,
							collection: new CategoryCollection()
					});
				},
		});

		return FormGroupView;
});
