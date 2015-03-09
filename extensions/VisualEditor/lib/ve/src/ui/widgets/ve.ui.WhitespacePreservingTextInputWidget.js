/*!
 * VisualEditor UserInterface WhitespacePreservingTextInputWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Text input widget which hides but preserves leading and trailing whitespace
 *
 * @class
 * @extends OO.ui.TextInputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [valueAndWhitespace] Initial value and whitespace
 * @cfg {number} [limit] Maximum number of characters to preserve at each end
 */
ve.ui.WhitespacePreservingTextInputWidget = function VeUiWhitespacePreservingTextInputWidget( config ) {
	// Configuration
	config = config || {};

	// Parent constructor
	ve.ui.WhitespacePreservingTextInputWidget.super.call( this, config );

	this.limit = config.limit;

	this.whitespace = [ '', '' ];
	this.setValueAndWhitespace( config.valueAndWhitespace || '' );

	this.$element.addClass( 've-ui-WhitespacePreservingTextInputWidget' );
};

/* Inheritance */

OO.inheritClass( ve.ui.WhitespacePreservingTextInputWidget, OO.ui.TextInputWidget );

/* Methods */

/**
 * Set the value of the widget and extract whitespace.
 *
 * @param {string} value Value
 */
ve.ui.WhitespacePreservingTextInputWidget.prototype.setValueAndWhitespace = function ( value ) {
	var leftValue, rightValue;

	leftValue = this.limit ? value.slice( 0, this.limit ) : value;
	this.whitespace[0] = leftValue.match( /^\s*/ )[0];
	value = value.slice( this.whitespace[0].length );

	rightValue = this.limit ? value.slice( -this.limit ) : value;
	this.whitespace[1] = rightValue.match( /\s*$/ )[0];
	value = value.slice( 0, value.length - this.whitespace[1].length );

	this.setValue( value );
};

/**
 * Set the value of the widget and extract whitespace.
 *
 * @param {string[]} whitespace Outer whitespace
 */
ve.ui.WhitespacePreservingTextInputWidget.prototype.setWhitespace = function ( whitespace ) {
	this.whitespace = whitespace;
};

/**
 * @inheritdoc
 */
ve.ui.WhitespacePreservingTextInputWidget.prototype.getValue = function () {
	if ( !this.whitespace ) {
		// In case getValue() is called from a parent constructor
		return this.value;
	}
	return this.whitespace[0] + this.value + this.whitespace[1];
};

/**
 * Get the inner/displayed value of text widget, excluding hidden outer whitespace
 *
 * @return {string} Inner/displayed value
 */
ve.ui.WhitespacePreservingTextInputWidget.prototype.getInnerValue = function () {
	return this.value;
};
