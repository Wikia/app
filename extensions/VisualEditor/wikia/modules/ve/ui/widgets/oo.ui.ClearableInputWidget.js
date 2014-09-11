/**
 * Text input widget with clear button.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
OO.ui.ClearableInputWidget = function OoUiClearableInputWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	OO.ui.ClearableInputWidget.super.call( this, config );

	// Properties
	this.$clearButton = this.$( '<div>' )
		.addClass( 'oo-ui-clearableInputWidget-clearButton' );

	// Events
	this.$clearButton.on( {
		'click': OO.ui.bind( this.onClearButtonClick, this )
	} );
	this.connect( this, { 'change': 'onClearableInputChange' } );

	// Initialization
	this.$element
		.addClass( 'oo-ui-clearableInputWidget' )
		.append( this.$clearButton );
};

/* Inheritance */

OO.inheritClass( OO.ui.ClearableInputWidget, OO.ui.TextInputWidget );

/* Methods */

/**
 * Handle clear button click event.
 */
OO.ui.ClearableInputWidget.prototype.onClearButtonClick = function () {
	this.setValue( '' );
	this.$clearButton.hide();
};

/**
 * Handle input change event.
 */
OO.ui.ClearableInputWidget.prototype.onClearableInputChange = function () {
	if ( this.getValue().length > 0 ) {
		this.$clearButton.show();
	} else {
		this.$clearButton.hide();
	}
};
