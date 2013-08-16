/*!
 * VisualEditor user interface PagedDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Abstract implementation for a dialog having an outline in the left third, and a series of pages
 * in the right two-thirds. Pages can be added using the #addPage method, and later accessed using
 * `this.pages[name]` or through the #getPage method.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 * @cfg {boolean} [editable] Show controls for adding, removing and reordering items in the outline
 * @cfg {Object[]} [adders] List of adders for controls, each an object with name, icon and title
 *  properties
 */
ve.ui.PagedDialog = function VeUiPagedDialog( surface, config ) {
	// Configuration initialization
	config = config || {};

	// Properties
	this.editable = !!config.editable;
	this.adders = config.adders || null;
	this.pages = {};
	this.currentPageName = null;
};

/* Methods */

/**
 * Initialization.
 *
 * If you mix this class in, you must call this from your initialize method.
 */
ve.ui.PagedDialog.prototype.initializePages = function () {
	// Properties
	this.outlinePanel = new ve.ui.PanelLayout( { '$$': this.frame.$$, 'scrollable': true } );
	this.pagesPanel = new ve.ui.StackPanelLayout( { '$$': this.frame.$$ } );
	this.layout = new ve.ui.GridLayout(
		[this.outlinePanel, this.pagesPanel], { '$$': this.frame.$$, 'widths': [1, 2] }
	);
	this.outlineWidget = new ve.ui.OutlineWidget( { '$$': this.frame.$$ } );
	if ( this.editable ) {
		this.outlineControlsWidget = new ve.ui.OutlineControlsWidget(
			this.outlineWidget, { '$$': this.frame.$$, 'adders': this.adders }
		);
	}

	// Events
	this.outlineWidget.connect( this, { 'select': 'onPageOutlineSelect' } );

	// Initialization
	this.outlinePanel.$
		.addClass( 've-ui-pagedDialog-outlinePanel' )
		.append( this.outlineWidget.$ );
	if ( this.editable ) {
		this.outlinePanel.$
			.addClass( 've-ui-pagedDialog-outlinePanel-editable' )
			.append( this.outlineControlsWidget.$ );
	}
	this.pagesPanel.$.addClass( 've-ui-pagedDialog-pagesPanel' );
	this.$body.append( this.layout.$ );
};

/**
 * Handle outline select events.
 *
 * @method
 * @param {ve.ui.OptionWidget} item Selected item
 */
ve.ui.PagedDialog.prototype.onPageOutlineSelect = function ( item ) {
	if ( item ) {
		this.setPage( item.getData() );
	}
};

/**
 * Add a page to the dialog.
 *
 * @method
 * @param {string} name Symbolic name of page
 * @param {Object} [config] Condifugration options
 * @param {jQuery|string} [config.label] Page label
 * @param {string} [config.icon] Symbolic name of icon
 * @param {number} [config.level=0] Indentation level
 * @param {number} [config.index] Specific index to insert page at
 * @param {jQuery} [config.$content] Page content
 * @param {jQuery} [config.moveable] Allow page to be moved in the outline
 * @chainable
 */
ve.ui.PagedDialog.prototype.addPage = function ( name, config ) {
	// Create and add page panel and outline item
	this.pages[name] = new ve.ui.PanelLayout( { '$$': this.frame.$$, 'scrollable': true } );
	if ( config.$content ) {
		this.pages[name].$.append( config.$content );
	}
	this.pagesPanel.addItems( [this.pages[name]], config.index );
	this.outlineWidget.addItems(
		[
			new ve.ui.OutlineItemWidget( name, {
				'$$': this.frame.$$,
				'label': config.label || name,
				'level': config.level || 0,
				'icon': config.icon,
				'moveable': config.moveable
			} )
		],
		config.index
	);

	// Auto-select first item when nothing is selected yet
	if ( !this.outlineWidget.getSelectedItem() ) {
		this.outlineWidget.selectItem( this.outlineWidget.getFirstSelectableItem() );
	}

	return this;
};

/**
 * Remove a page.
 *
 * @method
 * @chainable
 */
ve.ui.PagedDialog.prototype.removePage = function ( name ) {
	var page = this.pages[name];

	if ( page ) {
		delete this.pages[name];
		this.pagesPanel.removeItems( [ page ] );
		this.outlineWidget.removeItems( [ this.outlineWidget.getItemFromData( name ) ] );
	}

	// Auto-select first item when nothing is selected anymore
	if ( !this.outlineWidget.getSelectedItem() ) {
		this.outlineWidget.selectItem( this.outlineWidget.getFirstSelectableItem() );
	}

	return this;
};

/**
 * Clear all pages.
 *
 * @method
 * @chainable
 */
ve.ui.PagedDialog.prototype.clearPages = function () {
	this.pages = [];
	this.pagesPanel.clearItems();
	this.outlineWidget.clearItems();
	this.currentPageName = null;

	return this;
};

/**
 * Get a page by name.
 *
 * @method
 * @param {string} name Symbolic name of page
 * @returns {ve.ui.PanelLayout|undefined} Page, if found
 */
ve.ui.PagedDialog.prototype.getPage = function ( name ) {
	return this.pages[name];
};

/**
 * Set the page by name.
 *
 * @method
 * @param {string} name Symbolic name of page
 */
ve.ui.PagedDialog.prototype.setPage = function ( name ) {
	if ( this.pages[name] ) {
		this.currentPageName = name;
		this.pagesPanel.showItem( this.pages[name] );
		this.pages[name].$.find( ':input:first' ).focus();
	}
};

/**
 * Get current page name.
 *
 * @method
 * @returns {string|null} Current page name
 */
ve.ui.PagedDialog.prototype.getPageName = function () {
	return this.currentPageName;
};
