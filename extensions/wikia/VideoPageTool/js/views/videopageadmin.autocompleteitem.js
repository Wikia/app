define( 'views.videopageadmin.autocompleteitem', [
		'jquery',
		'underscore.templatecache'
	], function( $, TemplateCache ) {
		'use strict';

		var CategorySingleResultView = Backbone.View.extend({
				initialize: function() {
				},
				tagName: 'li',
				className: 'autocomplete-item',
				template: TemplateCache.get( '#autocomplete-item' ),
				render: function() {
					var html = this.template( this.model.toJSON() );
					this.$el.html( html );
					return this;
				}
		});

		return CategorySingleResultView;
});
