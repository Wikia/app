/*!
 * VisualEditor user interface PagedPagedOutlineLayout class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

 /**
 * A layout having an outline in the left third, and a series of pages in the right two-thirds.
 *
 * @class
 * @extends ve.ui.PagedLayout
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {boolean} [config.editable] Show controls for adding, removing and reordering items in
 *  the outline
 * @param {Object[]} [config.adders] List of adders for controls, each an object with name, icon
 *  and title properties
 */
ve.ui.PagedOutlineLayout = function VeUiPagedOutlineLayout( config ) {
	// Initialize configuration
	config = config || {};
	config.attachPagesPanel = false;

	// Parent constructor
	ve.ui.PagedLayout.call( this, config );

	// Properties
	this.adders = config.adders || null;
	this.editable = !!config.editable;
	this.outlineControlsWidget = null;
	this.outlinePanel = new ve.ui.PanelLayout( { '$$': this.$$, 'scrollable': true } );
	this.outlineWidget = new ve.ui.OutlineWidget( { '$$': this.$$ } );
	this.gridLayout = new ve.ui.GridLayout(
		[this.outlinePanel, this.pagesPanel], { '$$': this.$$, 'widths': [1, 2] }
	);

	if ( this.editable ) {
		this.outlineControlsWidget = new ve.ui.OutlineControlsWidget(
			this.outlineWidget, { '$$': this.$$, 'adders': this.adders }
		);
	}

	// Events
	this.outlineWidget.connect( this, { 'select': 'onPageOutlineSelect' } );
	this.pagesPanel.connect( this, { 'set': 'onPagedLayoutSet' } );

	// Initialization
	this.outlinePanel.$
		.addClass( 've-ui-pagedOutlineLayout-outlinePanel' )
		.append( this.outlineWidget.$ );

	if ( this.editable ) {
		this.outlinePanel.$
			.addClass( 've-ui-pagedOutlineLayout-outlinePanel-editable' )
			.append( this.outlineControlsWidget.$ );
	}

	this.$
		.addClass( 've-ui-pagedOutlineLayout' )
		.append( this.gridLayout.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.PagedOutlineLayout, ve.ui.PagedLayout );

/* Methods */

/**
 * Add a page to the layout.
 *
 * @method
 * @param {string} name Symbolic name of page
 * @param {Object} [config] Condifugration options
 * @param {jQuery|string} [config.label=name] Page label
 * @param {string} [config.icon] Symbolic name of icon
 * @param {number} [config.level=0] Indentation level
 * @param {number} [config.index] Specific index to insert page at
 * @param {jQuery} [config.$content] Page content
 * @param {jQuery} [config.moveable] Allow page to be moved in the outline
 * @chainable
 */
ve.ui.PagedOutlineLayout.prototype.addPage = function ( name, config ) {
	config = config || {};

	this.outlineWidget.addItems(
		[
			new ve.ui.OutlineItemWidget( name, {
				'$$': this.$$,
				'label': config.label || name,
				'level': config.level || 0,
				'icon': config.icon,
				'moveable': config.moveable
			} )
		],
		config.index
	);

	this.updateOutlineWidget();

	// Parent method
	return ve.ui.PagedLayout.prototype.addPage.call( this, name, config );
};

/**
 * Clear all pages.
 *
 * @method
 * @chainable
 */
ve.ui.PagedOutlineLayout.prototype.clearPages = function () {
	this.outlineWidget.clearItems();

	// Parent method
	return ve.ui.PagedLayout.prototype.clearPages.call( this );
};

/**
 * Get the outline widget.
 *
 * @method
 * @returns {ve.ui.OutlineWidget} The outline widget.
 */
ve.ui.PagedOutlineLayout.prototype.getOutline = function () {
	return this.outlineWidget;
};

/**
 * Get the outline controls widget. If the outline is not editable, null is returned.
 *
 * @method
 * @returns {ve.ui.OutlineControlsWidget|null} The outline controls widget.
 */
ve.ui.PagedOutlineLayout.prototype.getOutlineControls = function () {
	return this.outlineControlsWidget;
};

/**
 * Handle PagedLayout set events.
 *
 * @method
 * @param {ve.ui.PanelLayout} page The page panel that is now the current panel.
 */
ve.ui.PagedOutlineLayout.prototype.onPagedLayoutSet = function ( page ) {
	page.$.find( ':input:first' ).focus();
};

/**
 * Handle outline select events.
 *
 * @method
 * @param {ve.ui.OptionWidget} item Selected item
 */
ve.ui.PagedOutlineLayout.prototype.onPageOutlineSelect = function ( item ) {
	if ( item ) {
		this.setPage( item.getData() );
	}
};

/**
 * Remove a page.
 *
 * @method
 * @chainable
 */
ve.ui.PagedOutlineLayout.prototype.removePage = function ( name ) {
	var page = this.pages[name];

	if ( page ) {
		this.outlineWidget.removeItems( [ this.outlineWidget.getItemFromData( name ) ] );
		this.updateOutlineWidget();
	}

	// Parent method
	return ve.ui.PagedLayout.prototype.removePage.call( this, name );
};

/**
 * Call this after adding or removing items from the OutlineWidget.
 *
 * @method
 * @chainable
 */
ve.ui.PagedOutlineLayout.prototype.updateOutlineWidget = function () {
	// Auto-select first item when nothing is selected anymore
	if ( !this.outlineWidget.getSelectedItem() ) {
		this.outlineWidget.selectItem( this.outlineWidget.getFirstSelectableItem() );
	}

	return this;
};
