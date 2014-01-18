define( 'videohomepage.collections.featuredslides', [
		'videohomepage.models.slide'
	], function( SlideModel ) {
		'use strict';

		var SlideCollection = Backbone.Collection.extend({
				model: SlideModel,
				resetEmbedData: function() {
					_.each( this.models, function( e ) {
							e.set({
									embedData: null
							} );
					} );
				}
		} );

		return SlideCollection;
} );
