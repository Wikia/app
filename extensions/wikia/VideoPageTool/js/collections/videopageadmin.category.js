define( 'collections.videopageadmin.category', [
		'models.videopageadmin.category'
	], function( CategoryModel ) {
		'use strict';

		var CategoryCollection = Backbone.Collection.extend({
				model: CategoryModel,
				url: '/wikia.php',
				initialize: function() {
					_.bindAll( this, 'setCategory', 'autocomplete' );
					this.controller = 'CategorySelect';
					this.method = 'getWikiCategories';
				},
				setCategory: function( model ) {
					this.selectedCategory = model.get( 'name' );
					this.trigger( 'category:chosen' );
				},
				autocomplete: function( value ) {
					if ( this.xhr ) this.xhr.abort();
					this.query = value.toLowerCase();

					if ( !this.raw || !this.raw.length ) {
						this.xhr = this.fetch({
							reset: true,
							data: {
								controller: this.controller,
								method:  this.method
							}
						});
					} else {
						this.parse( this.raw );
						this.reset( this.parse() );
					}
				},
				parse: function( resp ) {
					var cache = [],
							self = this;

					if ( this.raw && this.raw.length ) {
						resp = this.raw;
					} else {
						this.raw = resp;
					}

					_.each( resp, function( itemName ) {
						if ( itemName.toLowerCase().indexOf( self.query ) != -1 ) {
							cache.push({
								name: itemName
							});
						}
					});

					return cache;
				}
		});

		return CategoryCollection;
});
