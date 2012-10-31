(function( window, $ ) {

var defaultNamespace = window.wgCategorySelect.defaultNamespace,
	defaultSortKey = window.wgCategorySelect.defaultSortKey || window.wgTitle,
	namespace = 'CategorySelect',
	rCategoryName = new RegExp( '\\[\\[(?:' + window.wgCategorySelect.categoryNamespaces + '):([^\\]]+)]]', 'i' ),
	rSortKey = /(?:[^|]+)\|(.+)$/i,
	Wikia = window.Wikia || {};

/**
 * Find a category in an array of categories by index or name.
 *
 * @param	{Number|String} category
 *			The name of a category or the index of a category in the array.
 * @param	{Array} categories
 *			An array of categories to search in.
 * @returns	{Number}
 *			The index of the category that was found, or -1 if the category could
 *			not be found.
 */
function findCategory( category, categories ) {
	var i, obj,
		found = -1,
		length = categories.length;

	if ( length ) {

		// Search for category by index
		if ( categories[ category ] ) {
			found = parseInt( category );

		// Search for category by value
		} else {
			for ( i = 0; i < length; i++ ) {
				if ( ( obj = categories[ i ] ) && obj.category == category ) {
					found = i;
					break;
				}
			}
		}
	}

	return found;
}

/**
 * Normalizes a category object.
 *
 * @param	{Object|String} category
 *			The name of a category or an object with category properties.
 * @returns {Object}
 *			The normalized category.
 */
function normalizeCategory( category ) {
	var normalized = {
		namespace: defaultNamespace,
		sortKey: defaultSortKey
	};

	if ( typeof category == 'object' ) {
		normalized = $.extend( normalized, category );

	} else {
		normalized.name = category;
	}

	// Extract name from category -- [[Category:abc]] -> name: "abc"
	normalized.name = normalized.name.replace( rCategoryName, '$1' );

	// Extract sortkey from category -- "abc|def" -> name: "abc", sortkey: "def"
	normalized.sortKey = normalized.name.replace( rSortKey, '$1' );

	return normalized;
}

/**
 * CategorySelect
 * Low-level category tracking.
 *
 * @param	{Array} (categories)
 *			The initial list of categories.
 */
var CategorySelect = function( categories ) {
	this.categories = categories || [];
}

/**
 * Adds a category to the categories array.
 *
 * @param	{String|Object} category
 *			The category to add.
 * @returns	{Number}
 *			The length of the categories array
 */
CategorySelect.prototype.addCategory = function( category ) {
	var length;

	category = normalizeCategory( category );

	if ( category.name != undefined && category.name != '' ) {
		length = this.categories.push( category );

	} else {
		length = this.categories.length;
	}

	return length;
};

/**
 * Edits a category from the categories array.
 *
 * @param	{Number|String} category
 *			The index of a category in the categories array or a string matching a
 *			category in the array.
 * @param	{String} value
 *			The new value of the category.
 * @returns	{Number}
 *			The index of the category that was edited, or -1 if the category could
 *			not be found.
 */
CategorySelect.prototype.editCategory = function( category, value ) {
	var index = findCategory( category, this.categories );

	if ( index >= 0 ) {
		this.categories[ index ] = normalizeCategory( value );
	}

	return index;
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
	var obj,
		index = findCategory( category, this.categories );

	if ( index >= 0 ) {
		obj = this.categories[ index ];
	}

	return obj;
};

/**
 * Removes a category from the categories array.
 *
 * @param	{Number|String} category
 *			The index of a category in the categories array or a string matching a
 *			category in the array.
 * @returns {String|Undefined}
 *			The value of the category that was removed, or undefined if the category
 *			could not be found.
 */
CategorySelect.prototype.removeCategory = function( category ) {
	var value,
		index = findCategory( category, this.categories );

	if ( index >= 0 ) {
		value = this.categories.splice( index, 1 );
	}

	return value;
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
		options = $.extend( {}, options, $.fn.categorySelect.options );

		return this.each(function() {
			var $element = $( this ),
				categorySelect = new CategorySelect( options.categories );

			function addCategory( event, ui ) {
				var index,
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
						addCategoryListItem( categorySelect.addCategory( value ), value );
						notifyListeners( event, categorySelect.getCategory( index ) );

						// Clear out the input
						$input.val( '' );
					}
				}
			}

			function addCategoryListItem( index, value ) {
				$( options.list ).append(
					$( '<li></li>' ).data( 'categoryIndex', index ).text( value ) );
			}

			function editCategory( event ) {

			}

			function notifyListeners( event, data ) {
				$element.triggerHandler( 'update.' + namespace, {
					data: data || {},
					event: event || $.Event
				});
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
			$.each( options.categories, function( index, category ) {
				addCategoryListItem( index, category.name );
			});
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
