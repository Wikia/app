/*!
 * VisualEditor UserInterface LabeledElement class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Labeled element.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} $label Label element
 * @param {Object} [config] Configuration options
 * @cfg {jQuery|string} [label=''] Label text
 */
ve.ui.LabeledElement = function VeUiLabeledElement( $label, config ) {
	// Config intialization
	config = config || {};

	// Properties
	this.$label = $label;
	this.label = null;

	// Initialization
	this.$label.addClass( 've-ui-labeledElement-label' );
	this.setLabel( config.label );
};

/* Methods */

/**
 * Set the label.
 *
 * @method
 * @param {jQuery|string} [value] jQuery HTML node selection or string text value to use for label
 * @chainable
 */
ve.ui.LabeledElement.prototype.setLabel = function ( value ) {
	if ( typeof value === 'string' && value.trim() ) {
		this.$label.text( value );
		this.label = value;
	} else if ( value instanceof jQuery ) {
		this.$label.empty().append( value );
		this.label = value;
	} else {
		this.$label.html( '&nbsp;' );
		this.label = null;
	}
	return this;
};

/**
 * Get label value as plain text.
 *
 * @return {string} Label text
 */
ve.ui.LabeledElement.prototype.getLabelText = function () {
	return this.$label.text();
};

/**
 * Fit the label.
 *
 * @method
 * @chainable
 */
ve.ui.LabeledElement.prototype.fitLabel = function () {
	if ( this.$label.autoEllipsis ) {
		this.$label.autoEllipsis( { 'hasSpan': false, 'tooltip': true } );
	}
	return this;
};
