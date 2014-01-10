define( 'collections.videohomepage.featuredslides', [
		'models.videohomepage.slide'
	], function( SlideModel ) {
		'use strict';

		var SlideCollection = Backbone.Collection.extend({
				model: SlideModel,
				resetEmbedData: function() {
					_.each( this.models, function( e ) {
							e.set({
									embedData: null
							});
					});
				}
		});

		return SlideCollection;
});
