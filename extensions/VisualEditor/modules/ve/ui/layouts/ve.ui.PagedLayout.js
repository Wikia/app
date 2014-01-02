/*!
 * VisualEditor UserInterface PagedLayout class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * A layout which contains a series of pages.
 *
 * @class
 * @extends ve.ui.Layout
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {boolean} [config.attachPagesPanel] Whether or not to attach pagesPanel to this.$ on
 *  initialization.
 */
ve.ui.PagedLayout = function VeUiPagedLayout( config ) {
	// Initialize configuration
	config = config || {};

	// Parent constructor
	ve.ui.Layout.call( this, config );

	// Properties
	this.attached = !!config.attachPagesPanel;
	this.currentPageName = null;
	this.pages = {};
	this.pagesPanel = new ve.ui.StackPanelLayout( { '$$': this.$$ } );

	// Initialization
	this.$.addClass( 've-ui-pagedLayout' );
	this.pagesPanel.$.addClass( 've-ui-pagedLayout-pagesPanel' );

	if ( this.attached ) {
		this.$.append( this.pagesPanel.$ );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.PagedLayout, ve.ui.Layout );

/* Events */

/**
 * @event add
 * @param {string} name The name of the page added.
 * @param {ve.ui.PanelLayout} page The page panel.
 */

/**
 * @event remove
 * @param {ve.ui.PanelLayout[]} pages An array of page panels that were removed.
 */

/**
 * @event set
 * @param {ve.ui.PanelLayout} page The page panel that is now the current page.
 */

/* Methods */

/**
 * Add a page to the layout.
 *
 * @method
 * @param {string} name Symbolic name of page
 * @param {Object} [config] Condifugration options
 * @param {number} [config.index] Specific index to insert page at
 * @param {jQuery} [config.$content] Page content
 * @emits add
 * @chainable
 */
ve.ui.PagedLayout.prototype.addPage = function ( name, config ) {
	var page = new ve.ui.PanelLayout( { '$$': this.$$, 'scrollable': true } );

	config = config || {};

	if ( config.$content ) {
		page.$.append( config.$content );
	}

	this.pages[name] = page;
	this.pagesPanel.addItems( [ page ], config.index );
	this.emit( 'add', name, page );

	return this;
};

/**
 * Clear all pages from the layout.
 *
 * @method
 * @emits remove
 * @chainable
 */
ve.ui.PagedLayout.prototype.clearPages = function () {
	var pages = this.pagesPanel.getItems();

	this.currentPageName = null;
	this.pages = {};
	this.pagesPanel.clearItems();
	this.emit( 'remove', pages );

	return this;
};

/**
 * Get a page by name.
 *
 * @method
 * @param {string} name Symbolic name of page
 * @returns {ve.ui.PanelLayout|undefined} Page, if found
 */
ve.ui.PagedLayout.prototype.getPage = function ( name ) {
	return this.pages[name];
};


/**
 * Get the current page name.
 *
 * @method
 * @returns {string|null} Current page name
 */
ve.ui.PagedLayout.prototype.getPageName = function () {
	return this.currentPageName;
};

/**
 * Remove a page from the layout.
 *
 * @method
 * @emits remove
 * @chainable
 */
ve.ui.PagedLayout.prototype.removePage = function ( name ) {
	var page = this.pages[name];

	if ( page ) {
		page = [ page ];
		delete this.pages[name];
		this.pagesPanel.removeItems( page );
		this.emit( 'remove', page );
	}

	return this;
};

/**
 * Set the current page by name.
 *
 * @method
 * @emits set
 * @param {string} name Symbolic name of page
 */
ve.ui.PagedLayout.prototype.setPage = function ( name ) {
	var page = this.pages[name];

	if ( page ) {
		this.currentPageName = name;
		this.pagesPanel.showItem( page );
		this.emit( 'set', page );
	}
};
