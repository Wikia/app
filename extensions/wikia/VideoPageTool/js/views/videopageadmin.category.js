define( 'views.videopageadmin.category', [
		'jquery',
		'collections.videopageadmin.category',
		'views.videopageadmin.categoryforms'
	], function( $, CategoryCollection, FormGroupView ) {
	'use strict';

	var CategoryPageView = Backbone.View.extend( {
			initialize: function() {
				this.categories = new CategoryCollection();
				this.$formGroups = this.$el.find( '.form-box' );

				_.bindAll( this, 'render' );
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
			}
	} );

	return CategoryPageView;
} );

$(function () {
		'use strict';
		require([ 'views.videopageadmin.category' ], function( CategoryPageView ) {
				new CategoryPageView( {
						el: '#LatestVideos'
				} );
		} );
} );
