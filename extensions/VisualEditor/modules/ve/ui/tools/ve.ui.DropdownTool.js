/**
 * VisualEditor user interface DropdownTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.DropdownTool object.
 *
 * @abstract
 * @class
 * @constructor
 * @extends {ve.ui.Tool}
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object[]} items
 */
ve.ui.DropdownTool = function VeUiDropdownTool( toolbar, items ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar );

	// Properties
	this.menuView = new ve.ui.Menu( items, ve.bind( this.onMenuItemSelect, this ), null, this.$ );
	this.$icon = $( '<div class="ve-ui-dropdownTool-icon ve-ui-icon-down"></div>' );
	this.$label = $( '<div class="ve-ui-dropdownTool-label"></div>' );
	this.$labelText = $( '<span>&nbsp;</span>' );

	// Events
	$( document )
		.add( this.toolbar.getSurface().getView().$ )
		.mousedown( ve.bind( this.onBlur, this ) );
	this.$.on( {
		'mousedown': ve.bind( this.onMousedown, this ),
		'mouseup': ve.bind( this.onMouseup, this )
	} );

	// Initialization
	this.$
		.append( this.$icon, this.$label )
		.addClass( 've-ui-dropdownTool ve-ui-dropdownTool-' + this.constructor.static.name )
		.attr( 'title', ve.msg( this.constructor.static.titleMessage ) );
	this.$label.append( this.$labelText );
};

/* Inheritance */

ve.inheritClass( ve.ui.DropdownTool, ve.ui.Tool );

/* Methods */

/**
 * Responds to the mouse button being pressed.
 *
 * @method
 * @param {jQuery.Event} e Normalized event
 */
ve.ui.DropdownTool.prototype.onMousedown = function ( e ) {
	if ( e.which === 1 ) {
		e.preventDefault();
		return false;
	}
};

/**
 * Responds to the mouse button being released.
 *
 * @method
 * @param {jQuery.Event} e Normalized event
 */
ve.ui.DropdownTool.prototype.onMouseup = function ( e ) {
	if ( e.which === 1 ) {
		// Don't respond to menu clicks
		var $item = $( e.target ).closest( '.ve-ui-menu' );
		if ( e.which === 1 && $item.length === 0 ) {
			this.menuView.open();
		} else {
			this.menuView.close();
		}
	}
};

/**
 * Responds to focus being lost.
 *
 * The event is actually generated from a mousedown on an element outside the menu, so it is not
 * a normal blur event object.
 *
 * @method
 * @param {jQuery.Event} e Normalized event
 */
ve.ui.DropdownTool.prototype.onBlur = function ( e ) {
	if ( e.which === 1 ) {
		this.menuView.close();
	}
};

/**
 * Responds to one of the items in the menu being selected.
 *
 * This should not be overridden in subclasses, it simple connects events from the internal menu
 * to the onSelect method.
 *
 * @method
 * @param {Object} item Menu item
 */
ve.ui.DropdownTool.prototype.onMenuItemSelect = function ( item ) {
	this.setLabel( item.label );
	this.onSelect( item );
};

/**
 * Responds to dropdown option being selected.
 *
 * This is an abstract method that must be overridden in a concrete subclass.
 *
 * @abstract
 * @method
 * @param {Object} item Menu item
 */
ve.ui.DropdownTool.prototype.onSelect = function () {
	throw new Error(
		've.ui.DropdownTool.onSelect not implemented in this subclass:' + this.constructor
	);
};

/**
 * Responds to toolbar state being cleared.
 *
 * @method
 */
ve.ui.DropdownTool.prototype.onClearState = function () {
	this.setLabel();
};

/**
 * Sets the label.
 *
 * If the label value is empty, undefined or only contains whitespace an empty label will be used.
 *
 * @method
 * @param {jQuery|String} [value] jQuery HTML node selection or string text value to use for label
 */
ve.ui.DropdownTool.prototype.setLabel = function ( value ) {
	if ( typeof value === 'string' && value.length && /[^\s]*/.test( value ) ) {
		this.$labelText.text( value );
	} else if ( value instanceof jQuery ) {
		this.$labelText.empty().append( value );
	} else {
		this.$labelText.html( '&nbsp;' );
	}
};
