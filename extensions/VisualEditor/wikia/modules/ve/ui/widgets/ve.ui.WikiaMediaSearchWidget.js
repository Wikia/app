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

	// Properties
	this.pagesPanel = new ve.ui.PagedLayout( { '$$': this.$$, 'attachPagesPanel': true } );
	this.suggestions = new ve.ui.SelectWidget( { '$$': this.$$ } );
	this.$suggestions = this.$$( '<div>' );

	// Initialization
	this.pagesPanel.addPage( 'results', { '$content': this.$results } );
	this.pagesPanel.addPage( 'suggestions', { '$content': this.$suggestions } );

	this.$suggestions
		.addClass( 've-ui-searchWidget-suggestions' )
		.append( this.suggestions.$ );
	this.$.prepend( this.pagesPanel.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaSearchWidget, ve.ui.SearchWidget );

/* Methods */

ve.ui.WikiaMediaSearchWidget.prototype.onQueryChange = function () {
	var value = this.query.getValue();

	// Parent method
};
