define( 'views.videohomepage.search', [
		'jquery',
		'wikia.tracker'
	], function( $, Tracker ) {
		'use strict';

		function SearchView() {
			this.$el = $( '#WikiaSearch' );

			this.track = Tracker.buildTrackingFunction({
				action: Tracker.ACTIONS.CLICK,
				category: 'video-home-page',
				trackingMethod: 'both'
			});

			this.init();
		}

		SearchView.prototype.init = function() {
			var that = this;
			this.$el.on( 'click', function() {
					that.track({ label: 'search-box' });
			});
		};

		return SearchView;
});
