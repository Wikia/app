define( 'views.videopageadmin.autocompleteitem', [
		'jquery',
	], function( $, TemplateCache ) {
		'use strict';

		var CategorySingleResultView = Backbone.View.extend({
				initialize: function( opts ) {
					this.parentView = opts.parentView;
				},
				tagName: 'div',
				className: 'autocomplete-item',
				template: Mustache.compile( $( '#autocomplete-item' ).html() ),
				events: {
					'hover': 'onHover',
					'click': 'select'
				},
				onHover: function() {
					this.$el.addClass( 'selected' ).siblings().removeClass( 'selected' );
				},
				select: function( evt ) {
					evt.stopPropagation();
					this.model.collection.setCategory( this.model.get( 'name' ) );
					this.parentView.trigger( 'results:hide' );
				},
				render: function() {
					var html = this.template( this.model.toJSON() );
					this.$el.html( html );
					return this;
				}
		});

		return CategorySingleResultView;
});
