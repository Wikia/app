/*!
 * VisualEditor UserInterface DimensionsWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Widget that visually displays width and height inputs.
 * This widget is for presentation-only, no calculation is done.
 *
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Object} [defaults] Default dimensions
 */
ve.ui.DimensionsWidget = function VeUiDimensionsWidget( config ) {
	var labelTimes, labelPx;

	// Configuration
	config = config || {};

	// Parent constructor
	OO.ui.Widget.call( this, config );

	this.widthInput = new OO.ui.TextInputWidget( {
		'$': this.$
	} );
	this.heightInput = new OO.ui.TextInputWidget( {
		'$': this.$
	} );

	this.defaults = config.defaults || { 'width': '', 'height': '' };
	this.renderDefaults();

	labelTimes = new OO.ui.LabelWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dimensionswidget-times' )
	} );
	labelPx = new OO.ui.LabelWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dimensionswidget-px' )
	} );

	// Events
	this.widthInput.connect( this, { 'change': 'onWidthChange' } );
	this.heightInput.connect( this, { 'change': 'onHeightChange' } );

	// Setup
	this.$element
		.addClass( 've-ui-dimensionsWidget' )
		.append( [
			this.widthInput.$element,
			labelTimes.$element
				.addClass( 've-ui-dimensionsWidget-label-times' ),
			this.heightInput.$element,
			labelPx.$element
				.addClass( 've-ui-dimensionsWidget-label-px' )
		] );
};

/* Inheritance */

OO.inheritClass( ve.ui.DimensionsWidget, OO.ui.Widget );

/* Events */

/**
 * @event widthChange
 * @param {string} value The new width
 */

/**
 * @event heightChange
 * @param {string} value The new width
 */

/* Methods */

/**
 * Respond to width change, propagate the input change event
 * @param {string} value The new changed value
 * @fires widthChange
 */
ve.ui.DimensionsWidget.prototype.onWidthChange = function ( value ) {
	this.emit( 'widthChange', value );
};

/**
 * Respond to height change, propagate the input change event
 * @param {string} value The new changed value
 * @fires heightChange
 */
ve.ui.DimensionsWidget.prototype.onHeightChange = function ( value ) {
	this.emit( 'heightChange', value );
};

/**
 * Set default dimensions
 * @param {Object} dimensions Default dimensions, width and height
 */
ve.ui.DimensionsWidget.prototype.setDefaults = function ( dimensions ) {
	if ( dimensions.width && dimensions.height ) {
		this.defaults = ve.copy( dimensions );
		this.renderDefaults();
	}
};

/**
 * Render the default dimensions as input placeholders
 */
ve.ui.DimensionsWidget.prototype.renderDefaults = function () {
	this.widthInput.$input.attr( 'placeholder', this.getDefaults().width );
	this.heightInput.$input.attr( 'placeholder', this.getDefaults().height );
};

/**
 * Get the default dimensions
 * @returns {Object} Default dimensions
 */
ve.ui.DimensionsWidget.prototype.getDefaults = function () {
	return this.defaults;
};

/**
 * Remove the default dimensions
 */
ve.ui.DimensionsWidget.prototype.removeDefaults = function () {
	this.defaults = { 'width': '', 'height': '' };
	this.renderDefaults();
};

/**
 * Check whether the widget is empty.
 * @returns {boolean} Both values are empty
 */
ve.ui.DimensionsWidget.prototype.isEmpty = function () {
	return (
		this.widthInput.getValue() === '' &&
		this.heightInput.getValue() === ''
	);
};

/**
 * Set an empty value for the dimensions inputs so they show
 * the placeholders if those exist.
 */
ve.ui.DimensionsWidget.prototype.clear = function () {
	this.widthInput.setValue( '' );
	this.heightInput.setValue( '' );
};

/**
 * Reset the dimensions to the default dimensions.
 */
ve.ui.DimensionsWidget.prototype.reset = function () {
	this.setDimensions( this.getDefaults() );
};

/**
 * Set the dimensions value of the inputs
 * @param {Object} dimensions The width and height values of the inputs
 * @param {number} dimensions.width The value of the width input
 * @param {number} dimensions.height The value of the height input
 */
ve.ui.DimensionsWidget.prototype.setDimensions = function ( dimensions ) {
	if ( dimensions.width ) {
		this.setWidth( dimensions.width );
	}
	if ( dimensions.height ) {
		this.setHeight( dimensions.height );
	}
};

/**
 * Return the current dimension values in the widget
 * @returns {Object} dimensions The width and height values of the inputs
 * @returns {number} dimensions.width The value of the width input
 * @returns {number} dimensions.height The value of the height input
 */
ve.ui.DimensionsWidget.prototype.getDimensions = function () {
	return {
		'width': this.widthInput.getValue(),
		'height': this.heightInput.getValue()
	};
};

/**
 * Disable or enable the inputs
 * @param {boolean} isDisabled Set disabled or enabled
 */
ve.ui.DimensionsWidget.prototype.setDisabled = function ( isDisabled ) {
	// The 'setDisabled' method runs in the constructor before the
	// inputs are initialized
	if ( this.widthInput ) {
		this.widthInput.setDisabled( isDisabled );
	}
	if ( this.heightInput ) {
		this.heightInput.setDisabled( isDisabled );
	}
};

/**
 * Get the current value in the width input
 * @returns {string} Input value
 */
ve.ui.DimensionsWidget.prototype.getWidth = function () {
	return this.widthInput.getValue();
};

/**
 * Get the current value in the height input
 * @returns {string} Input value
 */
ve.ui.DimensionsWidget.prototype.getHeight = function () {
	return this.heightInput.getValue();
};

/**
 * Set a value for the width input
 * @param {string} value
 */
ve.ui.DimensionsWidget.prototype.setWidth = function ( value ) {
	this.widthInput.setValue( value );
};

/**
 * Set a value for the height input
 * @param {string} value
 */
ve.ui.DimensionsWidget.prototype.setHeight = function ( value ) {
	this.heightInput.setValue( value );
};
