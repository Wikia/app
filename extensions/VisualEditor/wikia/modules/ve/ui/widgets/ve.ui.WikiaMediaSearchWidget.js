/*!
 * VisualEditor UserInterface WikiaMediaSearchWidget class.
 */

/*global mw*/

/**
 * Creates a ve.ui.WikiaMediaSearchWidget object.
 *
 * @class
 * @extends ve.ui.SearchWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {number} [size] Vertical size of thumbnails
 */
ve.ui.WikiaMediaSearchWidget = function VeUiWikiaMediaSearchWidget( config ) {
	// Parent constructor
	ve.ui.SearchWidget.call( this, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaSearchWidget, ve.ui.SearchWidget );

/* Methods */

