/*!
 * VisualEditor UserInterface SearchWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.SearchWidget object.
 *
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string|jQuery} [placeholder] Placeholder text for query input
 * @cfg {string} [value] Initial query value
 */
ve.ui.SearchWidget = function VeUiSearchWidget( config ) {
	// Configuration intialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.query = new ve.ui.TextInputWidget( {
		'$$': this.$$,
		'icon': 'search',
		'placeholder': config.placeholder,
		'value': config.value
	} );
	this.results = new ve.ui.SelectWidget( { '$$': this.$$ } );
	this.$query = this.$$( '<div>' );
	this.$results = this.$$( '<div>' );

	// Events
	this.query.connect( this, {
		'change': 'onQueryChange',
		'enter': 'onQueryEnter'
	} );
	this.results.connect( this, {
		'highlight': 'onResultsHighlight',
		'select': 'onResultsSelect'
	} );
	this.query.$input.on( 'keydown', ve.bind( this.onQueryKeydown, this ) );

	// Initialization
	this.$query
		.addClass( 've-ui-searchWidget-query' )
		.append( this.query.$ );
	this.$results
		.addClass( 've-ui-searchWidget-results' )
		.append( this.results.$ );
	this.$
		.addClass( 've-ui-searchWidget' )
		.append( this.$results, this.$query );
};

/* Inheritance */

ve.inheritClass( ve.ui.SearchWidget, ve.ui.Widget );

/* Events */

/**
 * @event highlight
 * @param {Object|null} item Item data or null if no item is highlighted
 */

/**
 * @event select
 * @param {Object|null} item Item data or null if no item is selected
 */

/* Methods */

/**
 * Handle query key down events.
 *
 * @method
 * @param {jQuery.Event} e Key down event
 */
ve.ui.SearchWidget.prototype.onQueryKeydown = function ( e ) {
	var highlightedItem, nextItem,
		dir = e.which === ve.Keys.DOWN ? 1 : ( e.which === ve.Keys.UP ? -1 : 0 );

	if ( dir ) {
		highlightedItem = this.results.getHighlightedItem();
		if ( !highlightedItem ) {
			highlightedItem = this.results.getSelectedItem();
		}
		nextItem = this.results.getRelativeSelectableItem( highlightedItem, dir );
		this.results.highlightItem( nextItem );
		nextItem.scrollElementIntoView();
	}
};

/**
 * Handle select widget select events.
 *
 * Clears existing results. Subclasses should repopulate items according to new query.
 *
 * @method
 * @param {string} value New value
 */
ve.ui.SearchWidget.prototype.onQueryChange = function () {
	// Reset
	this.results.clearItems();
};

/**
 * Handle select widget enter key events.
 *
 * Selects highlighted item.
 *
 * @method
 * @param {string} value New value
 */
ve.ui.SearchWidget.prototype.onQueryEnter = function () {
	// Reset
	this.results.selectItem( this.results.getHighlightedItem() );
};

/**
 * Handle select widget highlight events.
 *
 * @method
 * @param {ve.ui.OptionWidget} item Highlighted item
 * @emits highlight
 */
ve.ui.SearchWidget.prototype.onResultsHighlight = function ( item ) {
	this.emit( 'highlight', item ? item.getData() : null );
};

/**
 * Handle select widget select events.
 *
 * @method
 * @param {ve.ui.OptionWidget} item Selected item
 * @emits select
 */
ve.ui.SearchWidget.prototype.onResultsSelect = function ( item ) {
	this.emit( 'select', item ? item.getData() : null );
};

/**
 * Get the query input.
 *
 * @method
 * @returns {ve.ui.TextInputWidget} Query input
 */
ve.ui.SearchWidget.prototype.getQuery = function () {
	return this.query;
};

/**
 * Get the results list.
 *
 * @method
 * @returns {ve.ui.SelectWidget} Select list
 */
ve.ui.SearchWidget.prototype.getResults = function () {
	return this.results;
};
