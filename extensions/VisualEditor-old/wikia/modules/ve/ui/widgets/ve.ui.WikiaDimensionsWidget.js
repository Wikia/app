/*!
 * VisualEditor UserInterface DimensionsWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Widget that visually displays width inputs.
 * This widget is for presentation-only, no calculation is done.
 *
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Object} [defaults] Default dimensions
 */
ve.ui.WikiaDimensionsWidget = function VeUiWikiaDimensionsWidget( config ) {
	// Configuration
	config = config || {};

	// Parent constructor
	ve.ui.WikiaDimensionsWidget.super.call( this, config );

	this.widthInput = new OO.ui.TextInputWidget( {
		'$': this.$
	} );

	this.defaults = config.defaults || { 'width': '' };
	this.renderDefaults();

	// Events
	this.widthInput.connect( this, { 'change': 'onWidthChange' } );

	// Setup
	this.$element
		.addClass( 've-ui-dimensionsWidget' )
		.append( this.widthInput.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaDimensionsWidget, OO.ui.Widget );

/* Events */

/**
 * @event widthChange
 * @param {string} value The new width
 */

/* Methods */

/**
 * Respond to width change, propagate the input change event
 * @param {string} value The new changed value
 * @fires widthChange
 */
ve.ui.WikiaDimensionsWidget.prototype.onWidthChange = function ( value ) {
	this.emit( 'widthChange', value );
};

/**
 * Set default dimensions
 * @param {Object} dimensions Default dimensions
 */
ve.ui.WikiaDimensionsWidget.prototype.setDefaults = function ( dimensions ) {
	if ( dimensions.width ) {
		this.defaults = ve.copy( dimensions );
		this.renderDefaults();
	}
};

/**
 * Render the default dimensions as input placeholders
 */
ve.ui.WikiaDimensionsWidget.prototype.renderDefaults = function () {
	this.widthInput.$input.attr( 'placeholder', this.getDefaults().width );
};

/**
 * Get the default dimensions
 * @returns {Object} Default dimensions
 */
ve.ui.WikiaDimensionsWidget.prototype.getDefaults = function () {
	return this.defaults;
};

/**
 * Remove the default dimensions
 */
ve.ui.WikiaDimensionsWidget.prototype.removeDefaults = function () {
	this.defaults = { 'width': '' };
	this.renderDefaults();
};

/**
 * Check whether the widget is empty.
 * @returns {boolean} Both values are empty
 */
ve.ui.WikiaDimensionsWidget.prototype.isEmpty = function () {
	return ( this.widthInput.getValue() === '' );
};

/**
 * Set an empty value for the dimensions inputs so they show
 * the placeholders if those exist.
 */
ve.ui.WikiaDimensionsWidget.prototype.clear = function () {
	this.widthInput.setValue( '' );
};

/**
 * Reset the dimensions to the default dimensions.
 */
ve.ui.WikiaDimensionsWidget.prototype.reset = function () {
	this.setDimensions( this.getDefaults() );
};

/**
 * Set the dimensions value of the inputs
 * @param {Object} dimensions The width values of the inputs
 * @param {number} dimensions.width The value of the width input
 */
ve.ui.WikiaDimensionsWidget.prototype.setDimensions = function ( dimensions ) {
	if ( dimensions.width ) {
		this.setWidth( dimensions.width );
	}
};

/**
 * Return the current dimension values in the widget
 * @returns {Object} dimensions The width values of the inputs
 * @returns {number} dimensions.width The value of the width input
 */
ve.ui.WikiaDimensionsWidget.prototype.getDimensions = function () {
	return {
		'width': this.widthInput.getValue()
	};
};

/**
 * Disable or enable the inputs
 * @param {boolean} isDisabled Set disabled or enabled
 */
ve.ui.WikiaDimensionsWidget.prototype.setDisabled = function ( isDisabled ) {
	// The 'setDisabled' method runs in the constructor before the
	// inputs are initialized
	if ( this.widthInput ) {
		this.widthInput.setDisabled( isDisabled );
	}
};

/**
 * Get the current value in the width input
 * @returns {string} Input value
 */
ve.ui.WikiaDimensionsWidget.prototype.getWidth = function () {
	return this.widthInput.getValue();
};

/**
 * Set a value for the width input
 * @param {string} value
 */
ve.ui.WikiaDimensionsWidget.prototype.setWidth = function ( value ) {
	this.widthInput.setValue( value );
};
