(function( window, $, undefined ) {

var action = window.wgAction,
	wgCategorySelect = window.wgCategorySelect,
	Wikia = window.Wikia || {};

/**
 * CategorySelect
 * Low-level category tracking.
 *
 * @param {Array} (categories)
 *        The initial list of categories.
 */
var CategorySelect = function( categories ) {
	var i, length;

	// Protect against calling without the 'new' operator
	if ( !( this instanceof CategorySelect ) ) {
		return new CategorySelect( categories );
	}

	this.state = {};
	this.state.categories = [];

	if ( $.isArray( categories ) ) {
		for ( i = 0, length = categories.length; i < length; i++ ) {
			this.state.categories.push( this.makeCategory( categories[ i ] ) );
		}
	}

	this.state.length = this.state.categories.length;

	/**
	 * Resets categories back to what they were on instantiation.
	 *
	 * @returns	{Number}
	 *          The new length of the categories array.
	 */
	this.reset = function() {
		this.state.categories = categories;
		return this.state.length = categories.length;
	};
};

/**
 * Adds a category to the categories array.
 *
 * @param {String|Object} category
 *        The name of a category or an object with category properties.
 *
 * @returns	{Number}
 *          The index of the added category, or -1 if the category could not be added.
 */
CategorySelect.prototype.addCategory = function( category ) {
	var index;

	category = this.makeCategory( category );
	index = this.indexOf( category.name );

	// Don't add invalid or duplicate categories
	if ( category != null && index < 0 ) {
		index = this.state.categories.push( category ) - 1;
		this.state.length++;
	}

	return index;
};

/**
 * Edits a category from the categories array.
 *
 * @param {Number|String} category
 *        The index or name of a category.
 *
 * @param {Object} value
 *        The new category object or null if the category does not exist.
 *
 * @returns	{Object}
 *          The category object or null if the category does not exist.
 */
CategorySelect.prototype.editCategory = function( category, value ) {
	var index = this.indexOf( category );

	category = null;

	if ( index >= 0 ) {
		category = this.state.categories[ index ] = this.makeCategory( value );
	}

	return category;
};

/**
 * Gets a category from the categories array.
 *
 * @param {Number|String} category
 *        The index or name of a category.
 *
 * @returns	{Object}
 *			The category object or null if the category does not exist.
 */
CategorySelect.prototype.getCategory = function( category ) {
	var index = this.indexOf( category );

	category = null;

	if ( index >= 0 ) {
		category = this.state.categories[ index ];
	}

	return category;
};

/**
 * Gets the index of a category from the category array.
 *
 * @param {Number|String} category
 *        The index or name of a category.
 *
 * @returns	{Number}
 *          The index of the category, or -1 if the category does not exist.
 */
CategorySelect.prototype.indexOf = function( category ) {
	var i, length, obj,
		index = parseInt( category );

	if ( isNaN( index ) || this.state.categories[ index ] === undefined ) {
		index = -1;

		for ( i = 0, length = this.state.categories.length; i < length; i++ ) {
			if ( ( obj = this.state.categories[ i ] ) && obj.name == category ) {
				index = i;
				break;
			}
		}
	}

	return index;
};

/**
 * Generates a normalized category object.
 *
 * @param {Object|String} category
 *        The name of a category or an object with category properties.
 *
 * @returns {Object}
 *          The normalized category, or null if an invalid category was provided.
 */
CategorySelect.prototype.makeCategory = (function() {
	var properties = [ 'name', 'namespace', 'sortKey' ],
		rCategory = new RegExp( '\\[\\[' +
			// Category namespace
			'(' + wgCategorySelect.defaultNamespaces + '):' +
			// Category name
			'([^\\]|]+)' +
			// Category sortKey (optional)
			'\\|?([^\\]]+)?' +
		']]', 'i' );

	return function( category ) {
		var pieces, prop,
			base = {
				namespace: wgCategorySelect.defaultNamespace,
				sortKey: wgCategorySelect.defaultSortKey
			};

		if ( typeof category == 'object' ) {
			category = $.extend( base, category );

		} else {
			base.name = category;
			category = base;
		}

		// Must have a name to be valid
		if ( !category.name ) {
			category = null;

		} else {

			// Get rid of unecessary properties
			for ( prop in category ) {
				if ( $.inArray( prop, properties ) < 0 ) {
					delete category[ prop ];
				}
			}

			// Extract more information if name is a wikilink
			if ( ( pieces = rCategory.exec( category.name ) ) ) {
				category.namespace = pieces[ 1 ];
				category.name = pieces[ 2 ];

				// SortKey is optional
				if ( pieces[ 3 ] != undefined ) {
					category.sortKey = pieces[ 3 ];
				}
			}
		}

		return category;
	}
})();

/**
 * Move a category from one position in the array to another.
 *
 * @param {Number|String} fromCategory
 *        The index of a category in the categories array or a string matching a
 *        category in the array where the category will be moved from.
 *
 * @param {Number|String} toCategory
 *        The index of a category in the categories array or a string matching a
 *        category in the array where the category will be moved to.
 *
 * @returns {Object}
 *          The re-ordered categories array.
 */
CategorySelect.prototype.moveCategory = function( fromCategory, toCategory ) {
	var category, categoryToMove, i,
		categories = [],
		fromIndex = this.indexOf( fromCategory ),
		length = this.state.categories.length,
		toIndex = this.indexOf( toCategory );

	// Make sure indexes are valid
	if ( fromIndex != toIndex && fromIndex >= 0 && toIndex >= 0 ) {
		categoryToMove = this.state.categories[ fromIndex ];

		for ( i = 0; i < length; i++ ) {
			if ( i == toIndex ) {
				categories.push( categoryToMove );
			}

			// Throw out null values
			if ( i != fromIndex && ( category = this.state.categories[ i ] ) != null ) {
				categories.push( category );
			}
		}

		this.state.categories = categories;
		this.state.length = categories.length;
	}

	return this.state.categories;
};

/**
 * Removes a category from the categories array.
 *
 * @param {Number|String} category
 *        The index of a category in the categories array or a string matching a
 *        category in the array.
 *
 * @returns {Object}
 *          The category object or null if the category does not exist.
 */
CategorySelect.prototype.removeCategory = function( category ) {
	var index = this.indexOf( category );

	category = null;

	if ( index >= 0 ) {
		category = this.state.categories.splice( index, 1, null );
		this.state.length--;
	}

	return category;
};

/**
 * jQuery.fn.categorySelect
 * Sits on top of CategorySelect and provides user interface components.
 *
 * @param {Object} options
 *        The settings to configure the instance with.
 */
$.fn.categorySelect = (function() {
	var cache = {},
		namespace = 'categorySelect';

	// Build static method cache
	cache.messages = {
		categoryEdit: $.msg( 'categoryselect-category-edit' ),
		categoryNameLabel: $.msg( 'categoryselect-modal-category-name' ),
		categoryRemove: $.msg( 'categoryselect-category-remove' ),
		modalButtonSave: $.msg( 'categoryselect-button-save' ),
		modalEmptyCategoryName: $.msg( 'categoryselect-modal-category-name-empty' )
	};

	// Build static template cache (content is lazy loaded)
	cache.templates = {
		category: {
			content: '',
			data: {
				blankImageUrl: window.wgBlankImgUrl,
				className: 'normal new',
				messages: {
					edit: cache.messages.categoryEdit,
					remove: cache.messages.categoryRemove
				}
			}
		},
		categoryEdit: {
			content: '',
			data: {
				messages: {
					name: cache.messages.categoryNameLabel
				}
			}
		}
	};

	function error( message ) {
		throw namespace + ': ' + message;
	}

	function getTemplate( name ) {
		var template = cache.templates[ name ];

		if ( !template ) {
			error( 'Template "' + name + '" is not defined' );
		}

		return template.content && template || $.Deferred(function( dfd ) {
			Wikia.getMultiTypePackage({
				mustache: 'extensions/wikia/CategorySelect/templates/CategorySelectController_' + name + '.mustache',
				callback: function( pkg ) {
					template.content = pkg.mustache[ 0 ];
					dfd.resolve( template );
				}
			});

			return dfd.promise();
		});
	}

	function getWikiCategories() {
		return cache.wikiCategories || $.nirvana.sendRequest({
			controller: 'CategorySelectController',
			method: 'getWikiCategories',
			type: 'GET',
			callback: function( wikiCategories ) {
				cache.wikiCategories = wikiCategories;
			}
		});
	}

	return function( options ) {
		options = $.extend( {}, $.fn.categorySelect.options, options );

		return this.each(function() {
			var popover,
				categories = [],
				$element = $( this ),
				$addCategory = $element.find( options.addCategory ),
				$categories = $element.find( options.categories ),
				categorySelect = new CategorySelect( options.data );

			$element
				.data( namespace, categorySelect )
				.off( '.' + namespace )
				.on( 'reset.' + namespace, reset )
				.on( 'click.' + namespace, options.editCategory, editCategory )
				.on( 'click.' + namespace, options.removeCategory, removeCategory );

			$addCategory
				.on( 'keypress.' + namespace, addCategory )
				.on( 'blur.' + namespace, function( event ) {
					$addCategory.popover( 'hide' );
				})
				.popover( $.extend( options.popover, {
					trigger: 'manual'
				}));

			popover = $addCategory.data( 'popover' );

			// Setup sortable
			if ( options.sortable ) {
				$categories.sortable( $.extend( options.sortable, {
					update: function ( event, ui ) {
						var categories = categorySelect.state.categories,
							fromIndex = ui.item.data( 'index' ),
							category = categories[ fromIndex ],
							toIndex = ui.item.next( '.category' );

						if ( toIndex.length ) {
							toIndex = toIndex.data( 'index' );

						} else {
							toIndex = categories.length - 1;
						}

						// Update categories array
						categorySelect.moveCategory( fromIndex, toIndex );

						// Update list item indexes
						$categories.find( options.category ).each(function( i ) {
							$( this ).data( 'index', i );
						});

						notifyListeners( 'sort', {
							category: category,
							element: ui.item,
							fromIndex: fromIndex,
							toIndex: toIndex
						});

						notifyListeners( 'update' );
					}
				}));
			}

			// Setup autocomplete immediately if addCategory contains a value
			if ( $addCategory.val() != '' ) {
				setupAutocomplete.call( $addCategory );

			} else {
				$element.one( 'focus.' + namespace, options.addCategory, setupAutocomplete );
			}

			function addCategory( event, ui ) {
				var category, index, length,
					$input = $( this ),
					value = ui != undefined ? ui.item.value : $input.val();

				// User selected a suggested item from the autocomplete list
				if ( event.type == 'autocompleteselect'

					// User pressed the enter key in the input field
					|| ( event.type == 'keypress' && event.which == 13 ) ) {

					// Prevent the edit form from submitting
					event.preventDefault();

					// Make sure value isn't empty
					if ( value != undefined && value != '' ) {
						length = categorySelect.state.length;
						category = categorySelect.makeCategory( value );
						index = categorySelect.addCategory( category );

						// Category is a duplicate
						if ( length == categorySelect.state.length ) {
							popover.options.content = $.msg( 'categoryselect-error-duplicate-category', category.name );
							$input.popover( 'show' ).val( value );

						} else {
							$.when( getTemplate( 'category' ) ).done(function( template ) {
								template.data.category = category;
								template.data.index = index;

								notifyListeners( 'add', {
									category: category,
									element: $categories,
									index: index,
									template: template
								});

								notifyListeners( 'update' );
							});

							// Clear out the input
							$input.popover( 'hide' ).val( '' );
						}
					}
				}
			}

			function editCategory( event ) {
				var $modal,
					$category = $( this ).closest( options.category ),
					index = $category.data( 'index' ),
					category = categorySelect.getCategory( index );

				$.when( getTemplate( 'categoryEdit' ) ).done(function( template ) {
					template.data.category = category;
					template.data.index = index;
					template.data.messages.sortKey = $.msg( 'categoryselect-modal-category-sortkey', category.name );

					$modal = $.showCustomModal( cache.messages.categoryEdit, Mustache.render( template.content, template.data ), {
						buttons: [
							{
								id: 'CategorySelectEditModalSave',
								defaultButton: true,
								message: cache.messages.modalButtonSave,
								handler: function( event ) {
									category.name = $modal.find( '[name="categoryName"]' ).val();
									category.sortKey = $modal.find( '[name="categorySortKey"]' ).val();

									// Don't allow saving with empty category name
									if ( category.name == '' ) {
										$modal
											.find( '.categoryName' ).addClass( 'error' )
											.find( '.error-msg' ).text( cache.messages.modalEmptyCategoryName );
										return;
									}

									// Update data
									category = categorySelect.editCategory( index, category );

									// Update DOM
									$category.find( '.name' ).text( category.name );

									notifyListeners( 'edit', {
										category: category,
										element: $category,
										index: index
									});

									notifyListeners( 'update' );

									$modal.closeModal();
								}
							}
						],
						id: 'CategorySelectEditModal',
						width: 500
					});
				});
			}

			function notifyListeners( eventType, data ) {
				$element.triggerHandler( eventType + '.' + namespace , [ categorySelect.state ].concat( data ) );
			}

			function removeCategory( event ) {
				var $category = $( this ).closest( options.category ),
					index = $category.data( 'index' );

				notifyListeners( 'remove', {
					category: categorySelect.removeCategory( index ),
					element: $category,
					index: index
				});

				notifyListeners( 'update' );
			}

			function reset( event ) {
				categorySelect.reset();

				notifyListeners( 'update' );
			}

			function setupAutocomplete( event ) {
				var $input = $( this );

				$.when( getWikiCategories() ).done(function( wikiCategories ) {
					$input.autocomplete( $.extend( options.autocomplete, {
						select: addCategory,

						// Handle source ourselves so we can limit the number of suggestions
						source: function( request, response ) {
							var suggestions = $.ui.autocomplete.filter( wikiCategories, request.term );
							response( suggestions.slice( 0, options.autocomplete.maxSuggestions ) );
						}
					}));

					// Open suggestion menu immediately if not initiated by event
					if ( !event ) {
						$input.autocomplete( 'search' );
					}
				});
			}
		});
	}
})();

$.fn.categorySelect.options = {
	autocomplete: {
		appendTo: '.CategorySelect',
		maxSuggestions: 10
	},
	categories: '.categories',
	category: '.category',
	data: [],
	addCategory: '.addCategory',
	editCategory: '.editCategory',
	popover: {

	},
	removeCategory: '.removeCategory',
	sortable: {
		axis: 'y',
		containment: 'parent',
		handle: '.name',
		items: '.category',
		placeholder: 'placeholder',
		tolerance: 'pointer'
	}
};

/**
 * Exports
 */
Wikia.CategorySelect = CategorySelect;
window.Wikia = Wikia;

})( window, jQuery );