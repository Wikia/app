/*!
 * VisualEditor UserInterface MWCategoryInputWidget class.
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
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaCategoryInputWidget, ve.ui.MWCategoryInputWidget );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaCategoryInputWidget.prototype.getLookupRequest = function () {
	var deferred;

	if ( !this.categoriesPromise ) {
		deferred = $.Deferred();

		// Retrieves all categories for this wiki in a single request, which will only run once
		$.nirvana.sendRequest( {
			controller: 'CategorySelectController',
			method: 'getWikiCategories',
			type: 'GET'
		} )
		.done( ve.bind( function ( categories ) {
			deferred.resolve( categories );
		}, this ) )
		.fail( function () {
			deferred.resolve( [] );
		} );

		this.categoriesPromise = deferred.promise();
	}

	// OO.ui.LookupInputWidget.getLookupMenuItems requires an "abort" method for the promise
	// returned by this function, which jQuery does not support except for jqXHR objects. So
	// extend the return value with a dummy abort method.
	return $.extend( this.categoriesPromise, {
		'abort': function () { return; }
	} );
};

/**
 * Wraps the parent method in a delay for performance increase. Filtering after every character typed
 * is too slow and will freeze even the fastest browser.
 * @inheritdoc
 */
ve.ui.WikiaCategoryInputWidget.prototype.onLookupInputChange = function () {
	window.clearTimeout( this.lookupTimeout );
	this.lookupTimeout = window.setTimeout( ve.bind( function () {
		this.openLookupMenu();
	}, this ), 300 );	
};

/**
 * @inheritdoc
 */
ve.ui.WikiaCategoryInputWidget.prototype.getLookupCacheItemFromData = function ( data ) {
	// The categories are returned from the Nirvana API request as an ordinary array. Here the array is
	// searched for the user's input and the results converted into the format used by the parent method.
	data = this.formatAsQueryData( $.ui.autocomplete.filter( data, this.value ) );
	return ve.ui.WikiaCategoryInputWidget.super.prototype.getLookupCacheItemFromData.call( this, data );
};

/**
 * Convert an array of categories into the format used by ve.ui.MWCategoryInputWidget.getLookupCacheItemFromData
 *
 * @param {array} categories
 * @returns {Object}
 */
ve.ui.WikiaCategoryInputWidget.prototype.formatAsQueryData = function ( categories ) {
	var i, formattedData = {'query': { 'allcategories': [] } };
	for ( i in categories ) {
		formattedData.query.allcategories.push( { '*': categories[i] } );
	}
	return formattedData;
};
