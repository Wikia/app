define( 'views.videopageadmin.autocomplete', [
		'jquery',
		'views.videopageadmin.autocompleteitem'
	], function( $, CategorySingleResultView ) {
	'use strict';
	var AutocompleteView = Backbone.View.extend({
			initialize: function() {
				var that = this;

				this.$input = this.$( 'input[ data-autocomplete ]' );

				_.bindAll( this, 'clearResults', 'renderResults', 'setValue' );

				// hide menu when clicked outside
				$( 'body' ).click(function() {
						if ( that.results && that.results.length ) {
							that.trigger( 'results:hide' );
						}
				});

				this.on( 'results:hide', this.clearResults );
				this.collection.on( 'reset', this.renderResults );
				this.collection.on( 'category:chosen', this.setValue );
			},
			events: {
				'click input[data-autocomplete]': 'absorbEvent',
				'keyup input[data-autocomplete]': 'handleKeyUp',
				'keydown input[data-autocomplete]': 'preventKeybinds'
			},
			absorbEvent: function( evt ) {
				evt.stopPropagation();
			},
			preventKeybinds: function( evt ) {
				var key = evt.keyCode;
				if ( key === 13 || key === 10 ) {
					return false;
				}
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
					this.clearResults();
				} else if ( keyCode === 50 ) {
					//TODO: trigger collection reset by pressing '2', remove later
					this.collection.reset([
							{ name: 'foo' },
							{ name: 'bar' },
							{ name: 'baz' },
							{ name: 'foo' },
							{ name: 'bar' },
							{ name: 'baz' },
							{ name: 'foo' },
							{ name: 'bar' }
					]);
				} else if ( keyCode === 13 ) {
					// if user presses RET, select highlighted
					this.getSelection();
				} else if ( $val.length > 2 ) {
					// collection fetch
					console.log( 'Implement collection fetch' );
				}
			},
			getSelection: function() {
				if ( !this.$results ) { return false; }

				var category = this.$results.find( '.selected' ).text();

				if ( category.length ) {
					this.collection.setCategory( $.trim( category ) );
				}

				// trigger Search button now, or collection fetch
			},
			setValue: function( categoryName ) {
				this.$input.val( categoryName );
				this.clearResults();
			},
			clearResults: function() {
				this.results.map(function( subView ) {
						return subView.remove();
				});

				this.results = [];
				this.$results.html( '' ).hide();
			},
			renderResults: function() {
				var that,
						view;

				that = this;

				this.$results = this.$( '.autocomplete' );
				this.$results.html( '' ).show();

				this.results = [];

				this.collection.each( function( model ) {
						view = new CategorySingleResultView({
								model: model,
								parentView: that
						});
						that.results.push( view );
						that.$results.append( view.render().$el );
				});

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

				// up arrow
				if ( key === 38 ) {
					if ( idx === 0 ) {
						$selected.removeClass( 'selected' );
					} else {
						$newSelection = $selected.prev();
					}

				// down arrow 
				} else if ( key === 40 ) {
					if ( idx === -1 ) {
						$newSelection = $categories.eq( 0 );
					} else if ( idx >= 0 ) {
						$newSelection = $selected.next();
					}
				}

				if ( $newSelection ) {
					$newSelection.addClass( 'selected' ).siblings().removeClass( 'selected' );
				}
			},
	});

	return AutocompleteView;
});
