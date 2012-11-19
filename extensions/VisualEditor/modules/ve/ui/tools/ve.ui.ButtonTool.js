/**
 * VisualEditor user interface ButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.ButtonTool object.
 *
 * @abstract
 * @class
 * @constructor
 * @extends {ve.ui.Tool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.ButtonTool = function VeUiButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar );

	// Properties
	this.active = false;
	this.disabled = false;

	// Events
	this.$.on( {
		'mousedown': ve.bind( this.onMouseDown, this ),
		'mouseup': ve.bind( this.onMouseUp, this )
	} );

	// Initialization
	this.$.addClass( 've-ui-buttonTool ve-ui-icon-' + this.constructor.static.name );
};

/* Inheritance */

ve.inheritClass( ve.ui.ButtonTool, ve.ui.Tool );

/* Methods */

/**
 * Responds to the mouse button being pressed.
 *
 * @method
 * @param {jQuery.Event} e Normalized event
 */
ve.ui.ButtonTool.prototype.onMouseDown = function ( e ) {
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
ve.ui.ButtonTool.prototype.onMouseUp = function ( e ) {
	if ( e.which === 1 && !this.disabled ) {
		return this.onClick( e );
	}
};

/**
 * Responds to the button being clicked.
 *
 * This is an abstract method that must be overridden in a concrete subclass.
 *
 * @abstract
 * @method
 */
ve.ui.ButtonTool.prototype.onClick = function () {
	throw new Error(
		've.ui.ButtonTool.onClick not implemented in this subclass: ' + this.constructor
	);
};

/**
 * Responds to the toolbar state being cleared.
 *
 * @method
 */
ve.ui.ButtonTool.prototype.onClearState = function () {
	this.setActive( false );
};

/**
 * Checks if this button is active.
 *
 * @method
 * @param {Boolean} Button is active
 */
ve.ui.ButtonTool.prototype.isActive = function () {
	return this.active;
};

/**
 * Makes button appear active or inactive.
 *
 * @method
 * @param {Boolean} state Make button appear active
 */
ve.ui.ButtonTool.prototype.setActive = function ( state ) {
	this.active = !!state;
	if ( this.active ) {
		this.$.addClass( 've-ui-buttonTool-active' );
	} else {
		this.$.removeClass( 've-ui-buttonTool-active' );
	}
};

/**
 * Checks if this button is disabled.
 *
 * @method
 * @param {Boolean} Button is disabled
 */
ve.ui.ButtonTool.prototype.isDisabled = function () {
	return this.disabled;
};

/**
 * Disables button.
 *
 * This will change the button's appearance and prevent the {onClick} from being called.
 *
 * @method
 * @param {Boolean} state Disable button
 */
ve.ui.ButtonTool.prototype.setDisabled = function ( state ) {
	this.disabled = !!state;
	if ( this.disabled ) {
		this.$.addClass( 've-ui-buttonTool-disabled' );
	} else {
		this.$.removeClass( 've-ui-buttonTool-disabled' );
	}
};
