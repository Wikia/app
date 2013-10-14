/*!
 * VisualEditor UserInterface MWCategoryWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWCategoryWidget object.
 *
 * @class
 * @abstract
 * @extends ve.ui.Widget
 * @mixin ve.ui.GroupElement
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCategoryWidget = function VeUiMWCategoryWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Mixin constructors
	ve.ui.GroupElement.call( this, this.$$( '<div>' ), config );

	// Properties
	this.categories = {};
	this.popupState = false;
	this.savedPopupState = false;
	this.popup = new ve.ui.MWCategoryPopupWidget( {
		'$$': this.$$, 'align': 'right', '$overlay': config.$overlay
	} );
	this.input = new ve.ui.MWCategoryInputWidget( this, {
		'$$': this.$$, '$overlay': config.$overlay, '$container': this.$
	} );

	// Events
	this.input.$input.on( 'keydown', ve.bind( this.onLookupInputKeyDown, this ) );
	this.input.lookupMenu.connect( this, { 'select': 'onLookupMenuItemSelect' } );
	this.popup.connect( this, {
		'removeCategory': 'onRemoveCategory',
		'updateSortkey': 'onUpdateSortkey',
		'hide': 'onPopupHide'
	} );

	// Initialization
	this.$.addClass( 've-ui-mwCategoryWidget' )
		.append(
			this.$group.addClass( 've-ui-mwCategoryWidget-items' ),
			this.input.$,
			this.$$( '<div>' ).css( 'clear', 'both' )
		);
};

/* Inheritance */

ve.inheritClass( ve.ui.MWCategoryWidget, ve.ui.Widget );

ve.mixinClass( ve.ui.MWCategoryWidget, ve.ui.GroupElement );

/* Events */

/**
 * @event newCategory
 * @param {Object} item Category item
 * @param {string} item.name Fully prefixed category name
 * @param {string} item.value Category value (name without prefix)
 * @param {Object} item.metaItem Category meta item
 */

/**
 * @event updateSortkey
 * @param {Object} item Category item
 * @param {string} item.name Fully prefixed category name
 * @param {string} item.value Category value (name without prefix)
 * @param {Object} item.metaItem Category meta item
 */

/* Methods */

/**
 * Handle input key down event.
 *
 * @method
 * @param {jQuery.Event} e Input key down event
 */
ve.ui.MWCategoryWidget.prototype.onLookupInputKeyDown = function ( e ) {
	if ( this.input.getValue() !== '' && e.which === 13 ) {
		this.emit(
			'newCategory',
			this.input.getCategoryItemFromValue( this.input.getValue() )
		);
		this.input.setValue( '' );
	}
};

/**
 * Handle menu item select event.
 *
 * @method
 * @param {ve.ui.MenuItemWidget} item Selected item
 */
ve.ui.MWCategoryWidget.prototype.onLookupMenuItemSelect = function ( item ) {
	var value = item && item.getData();

	if ( value && value !== '' ) {
		// Remove existing items by value
		if ( value in this.categories ) {
			this.categories[value].metaItem.remove();
		}
		// Add new item
		this.emit( 'newCategory',  this.input.getCategoryItemFromValue( value ) );
		// Reset input
		this.input.setValue( '' );
	}
};

/**
 * Removes category from model.
 *
 * @method
 * @param {string} name category name
 */
ve.ui.MWCategoryWidget.prototype.onRemoveCategory = function ( name ) {
	this.categories[name].metaItem.remove();
};

/**
 * Update sortkey value, emit updateSortkey event
 *
 * @method
 * @param {string} name
 * @param {string} value
 */
ve.ui.MWCategoryWidget.prototype.onUpdateSortkey = function ( name, value ) {
	this.categories[name].sortKey = value;
	this.emit( 'updateSortkey', this.categories[name] );
};

/**
 * Sets popup state when popup is hidden
 */
ve.ui.MWCategoryWidget.prototype.onPopupHide = function () {
	this.popupState = false;
};

/**
 * Saves current popup state
 */
ve.ui.MWCategoryWidget.prototype.onSavePopupState = function () {
	this.savedPopupState = this.popupState;
};

/**
 * Toggles popup menu per category item
 * @param {Object} item
 */
ve.ui.MWCategoryWidget.prototype.onTogglePopupMenu = function ( item ) {
	// Close open popup.
	if ( this.savedPopupState === false || item.value !== this.popup.category ) {
		this.popup.openPopup( item );
	} else {
		// Handle toggle
		this.popup.closePopup();
	}
};

/** */
ve.ui.MWCategoryWidget.prototype.setDefaultSortKey = function ( value ) {
	this.popup.setDefaultSortKey( value );
};

/**
 * Get list of category names.
 *
 * @method
 * @param {string[]} List of category names
 */
ve.ui.MWCategoryWidget.prototype.getCategories = function () {
	return ve.getObjectKeys( this.categories );
};

/**
 * Adds category items.
 *
 * @method
 * @param {Object[]} items Items to add
 * @param {number} [index] Index to insert items after
 * @chainable
 */
ve.ui.MWCategoryWidget.prototype.addItems = function ( items, index ) {
	var i, len, item, categoryItem,
		categoryItems = [],
		existingCategoryItem = null;

	for ( i = 0, len = items.length; i < len; i++ ) {
		item = items[i];

		// Create a widget using the item data
		categoryItem = new ve.ui.MWCategoryItemWidget( { '$$': this.$$, 'item': item } );
		categoryItem.connect( this, {
			'savePopupState': 'onSavePopupState',
			'togglePopupMenu': 'onTogglePopupMenu'
		} );

		// Index item by value
		this.categories[item.value] = categoryItem;
		// Copy sortKey from old item when "moving"
		if ( existingCategoryItem ) {
			categoryItem.sortKey = existingCategoryItem.sortKey;
		}

		categoryItems.push( categoryItem );
	}

	ve.ui.GroupElement.prototype.addItems.call( this, categoryItems, index );

	this.fitInput();

	return this;
};

/**
 * Remove category items.
 *
 * @method
 * @param {string[]} names Names of categories to remove
 */
ve.ui.MWCategoryWidget.prototype.removeItems = function ( names ) {
	var i, len, categoryItem,
		items = [];

	for ( i = 0, len = names.length; i < len; i++ ) {
		categoryItem = this.categories[names[i]];
		categoryItem.disconnect( this );
		items.push( categoryItem );
		delete this.categories[names[i]];
	}

	ve.ui.GroupElement.prototype.removeItems.call( this, items );

	this.fitInput();
};

/**
 * Auto-fit the input.
 *
 * @method
 */
ve.ui.MWCategoryWidget.prototype.fitInput = function () {
	var gap, min, $lastItem,
		$input = this.input.$;

	if ( !$input.is( ':visible') ) {
		return;
	}

	$input.css( { 'width': 'inherit' } );
	min = $input.outerWidth();

	$input.css( { 'width': '100%' } );
	$lastItem = this.$.find( '.ve-ui-mwCategoryItemWidget:last' );
	if ( $lastItem.length ) {
		// Try to fit to the right of the last item
		gap = ( $input.offset().left + $input.outerWidth() ) -
				( $lastItem.offset().left + $lastItem.outerWidth() );
		if ( gap >= min ) {
			$input.css( { 'width': gap } );
		}
	}
};
