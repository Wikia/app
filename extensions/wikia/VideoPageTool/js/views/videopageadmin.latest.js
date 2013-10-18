define( 'views.videopageadmin.latest', [
		'jquery',
		'views.videopageadmin.latestforms'
	], function( $, FormGroupView ) {
	'use strict';

	var LatestVideosView = Backbone.View.extend({
			initialize: function() {
				this.formGroups = this.$el.find('.form-box');
				this.formSubViews = _.map( this.formGroups, function( e, i, l) {
						return new FormGroupView({
								el: e
						});
				}); 

				console.log(this.formSubViews);
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
