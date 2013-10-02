/*!
 * VisualEditor UserInterface StackPanelLayout class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Stack panel layout.
 *
 * @class
 * @extends ve.ui.PanelLayout
 * @mixins ve.ui.GroupElement
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [icon=''] Symbolic icon name
 */
ve.ui.StackPanelLayout = function VeUiStackPanelLayout( config ) {
	// Config initialization
	config = ve.extendObject( { 'scrollable': true }, config );

	// Parent constructor
	ve.ui.PanelLayout.call( this, config );

	// Mixin constructors
	ve.ui.GroupElement.call( this, this.$, config );

	// Properties
	this.currentItem = null;

	// Initialization
	this.$.addClass( 've-ui-stackPanelLayout' );
};

/* Inheritance */

ve.inheritClass( ve.ui.StackPanelLayout, ve.ui.PanelLayout );

ve.mixinClass( ve.ui.StackPanelLayout, ve.ui.GroupElement );

/* Methods */

/**
 * Add items.
 *
 * Adding an existing item (by value) will move it.
 *
 * @method
 * @param {ve.ui.PanelLayout[]} items Items to add
 * @param {number} [index] Index to insert items after
 * @chainable
 */
ve.ui.StackPanelLayout.prototype.addItems = function ( items, index ) {
	var i, len;

	for ( i = 0, len = items.length; i < len; i++ ) {
		if ( !this.currentItem ) {
			this.showItem( items[i] );
		} else {
			items[i].$.hide();
		}
	}
	ve.ui.GroupElement.prototype.addItems.call( this, items, index );

	return this;
};

/**
 * Remove items.
 *
 * Items will be detached, not removed, so they can be used later.
 *
 * @method
 * @param {ve.ui.PanelLayout[]} items Items to remove
 * @chainable
 */
ve.ui.StackPanelLayout.prototype.removeItems = function ( items ) {
	ve.ui.GroupElement.prototype.removeItems.call( this, items );
	if ( items.indexOf( this.currentItem ) !== -1 ) {
		this.currentItem = null;
		if ( !this.currentItem && this.items.length ) {
			this.showItem( this.items[0] );
		}
	}

	return this;
};

/**
 * Clear all items.
 *
 * Items will be detached, not removed, so they can be used later.
 *
 * @method
 * @chainable
 */
ve.ui.StackPanelLayout.prototype.clearItems = function () {
	this.currentItem = null;
	ve.ui.GroupElement.prototype.clearItems.call( this );

	return this;
};

/**
 * Show item.
 *
 * Any currently shown item will be hidden.
 *
 * @method
 * @param {ve.ui.PanelLayout} item Item to show
 * @chainable
 */
ve.ui.StackPanelLayout.prototype.showItem = function ( item ) {
	this.$items.hide();
	item.$.show();
	this.currentItem = item;

	return this;
};
