/*!
 * VisualEditor UserInterface Widget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.Widget object.
 *
 * @class
 * @abstract
 * @extends ve.Element
 * @mixin ve.EventEmitter
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [disabled=false] Disable
 */
ve.ui.Widget = function VeUiWidget( config ) {
	// Initialize config
	config = ve.extendObject( { 'disabled': false }, config );

	// Parent constructor
	ve.Element.call( this, config );

	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.disabled = config.disabled;

	// Initialization
	this.$.addClass( 've-ui-widget' );
	this.setDisabled( this.disabled );
};

/* Inheritance */

ve.inheritClass( ve.ui.Widget, ve.Element );

ve.mixinClass( ve.ui.Widget, ve.EventEmitter );

/* Methods */

/**
 * Check if the widget is disabled.
 *
 * @method
 * @param {boolean} Button is disabled
 */
ve.ui.Widget.prototype.isDisabled = function () {
	return this.disabled;
};

/**
 * Set the disabled state of the widget.
 *
 * This should probably change the widgets's appearance and prevent it from being used.
 *
 * @method
 * @param {boolean} disabled Disable button
 * @chainable
 */
ve.ui.Widget.prototype.setDisabled = function ( disabled ) {
	this.disabled = !!disabled;
	if ( this.disabled ) {
		this.$.addClass( 've-ui-widget-disabled' );
	} else {
		this.$.removeClass( 've-ui-widget-disabled' );
	}
	return this;
};
