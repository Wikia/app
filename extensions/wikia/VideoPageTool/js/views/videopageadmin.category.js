define( 'views.videopageadmin.category', [
		'jquery',
		'views.videopageadmin.categoryforms'
	], function( $, FormGroupView ) {
	'use strict';

	var CategoryPageView = Backbone.View.extend({
			initialize: function() {
				this.$formGroups = this.$el.find('.form-box');
				this.formSubViews = _.map( this.$formGroups, function( e ) {
						return new FormGroupView({
								el: e
						});
				});
			},
			events: {
			},
	});

	return CategoryPageView;
});

$(function () {
		'use strict';
		require([ 'views.videopageadmin.category' ], function( CategoryPageView ) {
				new CategoryPageView({
						el: '#LatestVideos'
				});
		});
});
