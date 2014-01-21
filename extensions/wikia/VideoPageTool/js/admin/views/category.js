define( 'videopageadmin.views.category', [
		'jquery',
		'videopageadmin.collections.category',
		'videopageadmin.views.categoryforms',
		'videopageadmin.views.editbase',
		'videopageadmin.models.validator'
	], function( $, CategoryCollection, FormGroupView, EditBaseView, Validator ) {
	'use strict';

	var CategoryPageView = EditBaseView.extend( {
		initialize: function() {
			EditBaseView.prototype.initialize.call( this, arguments );
			this.categories = new CategoryCollection();
			this.$formFields = this.$el.find( '.category-name' );
			this.$formGroups = this.$el.find( '.form-wrapper' );

			_.bindAll( this, 'render', 'initValidator' );
			this.initValidator();
			this.categories.on( 'reset', this.render );
		},
		render: function() {
			var self = this;
			this.formSubViews = _.map( this.$formGroups, function( e ) {
				return new FormGroupView( {
					el: e,
					categories: new CategoryCollection( self.categories.toJSON() )
				} );
			} );
			return this;
		},
		initValidator: function() {
			this.validator = new Validator( {
				form: this.$el,
				formFields: this.$formFields
			} );

			// If the back end has thrown an error, run the front end validation on page load
			if( $( '#vpt-form-error' ).length ) {
				this.validator.formIsValid();
			}

		}
	} );

	return CategoryPageView;
} );