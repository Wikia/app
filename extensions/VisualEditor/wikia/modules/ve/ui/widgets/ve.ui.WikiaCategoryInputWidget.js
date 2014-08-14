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
		clearTimeout( this.lookupTimeout );
		this.lookupTimeout = setTimeout(
			ve.bind(
				deferred.resolve( this.getFilteredQueryData( categories ) ),
				this
			),
			300
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
 * Filter the categories by the current input value, and convert the result into the format used
 * by ve.ui.MWCategoryInputWidget.getLookupCacheItemFromData
 *
 * @param {array} categories
 * @returns {Object}
 */
ve.ui.WikiaCategoryInputWidget.prototype.getFilteredQueryData = function ( categories ) {
	var i,
		formattedData = { 'query': { 'allcategories': [] } },
		filteredCategories = $.ui.autocomplete.filter( categories, this.value ).slice( 0, 10 ),
		categories = formattedData.query.allcategories;
	for ( i in filteredCategories ) {
		categories.push( { '*': filteredCategories[i] } );
	}
	return formattedData;
};
