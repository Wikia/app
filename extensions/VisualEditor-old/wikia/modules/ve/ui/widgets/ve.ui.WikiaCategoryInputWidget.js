/*!
 * VisualEditor UserInterface WikiaCategoryInputWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Creates a ve.ui.WikiaCategoryInputWidget object.
 *
 * @class
 * @extends ve.ui.MWCategoryInputWidget
 *
 * @constructor
 * @param {ve.ui.MWCategoryWidget} categoryWidget
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaCategoryInputWidget = function VeUiWikiaCategoryInputWidget( categoryWidget, config ) {
	// Parent constructor
	ve.ui.WikiaCategoryInputWidget.super.call( this, categoryWidget, config );

	mw.loader.use( 'jquery.ui.autocomplete' );
	this.getCategories();
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaCategoryInputWidget, ve.ui.MWCategoryInputWidget );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaCategoryInputWidget.prototype.getLookupRequest = function () {
	var deferred = $.Deferred();

	this.getCategories().done( ve.bind( function ( categories ) {
		deferred.resolve(
			// Only return filtered results for at least 3 characters
			this.value.length > 2 ? this.filterCategories( categories, this.value ) : []
		);
	}, this ) );

	// OO.ui.LookupInputWidget.getLookupMenuItems requires an "abort" method for the promise
	// returned by this function, which jQuery does not support except for jqXHR objects. So
	// extend the return value with a dummy abort method.
	return $.extend( deferred.promise(), {
		'abort': function () { return; }
	} );
};

/**
 * Get all categories for the current wiki via API request and return as a promise object
 *
 * @returns {Promise}
 */
ve.ui.WikiaCategoryInputWidget.prototype.getCategories = function () {
	var deferred;

	if ( !this.categoriesPromise ) {
		deferred = $.Deferred();

		// Retrieves all categories for this wiki in a single request, which will only run once
		$.nirvana.sendRequest( {
			controller: 'CategorySelectController',
			method: 'getWikiCategories',
			type: 'GET'
		} )
		.done( function ( categories ) {
			deferred.resolve( categories );
		} )
		.fail( function () {
			deferred.resolve( [] );
		} );

		this.categoriesPromise = deferred.promise();
	}

	return this.categoriesPromise;
};

/**
 * Filter the categories by the given search term, and convert the result into the format used
 * by ve.ui.MWCategoryInputWidget.getLookupCacheItemFromData
 *
 * @param {string} term Search term
 * @param {array} categories
 * @returns {Object}
 */
ve.ui.WikiaCategoryInputWidget.prototype.filterCategories = function ( categories, term ) {
	var i,
		filteredCategories = $.ui.autocomplete.filter( categories, term ),
		formattedData = { 'query': { 'allcategories': [] } },
		allCategories = formattedData.query.allcategories;

	for ( i in filteredCategories ) {
		allCategories.push( { '*': filteredCategories[i] } );
	}

	return formattedData;
};

/**
 * Get list of menu items from a server response.
 * Note: This function was copied and modified from ve.ui.MWCategoryInputWidget
 *
 * @param {Object} data Query result
 * @returns {OO.ui.MenuItemWidget[]} Menu items
 */
ve.ui.WikiaCategoryInputWidget.prototype.getLookupMenuItemsFromData = function ( data ) {
	var i, len, item,
		exactMatch = false,
		newCategoryItems = [],
		matchingCategoryItems = [],
		items = [],
		menu$ = this.lookupMenu.$,
		category = this.value;

	i = 0;
	$.each( data, function ( title ) {
		// Limit matched categories to 10
		if ( i >= 10 ) {
			return false;
		}
		if ( title.toUpperCase() === category.toUpperCase() ) {
			exactMatch = true;
		}
		matchingCategoryItems.push( title );
		i++;
	} );

	// New category
	if ( !exactMatch ) {
		newCategoryItems.push( category );
	}

	// Add sections for non-empty groups
	if ( newCategoryItems.length ) {
		items.push( new OO.ui.MenuSectionItemWidget(
			'newCategory', { '$': menu$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-newcategorylabel' ) }
		) );
		for ( i = 0, len = newCategoryItems.length; i < len; i++ ) {
			item = newCategoryItems[i];
			items.push( new OO.ui.MenuItemWidget( item, { '$': menu$, 'label': item } ) );
		}
	}
	if ( matchingCategoryItems.length ) {
		items.push( new OO.ui.MenuSectionItemWidget(
			'matchingCategories', { '$': menu$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-matchingcategorieslabel' ) }
		) );
		for ( i = 0, len = matchingCategoryItems.length; i < len; i++ ) {
			item = matchingCategoryItems[i];
			items.push( this.getMenuItemWidgetFromCategoryName( item, menu$ ) );
		}
	}

	return items;
};
