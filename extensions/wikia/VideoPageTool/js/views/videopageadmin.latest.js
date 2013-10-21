define( 'views.videopageadmin.latest', [
		'jquery',
		'collections.videopageadmin.category',
		'views.videopageadmin.latestforms'
	], function( $, CategoryCollection, FormGroupView ) {
	'use strict';

	var LatestVideosView = Backbone.View.extend({
			initialize: function() {
				this.$formGroups = this.$el.find('.form-box');
				this.formSubViews = _.map( this.$formGroups, function( e ) {
						return new FormGroupView({
								el: e,
								collection: new CategoryCollection()
						});
				});
			},
			events: {
			},
	});

	return LatestVideosView;
});

$(function () {
		'use strict';
		require([ 'views.videopageadmin.latest' ], function( LatestVideosView ) {
				new LatestVideosView({
						el: '#LatestVideos'
				});
		});
});
