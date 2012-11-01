(function( window, $, undefined ) {

var defaultNamespace = window.wgCategorySelect.defaultNamespace,
	defaultSortKey = window.wgCategorySelect.defaultSortKey || window.wgTitle,
	namespace = 'categorySelect',
	rCategory = new RegExp( '\\[\\[' +
		// Category namespace
		'(' + window.wgCategorySelect.validNamespaces + '):' +
		// Category name
		'([^\\]|]+)' +
		// Category sortKey (optional)
		'\\|?([^\\]]+)?' +
	']]', 'i' ),
	Wikia = window.Wikia || {};

/**
 * CategorySelect
 * Low-level category tracking.
 *
 * @param	{Array} (categories)
 *			The initial list of categories.
 */
var CategorySelect = function( categories ) {
	this.categories = categories || [];
};

/**
 * Adds a category to the categories array.
 *
 * @param	{String|Object} category
 *			The category to add.
 * @returns	{Number}
 *			The index of the added category.
 */
CategorySelect.prototype.addCategory = function( category ) {
	return ( this.categories.push( this.makeCategory( category ) ) - 1 );
};

/**
 * Edits a category from the categories array.
 *
 * @param	{Number|String} category
 *			The index of a category in the categories array or a string matching a
 *			category in the array.
 * @param	{String} value
 *			The new value of the category.
 */
CategorySelect.prototype.editCategory = function( category, value ) {
	var index = this.indexOf( category );

	if ( index >= 0 ) {
		this.categories[ index ] = this.makeCategory( value );
	}
};

/**
 * Gets a category from the categories array.
 *
 * @param	{Number|String} category
 *			The index of a category in the categories array or a string matching a
 *			category in the array.
 * @returns	{Object}
 *			The category object or undefined if the category could not be found.
 */
CategorySelect.prototype.getCategory = function( category ) {
	var index = this.indexOf( category );

	if ( index >= 0 ) {
		return this.categories[ index ];
	}
};

/**
 * Gets the index of a category from the category array.
 *
 * @param	{String} category
 *			The name of a category.
 * @returns	{Number}
 *			The index of the category, or -1 if the category was not be found.
 */
CategorySelect.prototype.indexOf = function( category ) {
	var i, length, obj,
		index = parseInt( category ) || -1;

	if ( ( index < 0 || this.categories[ index ] == undefined ) ) {
		for ( i = 0, length = this.categories.length; i < length; i++ ) {
			if ( ( obj = categories[ i ] ) && obj.name == category ) {
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
 * @param	{Object|String} category
 *			The name of a category or an object with category properties.
 * @returns {Object}
 *			The normalized category.
 */
CategorySelect.prototype.makeCategory = function( category ) {
	var pieces,
		base = {
			namespace: defaultNamespace,
			sortKey: defaultSortKey
		};

	if ( typeof category == 'object' ) {
		category = $.extend( base, category );

	} else {
		base.name = category;
		category = base;
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

	return category;
};

/**
 * Removes a category from the categories array.
 *
 * @param	{Number|String} category
 *			The index of a category in the categories array or a string matching a
 *			category in the array.
 * @returns {String}
 *			The value of the category that was removed, or undefined if the category
 *			could not be found.
 */
CategorySelect.prototype.removeCategory = function( category ) {
	var index = this.indexOf( category );

	if ( index >= 0 ) {
		return this.categories.splice( index, 1 );
	}
};

/**
 * jQuery.fn.categorySelect
 * Sits on top of CategorySelect and provides user interface components.
 *
 * @param	{Object} options
 *			The settings to configure the instance with.
 */
$.fn.categorySelect = (function() {
	var cache = {};

	function getCategories() {
		return cache.wikiCategories || $.nirvana.sendRequest({
			controller: 'CategorySelectController',
			method: 'getCategories',
			type: 'GET',
			callback: function( wikiCategories ) {
				cache.wikiCategories = wikiCategories;
			}
		});
	}

	return function( options ) {
		options = $.extend( {}, $.fn.categorySelect.options, options );

		return this.each(function() {
			var $element = $( this ),
				categorySelect = new CategorySelect( options.categories );

			function addCategory( event, ui ) {
				var category, index,
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
						category = categorySelect.makeCategory( value ),
						index = categorySelect.addCategory( category );

						addCategoryListItem( index, category );

						notifyListeners( 'update', {
							index: index,
							category: category,
							categories: categorySelect.categories
						});

						// Clear out the input
						$input.val( '' );
					}
				}
			}

			function addCategoryListItem( index, category ) {
				$( options.list ).append( $( '<li></li>' )
					.data( 'categoryIndex', index ).text( category.name ) );
			}

			function editCategory( event ) {

			}

			function notifyListeners( eventType, data ) {
				$element.trigger( eventType + '.' + namespace , data );
			}

			function removeCategory( event ) {

			}

			function setupAutocomplete( event ) {
				var $input = $( this );

				$.when( getCategories() ).done(function( wikiCategories ) {
					$input.autocomplete( $.extend( options.autocomplete, {
						select: addCategory,
						source: wikiCategories
					}));
				});
			}

			// Get rid of previous bindings
			$element.off( '.' + namespace );

			// Store an instance of CategorySelect in the element
			$element.data( namespace, categorySelect );

			// Set up jQuery.ui.autocomplete on first focus for the input field
			$element.one( 'focus.' + namespace, options.input, setupAutocomplete );

			// Listen for key presses on the input field
			$element.on( 'keypress.' + namespace, options.input, addCategory );

			// Build the initial categories list
			$.each( options.categories, addCategoryListItem );
		});
	}
})();

$.fn.categorySelect.options = {
	autocomplete: {
		appendTo: '#CategorySelect',
		minLength: 3
	},
	categories: [],
	input: '.addCategory',
	list: '.categories'
};

/**
 * Exports
 */
Wikia.CategorySelect = CategorySelect;
window.Wikia = Wikia;

})( window, jQuery );
