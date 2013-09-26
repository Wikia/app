/*!
 * VisualEditor UserInterface InputLabelWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.InputLabelWidget object.
 *
 * CSS classes will be added to the button for each flag, each prefixed with 've-ui-InputLabelWidget-'
 *
 * @class
 * @extends ve.ui.Widget
 * @mixins ve.ui.LabeledElement
 *
 * @constructor
 * @param {Object} [config] Config options
 * @cfg {ve.ui.InputWidget|null} [input] Related input widget
 */
ve.ui.InputLabelWidget = function VeUiInputLabelWidget( config ) {
	// Config intialization
	config = ve.extendObject( { 'input': null }, config );

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Mixin constructors
	ve.ui.LabeledElement.call( this, this.$, config );

	// Properties
	this.input = config.input;

	// Events
	this.$.on( 'click', ve.bind( this.onClick, this ) );

	// Initialization
	this.$.addClass( 've-ui-inputLabelWidget' );
};

/* Inheritance */

ve.inheritClass( ve.ui.InputLabelWidget, ve.ui.Widget );

ve.mixinClass( ve.ui.InputLabelWidget, ve.ui.LabeledElement );

/* Static Properties */

ve.ui.InputLabelWidget.static.tagName = 'label';

/* Methods */

/**
 * Handles mouse click events.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 */
ve.ui.InputLabelWidget.prototype.onClick = function () {
	if ( !this.disabled && this.input ) {
		this.input.$input.focus();
	}
	return false;
};
