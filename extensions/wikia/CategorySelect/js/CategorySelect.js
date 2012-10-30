(function( window, $ ) {

var defaultNamespace = window.wgCategorySelect.defaultNamespace,
	defaultSortKey = window.wgCategorySelect.defaultSortKey || window.wgTitle,
	rCategoryName = new RegExp( '\\[\\[(?:' + window.wgCategorySelect.categoryNamespaces + '):([^\\]]+)]]', 'i' ),
	rSortKey = /(?:[^|]+)\|(.+)$/i,
	Wikia = window.Wikia || {};

// Searches for a category in an array of categories by its index or value.
// @return {Number} - The index of the category, or -1 if not found.
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

function normalizeCategory( category ) {
	var normalized = {
		namespace: defaultNamespace,
		outerTag: '',
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
 *			The new length of the categories array.
 */
CategorySelect.prototype.addCategory = function( category ) {
	return this.categories.push( normalizeCategory( category ) );
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
	var index = findCategory( category );

	if ( index >= 0 ) {
		this.categories[ index ] = normalizeCategory( value );
	}

	return index;
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
		index = findCategory( category );

	if ( index >= 0 ) {
		value = this.categories.splice( index, 1 );
	}

	return value;
};

/**
 * jQuery.fn.categorySelect
 * Sits on top of CategorySelect and provides user interface components.
 */
$.fn.categorySelect = function( options ) {
	var cache = {};

	options = $.extend( {}, options, $.fn.categorySelect.options );

	function addCategory( event ) {
		var $element = $( this );

		$.when( getCategories() ).done(function( categories ) {
			$element.autocomplete({
				appendTo: "#CategorySelect",
				minLength: 3,
				select: function( event, ui ) {
					console.log( event, ui );
					// TODO: actually add the category
				},
				source: categories
			});
		});
	}

	function getCategories() {
		return cache.categories || $.nirvana.sendRequest({
			controller: 'CategorySelectController',
			method: 'getCategories',
			type: 'GET',
			callback: function( categories ) {
				cache.categories = categories;
			}
		});
	}

	// Initialize
	return this.each(function() {
		var $element = $( this ),
			categories = JSON.parse( $( '#CategorySelectCategories' ).val() ),
			categorySelect = new CategorySelect( categories );

		if ( $element.data( 'CategorySelect' ) ) {
			$element.off( '.CategorySelect' );
		}

		$element.data( 'CategorySelect', categorySelect );
		$element.one( 'focus', '.addCategory', addCategory );
	});
};

/**
 * Exports
 */
Wikia.CategorySelect = CategorySelect;
window.Wikia = Wikia;

})( window, jQuery );
