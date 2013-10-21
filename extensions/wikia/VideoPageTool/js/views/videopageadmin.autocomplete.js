define( 'views.videopageadmin.autocomplete', [
		'jquery',
		'views.videopageadmin.autocompleteitem'
	], function( $, CategorySingleResultView ) {
	'use strict';
	var AutocompleteView = Backbone.View.extend({
			initialize: function() {
				console.log(this);
				this.collection.on( 'reset', this.renderResults, this );
			},
			events: {
				'keyup input[data-autocomplete]': 'handleKeyUp',
				'keydown input[data-autocomplete]': 'preventKeybinds'
			},
			handleKeyUp: function( evt ) {
				evt.preventDefault();
				var $tar,
						$val,
						keyCode;

				$tar = $( evt.target );
				keyCode = evt.keyCode;
				$val = $tar.val();

				if ( keyCode === 38 || keyCode === 40 ) {
					this.selectListItem( keyCode );
				} else if ( keyCode === 27 ) {
					// if user presses ESC, clear field
					$tar.val( '' );
				} else if ( keyCode === 13 ) {
					// if user presses RET, select highlighted
					this.collection.reset([{ name: 'foo' }, { name: 'bar' }, { name: 'baz' }, { name: 'qux' }]);
				} else if ( $val.length > 2 ) {
					// collection fetch
				}
			},
			preventKeybinds: function( evt ) {
				var key = evt.keyCode;
				if ( key === 13 || key === 10 ) {
					return false;
				}
			},
			renderResults: function() {
				var $ul,
						view;

				this.$el.find( '.autocomplete-results' ).remove();
				$ul = $( '<ul>' ).addClass( 'autocomplete-results' );
				this.collection.each( function( model ) {
						view = new CategorySingleResultView({
								model: model
						});
						$ul.append( view.render().$el );
				});

				this.$el.append( $ul );

				return this;
			},
			selectListItem: function( key ) {
				var $categories,
						$selected,
						$newSelection,
						idx;

				$categories = this.$el.find( '.autocomplete-item' );

				if ( !$categories.length ) { return; }

				$selected = $categories.closest( '.selected' );

				idx = _.indexOf( $categories, $selected.get(0) );

				if ( key === 38 ) {

					if ( idx === 0 ) {
						$selected.removeClass( 'selected' ).css( 'color', 'black' );
					} else {
						$newSelection = $selected.prev();
					}

				} else if ( key === 40 ) {

					if ( idx === -1 ) {
						$newSelection = $categories.eq( 0 );
					} else if ( idx >= 0 ) {
						$newSelection = $selected.next();
					}

				}

				if ( $newSelection ) {
					$newSelection
						.css( 'color', 'salmon' )
						.addClass( 'selected' )
						.siblings()
						.css( 'color', 'black' )
						.removeClass( 'selected' );
					}
			}
	});

	return AutocompleteView;
});
