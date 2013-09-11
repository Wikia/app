/*!
 * VisualEditor UserInterface IconTextButton class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface icon text button tool.
 *
 * @class
 * @extends ve.ui.DialogButtonTool
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.IconTextButtonTool = function VeUiIconTextButtonTool( toolbar, config ) {
	var label = this.constructor.static.label;

	// Parent constructor
	ve.ui.DialogButtonTool.call( this, toolbar, config );

	// Properties
	this.$label = this.$$( '<span>' ).addClass( 've-ui-iconTextButtonTool-label' ).text( label );

	// Initialization
	this.$
		.addClass( 've-ui-iconTextButtonTool' )
		.append( this.$label );
	this.$icon
		.addClass( 've-ui-iconTextButtonTool-icon' );
};

/* Inheritance */

ve.inheritClass( ve.ui.IconTextButtonTool, ve.ui.DialogButtonTool );

/* Static Properties */

ve.ui.IconTextButtonTool.static.label = 'zzz';

/* Methods */

/**
 * Set the label.
 *
 * If the label value is empty, undefined or only contains whitespace an empty label will be used.
 *
 * @method
 * @param {jQuery|string} [value] Label text
 * @chainable
 */
ve.ui.IconTextButtonTool.prototype.setLabel = function ( value ) {
	if ( typeof value === 'string' && value.length && /[^\s]*/.test( value ) ) {
		this.$labelText.text( value );
	} else if ( value instanceof jQuery ) {
		this.$labelText.empty().append( value );
	} else {
		this.$labelText.html( '&nbsp;' );
	}
	return this;
};
